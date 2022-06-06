<?php
if(!$nonajax){
	include("../../kopasitedb.php");
	include("../functions.php");
	$lev = hax($_GET['lev']);
    $levname = hax($_GET['levname']);
	$all = hax($_GET['all']);
}
if($all){
	$seltable = "time";
	$headline = "All Times";
	$ver = " AND (time.EOLVerify = '1' OR time.Verify = '1')";
}else{
	$seltable = "besttime";
	$headline = "Best Times";
}

echo "<div class='stdboxleft padtop'>\n";
echo "<table>\n";
echo "<tr><th colspan='3'>$headline</th></tr>\n";
$no = 1;
$result = mysql_query("SELECT LevelIndex, Time, Driven, KuskiIndex, TimeIndex, Apples FROM $seltable WHERE LevelIndex = '".$lev."'".$ver." ORDER BY Time ASC, Apples DESC, Driven ASC");
while($row = mysql_fetch_array($result)){
	if($no == 1){
		$numerouno = $row['Time'];
	}
	$diff = $row['Time'] - $numerouno;
	$new = "";
	if($row['Driven'] > date("Y-m-d H:i:s", (time() - 2592000))){
		$new = "new";
	}
	echo "<tr  class='$new' title='".$row['Driven']." Difference to 1st: ".HsToStr($diff)."'><td>$no.</td><td>".HsToStr($row['Time'], false, $row['TimeIndex'], $row['Apples'])."</td><td>".kuski($row['KuskiIndex'])."</td></tr>\n";
	$no++;
}
echo "</table>\n";
echo "</div>\n";

echo "<div class='stdboxright padtop'>\n";
echo "<table>\n";
echo "<tr><th>Map</th></tr>\n";
echo "<tr><td class='center'><img src='../inc/domimap.php?lev=$levname'></td></tr>\n";
echo "</table>\n";

echo "<table>\n";
echo "<tr><th>Record History</th></tr>\n";
$rechis = array();
$best = 99999999999999999;
$no = 0;
$result = mysql_query("SELECT * FROM time WHERE LevelIndex = '".$lev."' ORDER BY Driven ASC");
while($row = mysql_fetch_array($result)){
	if($row['Time'] < $best){
		$rechis[$no]['time'] = $row['Time'];
		$rechis[$no]['kuski'] = $row['KuskiIndex'];
		$rechis[$no]['driven'] = $row['Driven'];
		$best = $row['Time'];
		$no++;
	}
}
krsort($rechis);
foreach($rechis as $r){
	$dato = substr($r['driven'],0,10);
	if($dato == "0000-00-00"){
		$dato = "?";
	}
	echo "<tr><td>".$dato."</td><td>".HsToStr($r['time'])."</td><td>".kuski($r['kuski'])."</td></tr>\n";
}
echo "</table>\n";
echo "</div>\n";

?>