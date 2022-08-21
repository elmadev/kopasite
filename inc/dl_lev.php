<?php
include("../kopasitedb.php"); 
include("../functions.php");
$levid = hax($_GET["lev"]);
$result = mysql_query("SELECT LevelIndex, LevelData, LevelName FROM level WHERE LevelIndex = '$levid'") or die(mysql_error());
$row = mysql_fetch_array($result);
$data = $row['LevelData'];
$name = $row['LevelName'];
$size = strlen($data);
$type = "lev";

header("Content-type: $type");
header("Content-length: $size");
header("Content-Disposition: attachment; filename=$name.lev");
header("Content-Description: PHP Generated Data");
echo $data;
?>