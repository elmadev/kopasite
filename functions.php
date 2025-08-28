<?php

foreach ($_FILES as $key => $value) {
	$GLOBALS[$key] = $value["tmp_name"];
	$GLOBALS[$key."_name"] = $value["name"];
  }
  
  function mysql_query($sql) {
	  if ($sql == null || $GLOBALS["SQLI"] == null) {
		  return null;
	  }
	return mysqli_query($GLOBALS["SQLI"], $sql);
  }
  
  function mysql_fetch_array($result) {
	  if ($result == null) {
		  return null;
	  }
	return mysqli_fetch_array($result);
  }
  
  function mysql_fetch_row($result) {
	  if ($result == null) {
		return null;
	  }
	return mysqli_fetch_row($result);
  }
  
  function mysql_affected_rows() {
	  if ($GLOBALS["SQLI"] == null) {
		  return null;
	  }
	return mysqli_affected_rows($GLOBALS["SQLI"]);
  }
  
  function mysql_error() {
	  if ($GLOBALS["SQLI"] == null) {
		  return null;
	  }
	return mysqli_error($GLOBALS["SQLI"]);
  }
  
  function split($split, $text) {
	return preg_split("/".$split."/", $text);
  }
  
  function ereg($pat, $text) {
	return preg_match("/".$pat."/", $text);
  }
  function mysql_num_rows($result) {
	  if ($result == null) {
		return null;
	  }
	  return mysqli_num_rows($result);
  }
  function mysql_errno() {
	  if ($GLOBALS["SQLI"] == null) {
		  return null;
	  }
	  return mysqli_errno($GLOBALS["SQLI"]);
  }
  function mysql_fetch_assoc($result) {
	  if ($result == null) {
		  return null;
	  }
	  return mysqli_fetch_assoc($result);
  }
  function mysql_free_result($result) {
	if ($result == null) {
		return null;
	}
	return mysqli_free_result($result);
}
function mysql_insert_id() {
	if ($GLOBALS["SQLI"] == null) {
		return null;
	}
	return mysqli_insert_id($GLOBALS["SQLI"]);
}
function mysql_connect($host, $username, $password, $new_link = false, $client_flags = 0) {
    return $GLOBALS["SQLI"];
}

function mysql_select_db($database_name, $link_identifier = null) {
    if ($link_identifier === null) {
        $link_identifier = $GLOBALS["SQLI"];
    }
    return mysqli_select_db($link_identifier, $database_name);
}

function mysql_real_escape_string($unescaped_string, $link_identifier = null) {
    if ($link_identifier === null) {
        $link_identifier = $GLOBALS["SQLI"];
    }
    return mysqli_real_escape_string($link_identifier, $unescaped_string);
}

///// ****
//            Login and Register
///// ****
function confirmuser($pass, $nick){
	$result = mysql_query("SELECT Password, Confirmed FROM kuski WHERE Kuski = '$nick'") or die(mysql_error());
	if(mysql_num_rows($result) < 1){
		return 1;
	}
	$row = mysql_fetch_array($result);
	$rightpass = $row['Password'];
	if($row['Confirmed'] == 0){
		return 3;
	}elseif($rightpass == $pass){
		return 0;
	}else{
		return 2;
	}
}

