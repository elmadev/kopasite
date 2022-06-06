<?php
include("getRecInfo.php");
if($GLOBALS['ki'] == 3){
	error_reporting(E_ALL ^ E_NOTICE);
}

$goahead = true;
if ($_FILES["file"]["error"] > 0){
	$error = "Error: " . $_FILES["file"]["error"] . "<br />\n";
	$goahead = false;
}

$blacklist = array(".php", ".phtml", ".php3", ".php4", ".js", ".shtml", ".pl", ".py", ".exe");
foreach ($blacklist as $file){
	if(preg_match("/$file\$/i", $_FILES["file"]["name"])){
		$error = "Error: Uploading executable files Not Allowed.\n";
		$goahead = false;
	}
}

if(!$loggedin){
	$error = "Error: Not logged in.\n";
	$goahead = false;
}

$path_parts = pathinfo($_FILES["file"]["name"]);
if($path_parts['extension'] == "zip"){
	$zipfile = true;
	$goahead = false;
}elseif($path_parts['extension'] != "rec"){
	$error = "File uploaded is not replay or zip file.\n";
	$goahead = false;
}

function uploadreplay($file, $filename, $more=false){
	list($level, $levext) = explode('.', getRecInfo($file, 'l'));

	//check some specific packs//
	if(substr($level,0,2) == "vz" && substr($level,2,1) != "h"){
		$level = "vzh" . substr($level,2,3);
	}
	// -

	$result = mysql_query("SELECT level.LevelName, level.CRC, level.LevelIndex, level.EOLIndex, levelpack.Apple FROM level, levelpack WHERE level.LevelPackIndex = levelpack.LevelPackIndex AND level.LevelName = '$level'");
	if(mysql_num_rows($result) < 1){
		$error = true;
		$GLOBALS['error'] .= "$filename.rec is not driven on a kopasite level (".$level.".lev).<br/>\n";
	}else{

		$row = mysql_fetch_array($result);

		$time = StrToHs(getRecInfo($file, "t", $row['LevelName']));
		$apples = NULL;
		$reccrc = getRecInfo($file, "c");

        $eolid = $row['EOLIndex'];
		if($row['CRC'] != $reccrc){
			$error = true;
			$GLOBALS['error'] .= "$filename.rec is driven on wrong version of the level (".$level.".lev).<br/>\n";
		}elseif($time == "" && !$_POST['secretarea']){
			if($row['Apple'] == 1){
				$apples = getRecInfo($file, "a", $row['LevelName']);
				$time = 999999;
				$levelindex = $row['LevelIndex'];
			}else{
				$error = true;
				$GLOBALS['error'] .= "$filename.rec is not finished (".$level.".lev).<br/>\n";
			}
		}else{
			$levelindex = $row['LevelIndex'];
		}
	}

	$path = $file;
	$recdata = addslashes(fread(fopen($path, "r"), filesize($path)));

	//secret areas
	if($_POST['secretarea']){
		if(!isset($error)){
			$result = mysql_query("SELECT KuskiIndex, LevelIndex, DateTime, RecData FROM secret_area WHERE KuskiIndex = '".$GLOBALS['ki']."' AND LevelIndex = '$levelindex'");
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result)){
					if(addslashes($row['RecData']) == $recdata){
						$error = true;
						$GLOBALS['error'] .= "$filename.rec already uploaded (".$level.".lev).<br/>\n";
					}
				}
			}
		}
		if(!isset($error)){
			mysql_query("INSERT INTO secret_area (KuskiIndex, LevelIndex, Datetime, RecData) VALUES('".$GLOBALS['ki']."', '$levelindex', '".date("Y-m-d H:i:s")."', '$recdata')");
			$success = "Secret area replay has been uploaded and is awaiting accept or reject from moderator.<br/>\n";
		}
	}else{
	// -

		$position = position($levelindex, $time, $apples);

		if(!isset($error)){
			$result = mysql_query("SELECT KuskiIndex, LevelIndex, Time, Driven, RecData, Apples FROM time WHERE KuskiIndex = '".$GLOBALS['ki']."' AND LevelIndex = '$levelindex' ORDER BY Time ASC, Apples DESC, Driven ASC");
			$ownpos = 1;
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result)){
					if($ownpos == 1){
						$oldtime = $row['Time'];
						$oldtime2 = $row['Apples'];
					}
					if($time < $row['Time'] or ($time == $row['Time'] && $apples > $row['Apples'])){
						break;
					}elseif($time == $row['Time'] && $apples == $row['Apples']){
						if(addslashes($row['RecData']) == $recdata){
							$error = true;
							$GLOBALS['error'] .= "$filename.rec already uploaded (".$level.".lev).<br/>\n";
						}else{
							$ownpos++;
						}
					}else{
						$ownpos++;
					}
				}
			}
		}

		/* include_once("classes/eol_api_class.php");
		$result = new EOLAPI;
		$result->levelid = array($eolid);
		$result->eoltime = $time;
        $result->timeformat = "hs";
		$result->kuski = $GLOBALS['k'];
		$exists = $result->verify();
        if($exists){
            $eolverify = 1;
           echo 1 . " " . $eolid . " " . $time . " " . $GLOBALS['k'];
        }else{
            $eolverify = 0;
            echo 0 . " " . $eolid . " " . $time . " " . $GLOBALS['k'];
        } */
        mysqli_select_db($GLOBALS["SQLI"], 'eol1') or die(mysql_error());
		if($GLOBALS['k'] == "Jeppe"){ $GLOBALS['k'] = "Britney"; }
        $res = mysql_query("SELECT TimeIndex FROM time, kuski WHERE time.KuskiIndex = kuski.KuskiIndex AND time.LevelIndex = '$eolid' AND kuski.Kuski ='".$GLOBALS['k']."' AND Time = '$time'");
        if(mysql_num_rows($res) > 0){
            $eolverify = 1;
        }else{
          $eolverify = 0;
        }
        mysqli_select_db($GLOBALS["SQLI"], 'kopasitenew') or die(mysql_error());


		if(!isset($error)){
			$driven = date("Y-m-d H:i:s");
			mysql_query("INSERT INTO time (KuskiIndex, LevelIndex, Time, Apples, Driven, Position, EOLVerify, RecData) VALUES('".$GLOBALS['ki']."', '$levelindex', '$time', '$apples', '".$driven."', '$position', '$eolverify', '$recdata')");
			$timeindex = mysql_insert_id();
			if($ownpos == 1 && $eolverify == 1){
				$res = mysql_query("SELECT BestTimeIndex FROM besttime WHERE LevelIndex = '$levelindex' AND KuskiIndex = '".$GLOBALS['ki']."'");
				if(mysql_num_rows($res) > 0){
					$r = mysql_fetch_array($res);
					$bestid = $r['BestTimeIndex'];
					mysql_query("UPDATE besttime SET Time = '$time', Apples = '$apples', Driven = '$driven', TimeIndex = '$timeindex', Position = '$position', Shared = '0' WHERE BestTimeIndex = '$bestid'") or die(mysql_error());
				}else{
					mysql_query("INSERT INTO besttime (TimeIndex, KuskiIndex, LevelIndex, Time, Apples, Driven, Position) VALUES('$timeindex', '".$GLOBALS['ki']."', '$levelindex', '$time', '$apples', '".$driven."', '$position')") or die(mysql_error());
				}
			}
			$GLOBALS['success'] .= "Upload of $filename.rec successful!<br/>\n";
			$GLOBALS['success'] .= "Level: <a href='/records/level/$level/'>$level</a><br/>\n";
			if($ownpos == 1){
				if($position == 1){
					$GLOBALS['sucesss'] .= "New Reocrd! Congratulations.<br/>\n";
				}else{
					if($eolverify == 0){
						$GLOBALS['success'] .= "Your time could not be verified in EOL database. <a href='$url/help/eol/'>More Info</a>.<br/>\n";
					}else{
						$GLOBALS['success'] .= "Your time is ".ordanlize($position)." position.<br/>\n";
					}
				}
				if($time == 999999){
					$GLOBALS['success'] .= "Time: <b>".$apples." apples</b>";
					if(isset($oldtime)){
						$GLOBALS['success'] .= " oldtime: ".$oldtime2." apples<br/>\n";
					}else{
						$GLOBALS['success'] .= "<br/>\n";
					}
				}else{
					$GLOBALS['success'] .= "Time: <b>".HsToStr($time)."</b>";
					if(isset($oldtime)){
						if($oldtime == 999999){
							$GLOBALS['success'] .= " oldtime: ".$oldtime2." apples<br/>\n";
						}else{
							$GLOBALS['success'] .= " oldtime: ".HsToStr($oldtime)."<br/>\n";
						}
					}else{
						$GLOBALS['success'] .= "<br/>\n";
					}
					$improv = $oldtime - $time;
					$GLOBALS['sucesss'] .= "Improved: ".HsToStr($improv);
				}
			}else{
				if($eolverify == 0){
					$GLOBALS['success'] .= "Your time could not be verified in EOL database. <a href='$url/help/eol/'>More Info</a>.<br/>\n";
				}else{
					$GLOBALS['success'] .= "This replay is your ".ordanlize($ownpos)." best time.<br/>\n";
				}
				$GLOBALS['success'] .= "Time: <b>".HsToStr($time)."</b> your best time: ".HsToStr($oldtime)."<br/>\n";
			}
			if($more){
				$GLOBALS['success'] .= "<br/>";
			}
			mysql_query("INSERT INTO updateschedule (LevelIndex) VALUES('$levelindex')");
		}
	}
}

if($zipfile){
	$zip = zip_open($_FILES["file"]["tmp_name"]);
	while($zipentry = zip_read($zip)){
		$entryname = zip_entry_name($zipentry);
		if(substr($entryname, -3, 3) != "rec" || zip_entry_filesize($zipentry) > 1000000){
			$error = "There is an unvalid file inside zip, too big or not replay file.\n";
		}else{
			$fp = fopen("[uploadRecFolder]/".$entryname, "w");
			if (zip_entry_open($zip, $zipentry, "r")) {
				$buf = zip_entry_read($zipentry, zip_entry_filesize($zipentry));
				fwrite($fp,"$buf");
				zip_entry_close($zipentry);
				fclose($fp);
				uploadreplay("[uploadRecFolder]/".$entryname, substr($entryname, 0, -4), true);
				unlink("[uploadRecFolder]/".$entryname);
				$morerecs = true;
			}
		}
	}
	zip_close($zip);
}

if($goahead){
	uploadreplay($_FILES["file"]["tmp_name"], $path_parts['filename']);
}

?>