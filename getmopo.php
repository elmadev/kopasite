<?php

function StrToHs($time){
	if($time == ""){
		return "";
	}
	if(strlen($time) > 5){
		list($min, $sec) = explode(':', $time);
	}else{
		$sec = $time;
		$min = "";
	}
	list($sec, $hund) = explode(',', $sec);
	return $hund + ($sec*100) + ($min*100*60);
}

function kuski2id($kuski){
	$result = mysql_query("SELECT KuskiIndex FROM kuski WHERE Kuski = '$kuski'");
	if(mysql_num_rows($result) > 0){
		$row = mysql_fetch_array($result);
		return $row['KuskiIndex'];
	}else{
		return false;
	}
}

$des = false;
$des2 = false;
$pos = false;
$pos2 = false;
$lgr = false;
$lgr2 = false;

$lines = file('http://www.moposite.com/contests_kinglist_hoyla_mission.php');
$levname = "MCHM";

/*$lines = file('http://www.moposite.com/contests_kinglist_custom_levels.php');
$levname = "MOPC";
$des = true;
$des2 = true;*/

//$lines = file('http://www.moposite.com/contests_kinglist_lost_internals.php');
//$levname = "Lost";

/*$lines = file('http://www.moposite.com/contests_kinglist_mc_levels.php');
$levname = "MCLE";
$des = true;
$des2 = true;*/

//$lines = file('http://www.moposite.com/contests_kinglist_lgr_levels.php'); // manually!

//WCUP - manually!

//level of the month - missing?

//$lines = file('http://www.moposite.com/contests_official_levelpacks.php');
//$levname = "pa";

$time = 0;
$tid = "";
foreach ($lines as $line_num => $line) {
	$line = trim($line);
	if($line == ""){
		continue;
	}
	if($pos2){
		$lev = trim(strip_tags($line));
		$time = 1;
		$pos2 = false;
	}
	elseif($time == 5){
		$date = trim(strip_tags($line));
		//$date = trim(htmlspecialchars($line));
		//$date = str_replace("&lt;td class=&quot;bb&quot;&gt;", "", $date);
		//$date = str_replace("&lt;/td&gt;&lt;/tr&gt;", "", $date);
		if(!$nick = kuski2id($nick)){
			//Create user!
		}
		echo $lev . "-" . $nick . "[" . $team . "]-" . $nat . "-" . StrToHs($tid) . StrToHs($tid2) . "-" . date("Y-m-d H:i:s", strtotime($date)) . "<br/>\n";
		$time++;
	}
	elseif($time == 4){
		$tid = trim(strip_tags($line));
		//$tid = trim(htmlspecialchars($line));
		//$tid = str_replace("&lt;td class=&quot;bb&quot; style='color: #6F9BFF;'&gt;", "", $tid);
		//$tid = str_replace("&lt;td class=&quot;bb&quot;&gt;", "", $tid);
		//$tid = str_replace("&lt;/td&gt;", "", $tid);
		$time++;
	}
	elseif($time == 3){
		$nat = trim(htmlspecialchars($line));
		$nat = str_replace("&lt;td&gt;&lt;img src='images/flags/", "", $nat);
		//$nat = str_replace("' width='22' height='11' border='1' /&gt;&lt;/td&gt;", "", $nat);
		$nat = substr($nat, 0, 3);
		$tid2 = trim(strip_tags($line));
		if($tid2 != ""){
			$time++;
		}
		$time++;
	}
	elseif($time == 2){
		if($des){
			$des = false;
			continue;
		}
		$nick = trim(strip_tags($line));
		//$nick = trim(htmlspecialchars($line));
		//$nick = str_replace("&lt;td class=&quot;bb&quot;&gt;", "", $nick);
		//$nick = str_replace("&lt;/td&gt;", "", $nick);
		$nicks = explode("[", $nick);
		$nick = trim($nicks[0]);
		if(isset($nicks[1])){
			$team = substr($nicks[1], 0, -1);
		}else{
			$team = "";
		}
		$time++;
	}
	elseif($time == 1){
		$time++;
	}
    elseif(substr($line, 0, 8) == "<tr><td>"){
    	$lev = trim(strip_tags($line));
    	//$lev = trim(htmlspecialchars($line));
    	//$lev = str_replace("&lt;tr&gt;&lt;td class=&quot;bb&quot;&gt;", "", $lev);
		//$lev = str_replace("&lt;/td&gt;", "", $lev);
		$len = strlen($levname);
		if(strlen($lev) > 3 && substr($lev, 0, $len) == $levname){
			$time = 1;
			if($des2){
				$des = true;
			}
		}elseif($pos){
			$pos2 = true;
		}
    }
	elseif(substr($line, 0, 6) == "<td>pa"){
		$lev = trim(strip_tags($line));
		$time = 1;
	}
	else{
		$time = 0;
	}
}

?>