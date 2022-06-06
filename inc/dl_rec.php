<?php
include("../../kopasitedb.php"); 
include("../functions.php");
include("../login.php");
$recid = hax($_GET["rec"]);
$noaccess = true;
if($ki == 3){
	$noaccess = false;
}

$result = mysql_query("SELECT time.RecData, time.KuskiIndex, level.LevelName, time.Shared FROM time, level WHERE time.LevelIndex = level.LevelIndex AND time.TimeIndex = '$recid'");
$row = mysql_fetch_array($result);
if($ki == $row['KuskiIndex']){
	$noaccess = false;
}
if($row['Shared'] == 1){
	$noaccess = false;
}
if($noaccess){
	echo "You don't have access to this replay.";
}else{
	if($row['RecData'] == NULL){
		echo "Replay doesn't exist.";
	}else{
		$data = $row['RecData'];
		$name = $row['LevelName'] . kuski($row['KuskiIndex'], false, false);
		$name = substr(trim($name), 0, 15);
		$size = strlen($data);
		$type = "rec";

		header("Content-type: $type");
		header("Content-length: $size");
		header("Content-Disposition: attachment; filename=$name.rec");
		header("Content-Description: PHP Generated Data");
		echo $data;
	}
}
?>