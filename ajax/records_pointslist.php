<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	$packindex = hax($_GET['pack']);
}

$points = array(1 => 40, 2 => 30, 3 => 25, 4 => 22, 5 => 20, 6 => 18, 7 => 16, 8 => 14, 9 => 12, 10 => 11, 11 => 10, 12 => 9, 13 => 8, 14 => 7, 15 => 6, 16 => 5, 17 => 4, 18 => 3, 19 => 2, 20 => 1);
$plist = array();
$result = mysql_query("SELECT LevelPackIndex, LevelIndex FROM level WHERE LevelPackIndex = '".$packindex."'");
while($row = mysql_fetch_array($result)){
	$no = 1;
	$resulttime = mysql_query("SELECT LevelIndex, Time, Driven, KuskiIndex FROM besttime WHERE LevelIndex = '".$row['LevelIndex']."' ORDER BY Time ASC, Apples DESC, Driven ASC LIMIT 0,20");
	while($rowtime = mysql_fetch_array($resulttime)){
		$kuski = $rowtime['KuskiIndex'];
		if(!isset($plist[$kuski])){
			$plist[$kuski] = $points[$no];
		}else{
			$plist[$kuski] = $plist[$kuski] + $points[$no];
		}
		$no++;
	}		
}
arsort($plist);
echo "<table class='wide'>";
echo "<tr><th colspan='2'>Points list</th></tr>";
foreach($plist as $kuski => $point){
	echo "<tr><td>".kuski($kuski)."</td><td>$point pts.</td></tr>";
}
echo "</table>";
?>