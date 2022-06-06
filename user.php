<?php
// 
// Settings
//
if($p == "settings"){
	echo "<p class='head3 red pad'>User Settings</p>\n";

	if($loggedin){

		echo "<div class='stdbox padtop'>\n";
		echo "<p class='head1 red'>User information</p>\n";
		echo "<table>\n";
		include_once("classes/db_kuski_class.php");
		$result = new Kuski;
		$result->where = "KuskiIndex = '$ki'";
		$data = $result->select();
		foreach($data as $row){
			echo "<tr><td>Nick:</td><td><input type='text' value='".$row['Kuski']."' name'nick' id='nick' /> <input type='button' value='Update' id='updatenick' class=''> <span id='shownick' class=''>".$row['Kuski']."</span></td></tr>\n";
			echo "<tr><td>Team:</td><td><input type='text' value='".$row['Team']."' name'team' id='team' /> <input type='button' value='Update' id='updateteam' class=''> <span id='showteam' class=''>".$row['Team']."</span></td></tr>\n";
			echo "<tr><td>Country:</td><td>".countryselect($loggedin, $kc)." <input type='button' value='Update' id='updatecountry' class=''> <span id='showcountry' class=''>".nation($row['Country'], false)."</span></td></tr>\n";
			echo "<tr><td>Mail:</td><td><input type='text' value='".$row['Email']."' name'mail' id='mail' /> <input type='button' value='Update' id='updatemail' class=''> <span id='showmail' class=''>".$row['Email']."</span></td></tr>\n";
			echo "<tr><td>Old Password:</td><td><input type='password' name'old' id='old' /></td></tr>\n";
			echo "<tr><td>New Password:</td><td><input type='password' name'new' id='new' /></td></tr>\n";
			echo "<tr><td>Repeat New:</td><td><input type='password' name'new2' id='new2' /> <input type='button' value='Update' id='updatepass' class=''> <span id='showpass' class=''></span></td></tr>\n";
		}
		echo "</table>\n";
		echo "</div>\n";

	}else{
		echo "<p class='pad'>Please log in to change your settings.</p>";
	}

	?>

	<script>
	$("#updatenick").click(function () {
		$('#shownick').load('/ajax/user_settings.php?type=nick&user=' + <?php echo $ki; ?> + '&val=' + $("#nick").val());
	});
	$("#updateteam").click(function () {
		$('#showteam').load('/ajax/user_settings.php?type=team&user=' + <?php echo $ki; ?> + '&val=' + $("#team").val());
	});
	$("#updatecountry").click(function () {
		$('#showcountry').load('/ajax/user_settings.php?type=country&user=' + <?php echo $ki; ?> + '&val=' + $("#country").val());
	});
	$("#updatemail").click(function () {
		$('#showmail').load('/ajax/user_settings.php?type=mail&user=' + <?php echo $ki; ?> + '&val=' + $("#mail").val());
	});
	$("#updatepass").click(function () {
		$('#showpass').load('/ajax/user_settings.php?type=pass&user=' + <?php echo $ki; ?> + '&val=' + $("#old").val() + '&new=' + $("#new").val() + '&new2=' + $("#new2").val());
	});
	</script>

<?php
//
// Register
//
}elseif($p == "register"){
	echo "<p class='head3 red pad'>Register</p>\n";
	if(!isset($t)){
		echo "<div class='stdbox padtop'>\n";
		echo "<table>\n";
		echo "<form method='post' action='$url/user/register/confirmation/'>";
		echo "<tr><td>Nick:</td><td><input type='text' name='nick' id='nick' /></td></tr>\n";
		echo "<tr><td>Team:</td><td><input type='text' name='team' id='team' /></td></tr>\n";
		echo "<tr><td>Country:</td><td>".countryselect(false, null)."</td></tr>\n";
		echo "<tr><td>Mail:</td><td><input type='text' name='mail' id='mail' /></td></tr>\n";
		echo "<tr><td>Password:</td><td><input type='password' name='new' id='new' /></td></tr>\n";
		echo "<tr><td>Repeat:</td><td><input type='password' name='new2' id='new2' /></td></tr>\n";
		echo "<tr><td>&nbsp;</td><td><input type='submit' value='Register' name='register'></td></tr>";
		echo "</form>";
		echo "</table>\n";
		echo "</div>\n";
	}elseif($t == "confirmation"){
		if(isset($_POST['register'])){
			if(userexists(hax($_POST['nick']))){
				$regerror .= "Nick is already taken.<br/>";
			}
			if(!isValidEmail($_POST['mail'])){
				$regerror .= "Mail adress is not valid.<br/>";
			}
			if($_POST['new'] != $_POST['new2']){
				$regerror .= "Passwords doesn't match.<br/>";
			}
			if(!$regerror){
				$code = randomPrefix(25);
				mysql_query("INSERT INTO kuski (Kuski, Team, Country, Email, Registered, Password) VALUES('".hax($_POST['nick'])."', '".hax($_POST['team'])."', '".hax($_POST['Country'])."', '".hax($_POST['mail'])."', '".date("Y-m-d H:i:s")."', '".md5(hax($_POST['new']))."')");
				$kuskiid = mysql_insert_id();
				/*mysql_query("INSERT INTO setting (KuskiIndex, SettingName, Setting) VALUES('$kuskiid', 'Confirm', '$code')");
				include_once("classes/mail_class.php");
				$send = new Email;
				$send->message = "Hello.\nYou have registered on Kopaiste.net with the username ".$_POST['nick']." and this email adress. In order to complete your registration please click the link below to confirm your email adress.\n\nhttp://kopasite.net/user/register/confirm/?code=".$code."&kid=".$kuskiid;
				$send->to = hax($_POST['mail']);
				$send->headline = "Kopasite registration confirmation";
				$send->from = "Kopasite";
				$send->frommail = "kopasite@gmail.com";
				if($send->sendMail()){
					echo "<p class='pad'>You have registered succesfully. You have been sent a confirmation email with a link which you need to click in order to complete the registration.</p>";
				}else{
					echo "<p class='pad'>You have registered succesfully. However the system failed to send confirmation email. Contact Kopasite for help.</p>";
				}*/
				echo "<p class='pad'>You have registered succesfully. This completes your registration. You can now login using the login box at your left.</p>";
			}else{
				echo "<p class='pad'>$regerror</p><br/><br/>";
			}
		}
	}elseif($t == "confirm"){
		$result = mysql_query("SELECT Setting, SettingIndex FROM setting WHERE KuskiIndex = ".hax($_GET['kid'])." AND SettingName = 'Confirm'");
		if(mysql_num_rows($result) > 0){
			if($row['Setting'] == hax($_GET['code'])){
				mysql_query("UPDATE kuski SET Confirmed = '1' WHERE KuskiIndex = '".hax($_GET['kid'])."'");
				echo "<p class='pad'>Your email has been confirmed, this completes your registration.</p><br/><br/>";
				mysql_query("DELETE FROM setting WHERE SettingIndex = '".$row['SettingIndex']."'");
			}else{
				echo "<p class='pad'>Wrong confirmation code.</p><br/><br/>";
			}
		}else{
			echo "<p class='pad'>User doesn't exist.</p><br/><br/>";
		}
	}
//
// Secret
//
}elseif($p == "secret" && in_array($ki, $kopa_secret)){
	include_once("classes/db_secret_area_class.php");
	if(isset($_POST['reject'])){
		$ins = new Secret_area;
		$fieldarray = array('Reject' => 1, 'SecretAreaIndex' => $_POST['secrid']);
		$ins->update($fieldarray);
	}elseif(isset($_POST['accept'])){
		$ins = new Secret_area;
		$fieldarray = array('Accept' => 1, 'SecretAreaIndex' => $_POST['secrid']);
		$ins->update($fieldarray);
	}

	echo "<div class='stdbox padtop'>\n";
	echo "<p class='head3 red'>Secret Area</p>\n";
	$result = new Secret_area;
	$result->orderby = "SecretAreaIndex ASC";
	$result->rows = "LevelIndex, KuskiIndex, DateTime, SecretAreaIndex";
	$result->where = "Accept = '0' AND Reject = '0'";
	$data = $result->select();
	echo "<table>\n";
	foreach($data as $row){
		echo "<tr><td>".lev($row['LevelIndex'])."</td><td>".kuski($row['KuskiIndex'], false)."</td><td>".$row['DateTime']."</td><td><a href='$url/inc/dl_secret_rec.php?rec=".$row['SecretAreaIndex']."'>Download</a></td><td><form method='post' action='$url/user/secret/'><input align='right' type='submit' value='Accept' name='accept' id='accept' class='stdbutt'></td><td><input align='right' type='submit' value='Reject' name='reject' id='reject' class='stdbutt'><input type='hidden' name='secrid' value='".$row['SecretAreaIndex']."'></form></td></tr>\n";
	}
	echo "</table></div>\n";

}elseif($p == "admin" && in_array($ki, $kopa_admins)){
	error_reporting(E_ALL ^ E_NOTICE);
	if(isset($_POST['addpack'])){
		mysql_query("INSERT INTO levelpack (KuskiIndex, LevelPackCategory, PackName, LongName, Description, Apple) VALUES('".kuski2id($_POST['KuskiIndex'])."', '".$_POST['LevelPackCategory']."', '".$_POST['PackName']."', '".hax($_POST['LongName'])."', '".hax($_POST['Description'])."', '".$_POST['Apple']."')") or die(mysql_error());
		$insid = mysql_insert_id();
		$amount = 0;
		$zip = zip_open($_FILES["levelzip"]["tmp_name"]);
		while($zipentry = zip_read($zip)){
			if(substr(zip_entry_name($zipentry), -3, 3) != "lev" || zip_entry_filesize($zipentry) > 1000000){
			}else{
				$amount++;
				$entry_name = zip_entry_name($zipentry);
				$fp = fopen("gk9s_G5g/".$entry_name, "w");
				if (zip_entry_open($zip, $zipentry, "r")) {
					$buf = zip_entry_read($zipentry, zip_entry_filesize($zipentry));
					fwrite($fp,"$buf");
					zip_entry_close($zipentry);
					fclose($fp);
					$crc = getLevCRC("gk9s_G5g/".$entry_name);
					$name = substr($entry_name, 0, -4);
					$recdata = addslashes(fread(fopen("gk9s_G5g/".$entry_name, "r"), filesize("gk9s_G5g/".$entry_name)));
					mysql_query("INSERT INTO level (LevelPackIndex, LevelName, CRC, LevelData) VALUES('$insid', '$name', '$crc', '$recdata')") or die(mysql_error());
					unlink("gk9s_G5g/".$entry_name);
				}
			}
		}
		zip_close($zip);
		mysql_query("UPDATE levelpack SET Amount = '$amount' WHERE LevelPackIndex = '$insid'") or die(mysql_error());
	}

	if(isset($_POST['reject'])){
		mysql_query("UPDATE time SET Verify = '2' WHERE TimeIndex = '".$_POST['timeid']."'");
	}elseif(isset($_POST['accept'])){
		mysql_query("UPDATE time SET Verify = '1' WHERE TimeIndex = '".$_POST['timeid']."'");
		$res = mysql_query("SELECT BestTimeIndex, Time FROM besttime WHERE LevelIndex = '".$_POST['levid']."' AND KuskiIndex = '".$_POST['kuskiid']."'");
		if(mysql_num_rows($res) > 0){
			$r = mysql_fetch_array($res);
			$bestid = $r['BestTimeIndex'];
			if($_POST['time'] < $r['Time']){
				mysql_query("UPDATE besttime SET Time = '".$_POST['time']."', Apples = '".$_POST['apples']."', Driven = '".$_POST['driven']."', TimeIndex = '".$_POST['timeid']."', Position = '".$_POST['posi']."' WHERE BestTimeIndex = '$bestid'") or die(mysql_error());
			}
		}else{
			mysql_query("INSERT INTO besttime (TimeIndex, KuskiIndex, LevelIndex, Time, Apples, Driven, Position) VALUES('".$_POST['timeid']."', '".$_POST['kuskiid']."', '".$_POST['levid']."', '".$_POST['time']."', '".$_POST['apples']."', '".$_POST['driven']."', '".$_POST['posi']."')") or die(mysql_error());
		}
	}elseif(isset($_POST['delete'])){
		mysql_query("DELETE FROM time WHERE TimeIndex = '".$_POST['timeid']."'");
	}

	echo "<div class='stdbox padtop'>\n";
	echo "<p class='head3 red'>Admin</p>\n";
	echo "<p class='head2 red'>Add Pack</p>\n";
	echo "<form method='post' enctype='multipart/form-data' action='$self'>\n";
	echo "Kuski: <input type='text' name='KuskiIndex' /><br/>\n";
	echo "Category: <input type='text' name='LevelPackCategory' /><br/>\n";
	echo "Pack Name<input type='text' name='PackName' /><br/>\n";
	echo "Long Name<input type='text' name='LongName' /><br/>\n";
	echo "Description <input type='text' name='Description' /><br/>\n";
	echo "Apple results <input type='text' name='Apple' /><br/>\n";
	echo "Levels in zip: <input type='file' name='levelzip'><input name='MAX_FILE_SIZE' value='7000000' type='hidden'><br/>";
	echo "<input type='submit' name='addpack' value='Add' /><br/>\n";
	echo "</form>\n";
	
	echo "<p class='head2 red'>Unverified times</p>\n";
	echo "<table>\n";
	$result = mysql_query("SELECT KuskiIndex, LevelIndex, Time, TimeIndex, Apples, Driven, Position FROM time WHERE TimeIndex > '41590' AND EOLVerify = '0' AND Verify = '0'");
	while($row = mysql_fetch_array($result)){
		echo "<tr><td>".kuski($row['KuskiIndex'])."</td><td>".lev($row['LevelIndex'])."</td><td>".HsToStr($row['Time'])."</td><td><form method='post' action='$url/user/admin/'><input align='right' type='submit' value='Accept' name='accept' id='accept' class='stdbutt'></td><td><input align='right' type='submit' value='Reject' name='reject' id='reject' class='stdbutt'></td><td><input align='right' type='submit' value='Delete' name='delete' id='delete' class='stdbutt'><input type='hidden' name='timeid' value='".$row['TimeIndex']."'><input type='hidden' name='levid' value='".$row['LevelIndex']."'><input type='hidden' name='kuskiid' value='".$row['KuskiIndex']."'><input type='hidden' name='time' value='".$row['Time']."'><input type='hidden' name='apples' value='".$row['Apples']."'><input type='hidden' name='driven' value='".$row['Driven']."'><input type='hidden' name='posi' value='".$row['Position']."'></form></td></tr>";
	}
	echo "</table>\n";

	echo "</div>\n";
}else{
	$four0four = true;
}

?>