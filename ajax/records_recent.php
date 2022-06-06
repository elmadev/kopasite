<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	$packindex = hax($_GET['pack']);
}

echo "<table class='wide'>";
echo "<tr><th colspan='2'>Most recent activity</th></tr>";
$result = mysql_query("SELECT level.LevelIndex, time.LevelIndex, level.LevelPackIndex, time.Driven, time.Time, time.Apples, time.TimeIndex, level.LevelName, time.KuskiIndex FROM level, time WHERE level.LevelIndex = time.LevelIndex AND level.LevelPackIndex = '".$packindex."' ORDER BY time.Driven DESC LIMIT 0,15");
while($row = mysql_fetch_array($result)){
	echo "<tr><td>".time_ago(strtotime($row['Driven'])).": ".HsToStr($row['Time'], false, $row['TimeIndex'], $row['Apples'])." in ".lev($row['LevelName'])." by ".kuski($row['KuskiIndex'], false)."</td></tr>";
}
echo "</table>";
?>