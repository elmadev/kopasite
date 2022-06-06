<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	$packindex = hax($_GET['pack']);
}

echo "<table class='wide'>";
echo "<tr><th>Level</th><th>Kuski</th><th>Time</th></tr>";
$result = mysql_query("SELECT LevelIndex, LevelPackIndex, LevelName, LongName FROM level WHERE LevelPackIndex = '".$packindex."' ORDER BY LevelName ASC");
while($row = mysql_fetch_array($result)){
	$resulttime = mysql_query("SELECT KuskiIndex, LevelIndex, Time, Driven, Apples, TimeIndex FROM besttime WHERE LevelIndex = '".$row['LevelIndex']."' ORDER BY Time ASC, Apples DESC, Driven ASC LIMIT 0,1");
	$rowtime = mysql_fetch_array($resulttime);
	echo "<tr title='".$rowtime['Driven']."'><td>".lev($row['LevelName'])."</td><td>".kuski($rowtime['KuskiIndex'])."</td><td>".HsToStr($rowtime['Time'], false, $rowtime['TimeIndex'], $rowtime['Apples'])."</td></tr>";
}
echo "</table>";

?>