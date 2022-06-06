<?php
if(!$nonajax){
	include("../../kopasitedb.php");
	include("../functions.php");
	$packindex = hax($_GET['pack']);
	$all = hax($_GET['all']);
	if(!$all){
		$limit = "LIMIT 0,10";
	}
}else{
	$limit = "LIMIT 0,10";
}

$result = mysql_query("SELECT LevelIndex, LevelPackIndex, LevelName, LongName FROM level WHERE LevelPackIndex = '".$packindex."' ORDER BY LevelName ASC");
while($row = mysql_fetch_array($result)){
	echo "<table class='wide'>";
	echo "<tr><th colspan='3'>".lev($row['LevelName']).": ".$row['LongName']."</th></tr>";
	$resulttime = mysql_query("SELECT KuskiIndex, LevelIndex, Time, Driven, Apples, TimeIndex FROM besttime WHERE LevelIndex = '".$row['LevelIndex']."' ORDER BY Time ASC, Apples DESC, Driven ASC $limit");
	$no = 1;
	while($rowtime = mysql_fetch_array($resulttime)){
		if($no == 1){
			$numerouno = $rowtime['Time'];
		}
		$diff = $rowtime['Time'] - $numerouno;
		echo "<tr title='".$rowtime['Driven']." Difference to 1st: ".HsToStr($diff)."'><td>".$no.".</td><td>".HsToStr($rowtime['Time'], false, $rowtime['TimeIndex'], $rowtime['Apples'])."</td><td>".kuski($rowtime['KuskiIndex'])."</td></tr>";
		$no++;
	}
	echo "</table>";
}
?>