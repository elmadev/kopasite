<?php

if(isset($_POST['login'])){
	$nick = hax($_POST["nick"]);
	$pass = hax($_POST["password"]);
	$pass = md5($pass);
	$login = confirmuser($pass, $nick);
	if($login == 1){
		echo "<p class='cp_txt'>No such username</p>";
		die;
	}
	if($login == 2){
		echo "<p class='cp_txt'>Wrong password</p>";
		die;
	}
	if($login == 3){
		echo "<p class='cp_txt'>Email not confirmed</p>";
		die;
	}
	if($login == 0){
		$_SESSION['kopanick'] = $nick;
		$_SESSION['kopapass'] = $pass;
		if($_POST["remember"] == "remember"){
			setcookie("kopanick", $_SESSION['kopanick'], time()+60*60*24*365, "/");
			setcookie("kopapass", $_SESSION['kopapass'], time()+60*60*24*365, "/");
		}else{
			setcookie("kopanick", $_SESSION['kopanick'], 0, "/");
			setcookie("kopapass", $_SESSION['kopapass'], 0, "/");
		}
		$loggedin = true;
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=$self\">";
	}
}
$loggedin = checklogin();

if(isset($_POST['logout'])){
	unset($_SESSION['kopanick']);
	unset($_SESSION['kopapass']);
	$_SESSION = array();
	setcookie("kopanick", "", time()-3600, "/");
	setcookie("kopapass", "", time()-3600, "/");
	echo "<meta http-equiv=\"Refresh\" content=\"0;url=$self\">";
}

//new pass
if(isset($_POST['newpass'])){
	$nick = hax($_POST["nick"]);
	$result = mysql_query("SELECT Kuski, KuskiIndex FROM kuski WHERE Kuski = '$nick'");
	$row = mysql_fetch_array($result);
	$kuskiindex = $row['KuskiIndex'];
	$newpassword = randomPrefix(10);

	$md5pass = md5($newpassword);
	mysql_query("UPDATE kuski SET Password = '$md5pass' WHERE KuskiIndex = '$kuskiindex'") or die(mysql_error());
	$success = "Your new password is: $newpassword";

	/*include_once("classes/mail_class.php");
	$send = new Email;
	$send->message = "You have requested a new password on Kopasite.\n\nNick: $nick\nNew Password: $newpassword";
	$send->to = $row['Email'];
	$send->headline = "Kopasite New Password Request";
	$send->from = "Kopasite";
	$send->frommail = "kopasite@gmail.com";
	if($send->sendMail()){
		$success = "A new password has been sent to your email adress ".$row['Email'];
	}else{
		$error = "fail";
	}*/
	$newpasssent = true;
}
//

//	SET kuski, team, kuskiindex as variables
if(isset($_SESSION['kopanick'])){
	$k = $_SESSION['kopanick'];
	$getk = mysql_query("SELECT Kuski, Team, KuskiIndex, Country FROM kuski WHERE Kuski = '$k'") or die(mysql_error());
	$rowk = mysql_fetch_array($getk);
	$ki = $rowk['KuskiIndex'];
	$kt = $rowk['Team'];
	$kc = $rowk['Country'];
}
//

?>