function checklogin(){
	if(isset($_COOKIE['kopanick']) && isset($_COOKIE['kopapass'])){
		$login = confirmuser($_COOKIE['kopapass'], $_COOKIE['kopanick']);
		if($login == 0){
			$_SESSION['kopanick'] = $_COOKIE['kopanick'];
			$_SESSION['kopapass'] = $_COOKIE['kopapass'];
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function userexists($nick){
	$result = mysql_query("SELECT Kuski FROM kuski WHERE Kuski = '$nick'");
	if(mysql_num_rows($result) > 0){
		return true;
	}else{
		return false;
	}
}

///// ****
//            Random
///// ****
function hax( $value ){
	if($value == NULL){
		return NULL;
	}else{
		$value = addslashes($value);
		return $value;
	}
}

function getLevCRC($filename) {
	/* $f is a file pointer to the filename */
	$f = fopen($filename, "r");
	/* Read 7 bytes of crap */
	fread($f, 7);
	/* CRC is the next 4 bytes */
	$crc = bin2hex(fread($f, 4));
	return $crc;
}


function bbcode($text, $usertags = ""){
	$tags = array(
	'b','i','u','url','small','big','p','center','color','size','img');
	// If user doesn't specify tags, we'll replace all
	if($usertags == "") {
		$usertags = $tags;
	}
	// Checking that usertags contains unknown for us BBCode
	$diff = array_diff($usertags,$tags);
	// If yes
	if(count($diff))
		throw new Exception("Unknown tag:".join(' ',$diff));
	// Deleting spaces from begging and end of string
	$done = trim($text);
	// Deleting all html code
	//$done = htmlspecialchars($done);
	if(in_array("url",$usertags)) {
		$done = preg_replace("#\[url\](.*?)?(.*?)\[/url\]#si", "<A HREF=\"\\1\\2\" TARGET=\"_blank\">\\1\\2</A>", $done);
		$done = preg_replace("#\[url=(.*?)?(.*?)\](.*?)\[/url\]#si", "<A HREF=\"\\2\" TARGET=\"_blank\">\\3</A>", $done);
	}
	if(in_array("b",$usertags))
		$done = preg_replace("#\[b\](.*?)\[/b\]#si", "<b>\\1</b>", $done);
	if(in_array("i",$usertags))
		$done = preg_replace("#\[i\](.*?)\[/i\]#si", "<i>\\1</i>", $done);
	if(in_array("u",$usertags))
		$done = preg_replace("#\[u\](.*?)\[/u\]#si", "<u>\\1</u>", $done);
	if(in_array("small",$usertags))
		$done = preg_replace("#\[small\](.*?)\[/small\]#si", "<small>\\1</small>", $done);
	if(in_array("big",$usertags))
		$done = preg_replace("#\[big\](.*?)\[/big\]#si", "<big>\\1</big>", $done);
	if(in_array("p",$usertags))
		$done = preg_replace("#\[p\](.*?)\[\/p\]#si", "<p>\\1</p>", $done);
	if(in_array("center",$usertags))
		$done = preg_replace("#\[center\](.*?)\[\/center\]#si", "<p align=\"center\">\\1</p>", $done);
	if(in_array("color",$usertags))
		$done = preg_replace("#\[color=(http://)?(.*?)\](.*?)\[/color\]#si", "<span style=\"color:\\2\">\\3</span>", $done);
	if(in_array("size",$usertags))
		$done = preg_replace("#\[size=(http://)?([0-9]{0,2})\](.*?)\[/size\]#si", "<span style=\"font-size:\\2px\">\\3</span>", $done);
	if(in_array("img",$usertags))
		$done = preg_replace("#\[img\](.*?)\[/img\]#si", "<img src=\"\\1\" border=\"0\" alt=\"Image\" />", $done);
	// Changing [enter] to <br />
	$done = nl2br($done);
	return $done;
}

function isValidEmail($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function countryselect($loggedin, $kc){
	$echo .= "<select name='country' id='country'>";
	$result = mysql_query("SELECT Iso, Name FROM country") or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$iso = $row['Iso'];
		$name = $row['Name'];
		if(strlen($name) > 18){
			$name = substr($name,0,15) . "...";
		}
	  $echo .= "<option value='$iso'" . ($loggedin && $kc == $iso ? " selected='selected'" : "") . ">$name</option>";
	}
	$echo .= "</select>";
	return $echo;
}

function upperfirst($string){
	$string = strtolower($string);
	$string = substr_replace($string, strtoupper(substr($string, 0, 1)), 0, 1);
	$string = str_replace("_", " ", "$string");
	return "$string";
}

function mysql2timestamp($datetime){
       $val = explode(" ",$datetime);
       $date = explode("-",$val[0]);
       $time = explode(":",$val[1]);
       return mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
}

function newsdate($datetime){
	$timestamp = mysql2timestamp($datetime);
	$day = date("j", $timestamp);
	$weekday = date("l", $timestamp);
	$month = date("F", $timestamp);
	$year = date("Y", $timestamp);
	return "$weekday $day $month $year";
}

function kuski($kuskiindex, $long=true, $link=true, $deco=null){
	$result = mysql_query("SELECT Kuski, KuskiIndex, Team FROM kuski WHERE KuskiIndex = '$kuskiindex'");
	$row = mysql_fetch_array($result);
	if($deco != NULL){
		$deco = " class='$deco'";
	}
	if(!$long){
		if(!$link){
			return $row['Kuski'];
		}else{
			return "<a".$deco." href='".$GLOBALS['url']."/records/player/".$row['Kuski']."'>".$row['Kuski']."</a>";
		}
	}else{
		if(!$link){
			if($row['Team'] == NULL){
				return $row['Kuski'];
			}else{
				return $row['Kuski'] . " [" . $row['Team'] . "]";
			}
		}else{
			if($row['Team'] == NULL){
				return "<a".$deco." href='".$GLOBALS['url']."/records/player/".$row['Kuski']."'>".$row['Kuski']."</a>";
			}else{
				return "<a".$deco." href='".$GLOBALS['url']."/records/player/".$row['Kuski']."'>".$row['Kuski']."</a> [<a".$deco." href='".$GLOBALS['url']."/records/team/".$row['Team']."'>" . $row['Team'] . "</a>]";
			}
		}
	}
}

function kuski2id($kuski){
	$result = mysql_query("SELECT KuskiIndex FROM kuski WHERE Kuski = '$kuski'");
	$row = mysql_fetch_array($result);
	return $row['KuskiIndex'];
}

function randomPrefix($length, $case=false){
	$random= "";

	srand((double)microtime()*1000000);

	if($case){
		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";
	}else{
		$data = "bc12367";
		$data .= "adefghijklmn123opq45rs67tuv89wxyz";
		$data .= "04589";
	}

	for($i = 0; $i < $length; $i++){
		$random .= substr($data, (rand()%(strlen($data))), 1);
	}

	return $random;
}

function ordanlize($number){
    if (!is_numeric($number))
        {
        return $number; // return if the argument is not a valid number
        }
    if ($number >= 11 and $number <= 19)
        {
        $attach = "th";
        }
    elseif ( $number % 10 == 1 )
        {
        $attach = "st";
        }
    elseif ( $number % 10 == 2 )
        {
        $attach = "nd";
        }
    elseif ( $number % 10 == 3 )
        {
        $attach = "rd";
        }
    else
        {
        $attach = "th";
        }
    return $number.$attach;
}

function mailimg($mail){
	return "<img src='$url/inc/email.php?mail=$mail' />";
}

///// ****
//            Date and time manipulation
///// ****

function time_ago($tm,$rcs = 0) {
	if($tm == 0 or $tm == "" or $tm < 0){
		return NULL;
	}else{
		$cur_tm = time(); $dif = $cur_tm-$tm;
		$pds = array('second','minute','hour','day','week','month','year','decade');
		$lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
		for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

		$no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
		if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
		return substr($x,0,-1);
	}
}

function getsize($size){
	$si = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $si[$i];
}



///// ****
//            Elma times manipulation
///// ****

/**
 *  Format a time in hundreds of a sec format
 *
 *  @param                     Time in 00:00,00 format
 *  @return int                Time in hundreds of sec
 */
function StrToHs($time){
	list($min, $sec) = explode(':', $time);
	list($sec, $hund) = explode(',', $sec);
	return $hund + ($sec*100) + ($min*100*60);
}

/**
 *  Format a time in 00:00,00 format
 *
 *  @param                     Time in hundreds of sec
 *  @return string             Time in 00:00,00 format
 */
function HsToStr($time, $full=false, $link=false, $apples=0, $by=9999999999, $shared=0) {
	if($time == NULL){
		return NULL;
	}else{
		if($link != false){
			if($GLOBALS['ki'] == 3 or $GLOBALS['ki'] == $by or $shared == 1){
				$ret .= "<a href='".$GLOBALS['url']."/inc/dl_rec.php?rec=".$link."'>";
			}
		}
		if($apples != 0){
			$ret .= $apples." apples";
		}else{
			if($time < 0){
				$neg = "-";
			}
			$time = abs($time);
			$milli = $time%100;
			$secs = (int)($time/100)%60;
			$minutes = (int)($time/6000)%60;
			$hours = (int)($time/360000);
			if($full){
				$ret .= $neg . sprintf("%02d:%02d,%02d", $minutes, $secs, $milli);
			}else{
				if($hours > 0){
					$ret .= $neg . sprintf("%d:%02d:%02d,%02d", $hours, $minutes, $secs, $milli);
				}elseif($minutes > 0){
					$ret .= $neg . sprintf("%d:%02d,%02d", $minutes, $secs, $milli);
				}else{
					$ret .= $neg . sprintf("%d,%02d", $secs, $milli);
				}
			}
		}
		if($link != false){
			if($GLOBALS['ki'] == -1 or $GLOBALS['ki'] == $by or $shared == 1){
				$ret .= "</a>";
			}
		}
		return $ret;
	}
}


///// ****
//            Checking stuff in database
///// ****

function position($level, $time, $apples=null){
	$result = mysql_query("SELECT Time, KuskiIndex, LevelIndex, Apples FROM besttime WHERE LevelIndex = '$level' AND KuskiIndex != '".$GLOBALS['ki']."' ORDER BY Time ASC, Apples DESC, Driven ASC");
	$no = 1;
	while($row = mysql_fetch_array($result)){
		if($row['Time'] == 999999){
			if($row['Apples'] > $apples){
				break;
			}
		}else{
			if($time < $row['Time']){
				break;
			}
		}
		$no++;
	}
	return $no;
}

function improv($kuski, $time, $level, $driven){
	$result = mysql_query("SELECT Time, Position, Apples FROM time WHERE KuskiIndex = '$kuski' AND LevelIndex = '$level' AND Driven < '$driven' ORDER BY Time ASC, Driven ASC LIMIT 0,1");
	if(mysql_num_rows($result) > 0){
		$row = mysql_fetch_array($result);
		if($row['Apples'] != 0){
			return array($row['Position'], "");
		}else{
			$improv = $row['Time'] - $time;
			return array($row['Position'], $improv);
		}
	}else{
		return false;
	}
	
}

///// ****
//            Page links
///// ****

function upurl($filename, $dup, $code){
	$filename = str_replace(" ", "%20", $filename);
	if($code == null){
		return $GLOBALS['url']."/up/".$dup."/".$filename;
	}else{
		return $GLOBALS['url']."/up/".$code."/".$filename;
	}
}

function lev($lname, $nolink=false){
	if(is_numeric($lname)){
		$result = mysql_query("SELECT LevelName, LevelIndex FROM level WHERE LevelIndex = '$lname'");
		$row = mysql_fetch_array($result);
		$lname = $row['LevelName'];
	}
	if($nolink){
		return $lname;
	}else{
		return "<a href='".$GLOBALS['url']."/records/level/".$lname."'>".$lname."</a>";
	}
}

function levpack($pack, $type=false){
	if(is_numeric($pack)){
		$result = mysql_query("SELECT LevelPackIndex, PackName, LongName FROM levelpack WHERE LevelPackIndex = '$pack'");
		$row = mysql_fetch_array($result);
		$short = $row['PackName'];
		if($type == "short"){
			$pack = $row['PackName'];
		}elseif($type == "long"){
			$pack = $row['LongName'];
		}
	}else{
		$short = $pack;
	}
	return "<a href='".$GLOBALS['url']."/records/pack/".$short."'>".$pack."</a>";
}

function nation($nat, $link=true){
	$result = mysql_query("SELECT Iso, Name FROM country WHERE Iso = '$nat'");
	$row = mysql_fetch_array($result);
	if($link == false){
		return $row['Name'];
	}else{
		return "<a href='".$GLOBALS['url']."/records/country/".$nat."'>" . $row['Name'] . "</a>";
	}
}

function team($team){
	return "<a href='".$GLOBALS['url']."/records/team/".$team."'>".$team."</a>";
}


///// ****
//            Echo Stuff
///// ****

function headline($title){
	echo "<p class='head red pad'>".$title."</p><div class='footer'></div>\n";
}

?>