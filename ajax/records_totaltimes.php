<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	$packindex = hax($_GET['pack']);
}

$tts = array();
$ttscount = array();
$nooflevs = 0;
$recordstt = 0;
$result = mysql_query("SELECT LevelPackIndex, LevelIndex FROM level WHERE LevelPackIndex = '".$packindex."'");
while($row = mysql_fetch_array($result)){
	$no = 1;
	$resulttime = mysql_query("SELECT LevelIndex, Time, Driven, KuskiIndex FROM besttime WHERE LevelIndex = '".$row['LevelIndex']."' AND Time != '999999' ORDER BY Time ASC");
	while($rowtime = mysql_fetch_array($resulttime)){
		$kuski = $rowtime['KuskiIndex'];
		if(!isset($tts[$kuski])){
			$tts[$kuski] = $rowtime['Time'];
		}else{
			$tts[$kuski] = $tts[$kuski] + $rowtime['Time'];
		}
		if(!isset($ttscount[$kuski])){
			$ttscount[$kuski] = 1;
		}else{
			$ttscount[$kuski] = $ttscount[$kuski] + 1;
		}
		if($no == 1){
			$recordstt = $recordstt + $rowtime['Time'];
		}
		$no++;
	}
	$nooflevs++;
}
asort($tts);
echo "<table class='wide'>";
echo "<tr><th colspan='2'>Total Times</th></tr>";
echo "<tr><td>&nbsp;</td><td>Records</td><td>".HsToStr($recordstt)."</td></tr>";
$no = 1;
foreach($tts as $kuski => $tt){
	if($ttscount[$kuski] == $nooflevs){
		echo "<tr><td>$no.</td><td>".kuski($kuski)."</td><td>".HsToStr($tt)."</td></tr>";
		$no++;
	}
}
echo "</table>";
?>