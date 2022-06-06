<?php
include("../../kopasitedb.php"); 
include("../functions.php");
include("../login.php");
include("vars.php");
$recid = hax($_GET["rec"]);
$result = mysql_query("SELECT secret_area.RecData, secret_area.KuskiIndex, level.LevelName, secret_area.Accept FROM secret_area, level WHERE secret_area.LevelIndex = level.LevelIndex AND secret_area.SecretAreaIndex = '$recid'");
$row = mysql_fetch_array($result);
if($row['RecData'] == NULL){
	echo "Replay doesn't exist.";
}elseif($row['Accept'] == 0 && !in_array($ki, $kopa_secret)){
	echo "Replay not public yet.";
}else{
	$data = $row['RecData'];
	$name = $row['LevelName'] . "_S_" . kuski($row['KuskiIndex'], false, false);
	$name = substr(trim($name), 0, 15);
	$size = strlen($data);
	$type = "rec";

	header("Content-type: $type");
	header("Content-length: $size");
	header("Content-Disposition: attachment; filename=\"$name.rec\"");
	header("Content-Description: PHP Generated Data");
	echo $data;
}
?>