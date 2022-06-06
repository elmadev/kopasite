<?php
include("db.php");
$res = mysql_query("SELECT LevelIndex, LevelName, CRC, LongName, Apples, Killers, Flowers, Locked, SiteLock FROM level WHERE LevelIndex > '73009'");
while($row = mysql_fetch_array($res)){
	echo "INSERT INTO level (LevelIndex, LevelName, CRC, LongName, Apples, Killers, Flowers, Locked, SiteLock) VALUES('".$row['LevelIndex']."', '".$row['LevelName']."', '".$row['CRC']."', '".$row['LongName']."', '".$row['Apples']."', '".$row['Killers']."', '".$row['Flowers']."', '".$row['Locked']."', '".$row['SiteLock']."'), ";
}
echo ";";
?>