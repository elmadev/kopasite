<?php
session_start();
if(!$nonajax){
	include("../../kopasitedb.php");
	include("../functions.php");
	include("../login.php");
}
echo "<div id='newest'>";

if(isset($_GET['start'])){
	$start = $_GET['start'];
}else{
	$start = 0;
}

if($loggedin){
	$lim = 19;
}else{
	$lim = 11;
	echo "<p class='head red pad'>Welcome</p><div class='footer'></div>\n";
	echo "<p class='pad'>Kopasite is an Elasto Mania website which primary target (along with all sorts of resources for the game) is to host the competition on a large number of level packs of different kinds. Recordlists are interactive which means you can participate simple by uploading your replay from a level using the upload time button in the top right corner and they will instantly be updated. It should be noted that times are required to be driven in the online mode of <a href='http://beta.elmaonline.net'>Elma Online</a> for verification.<br/><input type='button' value='Register' id='register' class='reg'></p>";
}

echo "<p class='head red pad'>Newest Times</p><div class='footer'></div>\n";
echo "<table class='pad'>\n";
$limit = $start.",100";
//$result = mysql_query("SELECT level.LevelName, time.Time, time.TimeIndex, time.Apples, time.KuskiIndex, time.Driven, level.LevelIndex, time.Position FROM time, level WHERE time.LevelIndex = level.LevelIndex AND (time.EOLVerify = '1' OR time.Verify = '1') ORDER BY TimeIndex DESC LIMIT $limit");
$result = mysql_query("SELECT time.Time, time.TimeIndex, time.Apples, time.KuskiIndex, time.Driven, time.LevelIndex, time.Position, time.EOLVerify, time.Verify FROM time ORDER BY TimeIndex DESC LIMIT $limit");
$no = 0;
while($row = mysql_fetch_array($result)){
	if($row['EOLVerify'] == 0 && $row['Verify'] == 0){
		continue;
	}
	if($row['Position'] == 1){
		$new = "class='new'";
	}else{
		$new = "";
	}
	echo "<tr><td $new>".lev($row['LevelIndex'])."</td><td $new>".HsToStr($row['Time'], false, $row['TimeIndex'], $row['Apples'])."</td><td $new>".kuski($row['KuskiIndex'])."</td><td $new>".time_ago(strtotime($row['Driven']))."</td>";
	$improve = improv($row['KuskiIndex'], $row['Time'], $row['LevelIndex'], $row['Driven']);
	if(!$improve){
		$timeimp = "first time in lev";
		$posimp = "None >> " . ordanlize($row['Position']);
	}else{
		$timeimp = HsToStr($improve[1]) . " improvement";
		$posimp = ordanlize($improve[0]) . " >> " . ordanlize($row['Position']);
	}
	echo "<td class='grey'>$timeimp</td><td class='grey'>$posimp</td></tr>\n";
	$no++;
	if($no >= $lim){
		break;
	}
}
echo "<tr><td></td><td></td><td></td><td></td><td></td><td><input type='button' value='Next' id='next'></td></tr>";
echo "</table>\n";

$start = $start + $lim;
?>
<script>
$("#register").click(function () {
	window.location.href="/user/register/";
});
$("#next").click(function () {
	$('#newest').load('/ajax/index_newest_times.php?start=' + <?php echo $start; ?>);
});
</script>
<?php
echo "</div>";
?>