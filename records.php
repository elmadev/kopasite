<?php
//
// LEVEL PACKS
//
if($p == "pack" && isset($t)){

	$result = mysql_query("SELECT * FROM levelpack WHERE PackName = '$t'");
	$rowp = mysql_fetch_array($result);

	echo "<p class='head3 red pad'>".$rowp['LongName']." by ".kuski($rowp['KuskiIndex'])."\n";
	echo "<input type='button' onClick=\"parent.location='$url/dl/".$rowp['PackName'].".zip'\" value='Download Level Pack' id='dlpack' class='stdbutt' /></p>\n";

	echo "<p class='head3 pad'>Description</p>\n";
	echo "<p class='pad'>".$rowp['Description']."</p>\n";

	echo "<div class='stdboxleft'>\n";

?>
	<div class="padbutt floatl"><input type="button" value="Best Times" id="besttime" class="stdbutt selbutt"></div>
	<div class="padbutt floatl"><input type="button" value="Top 10s" id="topten" class="stdbutt"></div>
	<div class="padbutt floatl"><input type="button" value="All" id="all" class="stdbutt"></div>
	<div class="padbutt floatl"><input type="button" value="Talk" id="talk" class="stdbutt"></div>
<?php

	echo "<div id='levelpack' class='floatl wide'>\n";
	$packindex = $rowp['LevelPackIndex'];
	$nonajax = true;
	include("ajax/records_besttime.php");
	echo "</div>\n";
	
?>
	<script>
	$("#topten").click(function () {
		$('#levelpack').load('/ajax/records_top10.php?pack=' + <?php echo $rowp['LevelPackIndex']; ?>);
		$("#topten").addClass("selbutt");
		$("#besttime").removeClass("selbutt");
		$("#all").removeClass("selbutt");
		$("#talk").removeClass("selbutt");
	});
	$("#besttime").click(function () {
		$('#levelpack').load('/ajax/records_besttime.php?pack=' + <?php echo $rowp['LevelPackIndex']; ?>);
		$("#topten").removeClass("selbutt");
		$("#besttime").addClass("selbutt");
		$("#all").removeClass("selbutt");
		$("#talk").removeClass("selbutt");
	});
	$("#all").click(function () {
		$('#levelpack').load('/ajax/records_top10.php?pack=' + <?php echo $rowp['LevelPackIndex']; ?> + '&all=true');
		$("#topten").removeClass("selbutt");
		$("#besttime").removeClass("selbutt");
		$("#all").addClass("selbutt");
		$("#talk").removeClass("selbutt");
	});
	$("#talk").click(function () {
		$('#levelpack').load('/ajax/records_pack_talk.php?pack=' + <?php echo $rowp['LevelPackIndex']; ?>);
		$("#topten").removeClass("selbutt");
		$("#besttime").removeClass("selbutt");
		$("#all").removeClass("selbutt");
		$("#talk").addClass("selbutt");
	});
	</script>
<?php
	
	
	echo "</div>";

	echo "<div class='stdboxright'>";

	echo "<div class='padbutt floatl'><input type='button' value='Recent Activity' id='recent' class='stdbutt selbutt'></div>";
	echo "<div class='padbutt floatl'><input type='button' value='Points' id='pointslist' class='stdbutt'></div>";
	echo "<div class='padbutt floatl'><input type='button' value='Total Times' id='totaltimes' class='stdbutt'></div>";

	

	echo "<div id='levelpackright' class='floatl wide'>";
	$packindex = $rowp['LevelPackIndex'];
	$nonajax = true;
	include("ajax/records_recent.php");
	echo "</div>";

?>
	<script>
	$("#recent").click(function () {
		$('#levelpackright').load('/ajax/records_recent.php?pack=' + <?php echo $rowp['LevelPackIndex']; ?>);
		$("#recent").addClass("selbutt");
		$("#pointslist").removeClass("selbutt");
		$("#totaltimes").removeClass("selbutt");
	});
	$("#pointslist").click(function () {
		$('#levelpackright').load('/ajax/records_pointslist.php?pack=' + <?php echo $rowp['LevelPackIndex']; ?>);
		$("#recent").removeClass("selbutt");
		$("#pointslist").addClass("selbutt");
		$("#totaltimes").removeClass("selbutt");
	});
	$("#totaltimes").click(function () {
		$('#levelpackright').load('/ajax/records_totaltimes.php?pack=' + <?php echo $rowp['LevelPackIndex']; ?>);
		$("#recent").removeClass("selbutt");
		$("#pointslist").removeClass("selbutt");
		$("#totaltimes").addClass("selbutt");
	});
	</script>
<?php

	echo "</div>";

//
// LEVELS
//
}elseif($p == "level" && isset($t)){

	$result = mysql_query("SELECT level.LevelName, level.LevelIndex, level.LongName, level.Description, level.LevelIndex, levelpack.KuskiIndex, levelpack.LongName as LongPackName, levelpack.PackName FROM level, levelpack WHERE level.LevelName = '$t' AND level.LevelPackIndex = levelpack.LevelPackIndex");
	$rowl = mysql_fetch_array($result);

	echo "<div class='padtop padbuttom'><span class='head3 red pad' id='levelname'><a href='/records/pack/".$rowl['PackName']."'>".$rowl['LongPackName'] . "</a> " . $rowl['LevelName']." ".$rowl['LongName']."</span>\n";
	if($ki == $rowl['KuskiIndex']){
		echo "<span class='pad padtop' style='display: none;' id='edit'><input type='text' id='newname' value='".$rowl['LongName']."' size='40' />";
		echo "<input type='button' id='editlevel' value='Edit' class='stdbutt' /></span>";
	}
	echo "<span class='head3 red pad'><input type='button' onClick=\"parent.location='$url/inc/dl_lev.php?lev=".$rowl['LevelIndex']."'\" value='Download Level' id='dllev' class='stdbutt' /></span></div>\n";

	echo "<p class='pad' id='levdesc'>".$rowl['Description']."</p>\n";
	if($ki == $rowl['KuskiIndex']){
		echo "<p class='pad padtop' style='display: none;' id='editdesc'><input type='text' id='newdesc' value='".$rowl['Description']."' size='40' />";
		echo "<input type='button' id='editdescbutt' value='Edit' class='stdbutt' /></p>";
		echo "<p class='pad padtop'>This is your level. Double click level name or description to edit it.</p>";
	}
	if($rowl['PackName'] == "Found"){
		echo "<table><tr><td>&#171; ".lev($rowl['LevelIndex'] + 1)."</td>\n";
		echo "<td style='text-align: right'>".lev($rowl['LevelIndex'] - 1)." &#187;</td></tr></table>\n";
	}else{
		echo "<table><tr><td>&#171; ".lev($rowl['LevelIndex'] - 1)."</td>\n";
		echo "<td style='text-align: right'>".lev($rowl['LevelIndex'] + 1)." &#187;</td></tr></table>\n";
	}
	echo "<div class='footer'></div>\n";
	echo "<div class='padbutt floatl'><input type='button' value='$t' id='levmain' class='stdbutt selbutt'></div>\n";
	echo "<div class='padbutt floatl'><input type='button' value='Map' id='map' class='stdbutt'></div>\n";
	echo "<div class='padbutt floatl'><input type='button' value='All Times' id='alltimes' class='stdbutt'></div>\n";
	echo "<div class='padbutt floatl'><input type='button' value='Talk' id='talk' class='stdbutt'></div>\n";
	echo "<div class='footer'></div>\n";



	echo "<div id='level'>\n";

	echo "<div class='stdboxleft padtop'>\n";
	echo "<table>\n";
	echo "<tr><th colspan='3'>Best Times</th></tr>\n";
	$no = 1;
	$result = mysql_query("SELECT LevelIndex, Time, Driven, KuskiIndex, TimeIndex, Apples, Shared FROM besttime WHERE LevelIndex = '".$rowl['LevelIndex']."' ORDER BY Time ASC, Apples DESC, Driven ASC");
	while($row = mysql_fetch_array($result)){
		if($no == 1){
			$numerouno = $row['Time'];
		}
		$diff = $row['Time'] - $numerouno;
		$new = "";
		if($row['Driven'] > date("Y-m-d H:i:s", (time() - 2592000))){
			$new = "new";
		}
		echo "<tr  class='$new' title='".$row['Driven']." Difference to 1st: ".HsToStr($diff)."'><td>$no.</td><td>".HsToStr($row['Time'], false, $row['TimeIndex'], $row['Apples'], 9999999999, $row['Shared'])."</td><td>".kuski($row['KuskiIndex'])."</td></tr>\n";
		$no++;
	}
	echo "</table>\n";
	echo "</div>\n";

	echo "<div class='stdboxright padtop'>\n";
	echo "<table>\n";
	echo "<tr><th>Map</th></tr>\n";
	echo "<tr><td class='center'><img id='mapsmall' src='/inc/domimap.php?lev=$t'></td></tr>\n";
	echo "</table>\n";

	echo "<table>\n";
	echo "<tr><th>Record History</th></tr>\n";
	$rechis = array();
	$best = 99999999999999999;
	$no = 0;
	$result = mysql_query("SELECT * FROM time WHERE LevelIndex = '".$rowl['LevelIndex']."' ORDER BY Driven ASC");
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
	echo "<div id='nothing'></div>";

	echo "</div>\n";

$mapajax = "/ajax/records_map.php?lev=" . $t;
$levmainajax = "/ajax/records_level.php?lev=" . $rowl['LevelIndex'] . "&levname=" . $t;
$alltimesajax = "/ajax/records_level.php?lev=" . $rowl['LevelIndex'] . "&all=true&levname=" . $t;
?>
	<script>
	$("#levmain").click(function () {
		$('#level').load('<?php echo $levmainajax ?>');
		$("#levmain").addClass("selbutt");
		$("#map").removeClass("selbutt");
		$("#alltimes").removeClass("selbutt");
		$("#talk").removeClass("selbutt");
	});
	$("#mapfull").click(function () {
		$('#level').load('<?php echo $levmainajax ?>');
		$("#levmain").addClass("selbutt");
		$("#map").removeClass("selbutt");
		$("#alltimes").removeClass("selbutt");
		$("#talk").removeClass("selbutt");
	});
	$("#map").click(function () {
		$('#level').load('<?php echo $mapajax ?>');
		$("#levmain").removeClass("selbutt");
		$("#map").addClass("selbutt");
		$("#alltimes").removeClass("selbutt");
		$("#talk").removeClass("selbutt");
	});
	$("#mapsmall").click(function () {
		$('#level').load('<?php echo $mapajax ?>');
		$("#levmain").removeClass("selbutt");
		$("#map").addClass("selbutt");
		$("#alltimes").removeClass("selbutt");
		$("#talk").removeClass("selbutt");
	});
	$("#alltimes").click(function () {
		$('#level').load('<?php echo $alltimesajax ?>');
		$("#levmain").removeClass("selbutt");
		$("#map").removeClass("selbutt");
		$("#alltimes").addClass("selbutt");
		$("#talk").removeClass("selbutt");
	});
	$("#talk").click(function () {
		$('#level').load('/ajax/records_talk.php?lev=' + <?php echo $rowl['LevelIndex']; ?>);
		$("#levmain").removeClass("selbutt");
		$("#map").removeClass("selbutt");
		$("#alltimes").removeClass("selbutt");
		$("#talk").addClass("selbutt");
	});
	</script>
<?php
if($ki == $rowl['KuskiIndex']){
	?>
	<script>
	$("#levelname").dblclick(function () {
		$('#levelname').hide();
		$('#edit').show();
	});
	$("#editlevel").click(function () {
		$('#levelname').load('/ajax/records_level_edit.php?lev=' + <?php echo $rowl['LevelIndex']; ?> + '&newval=' + encodeURIComponent($("#newname").val()));
		$('#edit').hide();
		$('#levelname').show();
	});
	$("#levdesc").dblclick(function () {
		$('#levdesc').hide();
		$('#editdesc').show();
	});
	$("#editdescbutt").click(function () {
		$('#levdesc').load('/ajax/records_level_edit.php?desc=true&lev=' + <?php echo $rowl['LevelIndex']; ?> + '&newval=' + encodeURIComponent($("#newdesc").val()));
		$('#editdesc').hide();
		$('#levdesc').show();
	});
	</script>
	<?php
}

//
// PLAYERS
//
}elseif($p == "player" && isset($t)){

	include_once("classes/db_kuski_class.php");
	$result = new Kuski;
	$result->where = "Kuski = '$t'";
	$result->rows = "Kuski, KuskiIndex, Team, Country, Registered";
	$data = $result->select();
	foreach($data as $row){
		$kuski = $row['KuskiIndex'];
		$nat = $row['Country'];
	}
	echo "<p class='head red pad'>".kuski($kuski)." ".nation($nat)."</p><div class='footer'></div>\n";

	echo "<div class='stdboxleft padtop'>\n";

	echo "<div class='padbutt floatl'><input type='button' value='Times' id='timesbutt' class='stdbutt selbutt'></div>";
	echo "<div class='padbutt floatl'><input type='button' value='Shoutbox' id='shoutbox' class='stdbutt'></div><div class='footer'></div>";

	echo "<div id='recshare'></div>";
	echo "<div id='times'>";

	include_once("classes/db_time_class.php");
	$result = new DBTime;
	$result->nick = $kuski;
	$result->rows = "besttime.KuskiIndex, besttime.LevelIndex, besttime.Position, besttime.Time, besttime.Driven, level.LevelPackIndex, levelpack.LongName, besttime.Apples, besttime.TimeIndex, besttime.Shared";
	$result->orderby = "besttime.LevelIndex ASC";
	$result->where = "besttime.KuskiIndex = '" . $kuski . "' AND level.LevelIndex = besttime.LevelIndex AND level.LevelPackIndex = levelpack.LevelPackIndex";
	$result->from = "besttime, level, levelpack";
	$data = $result->select();
	$pack = 0;
	$finished = array();
	$tts = array();
	echo "<table>\n";
	foreach($data as $row){
		if($row['LevelPackIndex'] != $pack){
			echo "<tr><th colspan='3'>".$row['LongName']."</th><td colspan='2' align='right'>";
			if($ki == $kuski){
				echo "Share";
			}else{
				echo "&nbsp;";
			}
			echo "</td></tr>\n";
			$pack = $row['LevelPackIndex'];
		}
		if($row['Shared'] == 1){
			$checked = "checked='checked'";
		}else{
			$checked = "";
		}
		echo "<tr><td>".lev($row['LevelIndex'])."</td><td>".ordanlize($row['Position'])."</td><td>".HsToStr($row['Time'], false, $row['TimeIndex'], $row['Apples'], $row['KuskiIndex'])."</td><td>".time_ago(strtotime($row['Driven']))."</td><td>";
		if($ki == $kuski){
			echo "<input class='sharerec' type='checkbox' $checked name='".$row['TimeIndex']."' id='".$row['TimeIndex']."'>";
		}else{
			echo "&nbsp;";
		}
		echo "</td></tr>\n";
		if($row['Time'] != '999999'){
			if(isset($finished[$pack])){
				$finished[$pack] = $finished[$pack] + 1;
				$tts[$pack] = $tts[$pack] + $row['Time'];
			}else{
				$finished[$pack] = 1;
				$tts[$pack] = $row['Time'];
			}
		}
	}
	echo "</table>\n";
	echo "</div>\n";

	echo "<div id='shout'></div>";
	
	echo "</div>\n";

	echo "<div class='stdboxright padtop'>\n";

	echo "<table>\n";
	echo "<tr><th>Total Times</th></tr>\n";
	include_once("classes/db_levelpack_class.php");
	$result = new Levelpack;
	$result->rows = "LevelPackIndex, Amount, PackName";
	$data = $result->select();
	foreach($data as $row){
		$pack = $row['LevelPackIndex'];
		if($finished[$pack] == $row['Amount']){
			echo "<tr><td>".levpack($row['PackName'])."</td><td>".HsToStr($tts[$pack])."</td></tr>";
		}
	}
	echo "</table>\n";

	echo "<table>\n";
	echo "<tr><th>Latest times</th></tr>\n";
	$result = new DBtime;
	$result->bestall("all");
	$result->where = "KuskiIndex = '$kuski' AND (EOLVerify = '1' OR Verify = '1')";
	$result->orderby = "TimeIndex DESC";
	$result->limit = "0,5";
	$result->rows = "Time, Driven, LevelIndex";
	$data = $result->select();
	foreach($data as $row){
		echo "<tr><td>".HsToStr($row['Time'])." on ".lev($row['LevelIndex'])." ".time_ago(strtotime($row['Driven']))." ago</td></tr>\n";
	}
	echo "<tr><th>Last active</th></tr>\n";
	include_once("classes/db_log_class.php");
	$result = new DBlog;
	$result->rows = "Date, Time, Page";
	$result->where = "KuskiIndex = '$kuski' AND Page != '/kopasite/images/out_cp_bul.gif'";
	$result->orderby = "LogIndex DESC";
	$result->limit = "0,1";
	$data = $result->select();
	foreach($data as $row){
		echo "<tr><td>".$row['Date']." at ".$row['Time']." on <a href='".$row['Page']."'>".$row['Page']."</a></td></tr>\n";
	}
	/*echo "<tr><th>Latest visitors</th></tr>\n";
	$result = new DBlog;
	$result->rows = "KuskiIndex, DateTime";
	$result->where = "Page = '$url/records/player/$t' AND KuskiIndex != '$kuski' AND KuskiIndex != '0'";
	$result->orderby = "LogIndex DESC";
	$result->limit = "0,5";
	$data = $result->select();
	foreach($data as $row){
		echo "<tr><td>".kuski($row['KuskiIndex'], false)." ".time_ago(strtotime($row['DateTime']))." ago</td></tr>\n";
	}*/
	echo "</table>\n";
	$res = mysql_query("SELECT Name, Text FROM plaque WHERE KuskiIndex = '$kuski'");
	if(mysql_num_rows($res) > 0){
		echo "<table>\n";
		echo "<tr><th>Plaques</th></tr>\n";
		echo "<tr><td>\n";
		$no = 0;
		while($row = mysql_fetch_array($res)){
			if($no == 3){
				$no = 0;
				echo "</td></tr><tr><td>\n";
			}
			echo "<img src='/images/plaque/".$row['Name'].".png' title='".$row['Text']."'>";
			$no++;
		}
		echo "</td></tr>\n";
		echo "</table>\n";
	}
	echo "<table>\n";
	echo "<tr><th>Places</th></tr>\n";
	$result = mysql_query("SELECT COUNT(BesttimeIndex), Position FROM besttime WHERE KuskiIndex = '$kuski' GROUP BY Position");
	while($row = mysql_fetch_array($result)){
		echo "<tr><td>".ordanlize($row['Position'])."</td><td>".$row['COUNT(BesttimeIndex)']."</td></tr>\n";	
	}
	echo "</table>\n";

	echo "</div>\n";

	?>
	<script>
	var shown = 0;
	$("#timesbutt").click(function () {
		$('#shout').hide();
		$('#times').show();
		$("#timesbutt").addClass("selbutt");
		$("#shoutbox").removeClass("selbutt");
	});
	$("#shoutbox").click(function () {
		$('#times').hide();
		if(shown == 0){
			$('#shout').load('/ajax/records_player_talk.php?pl=' + <?php echo $kuski; ?>);
			shown = 1;
		}else{
			$('#shout').show();
		}
		$("#timesbutt").removeClass("selbutt");
		$("#shoutbox").addClass("selbutt");
	});

	$('.sharerec').click(function() {
		$('.sharerec').attr('disabled', true);
		var onoff = 0;
		var fieldset_id = $(this).attr('id');
		if($('#' + fieldset_id).is(':checked')){
			onoff = 1;
		}
		$('#recshare').load('/ajax/records_player_share.php?i=' + $(this).attr('id') + '&onoff=' + onoff, function(){
			$('.sharerec').attr('disabled', false);
		});
	});
	</script>
	<?php

//
// TEAMS
//
}elseif($p == "team" && isset($t)){

	echo "<p class='head red pad'>Team ".team($t)."</p><div class='footer'></div>\n";

//
// COUNTRIES
//
}elseif($p == "country" && isset($t)){

	echo "<p class='head red pad'>".nation($t)."</p><div class='footer'></div>\n";

//
// COMPARE
//
}elseif($p == "compare"){

	echo "<p class='head red pad'>Compare</p><div class='footer'></div>\n";
	echo "<p>Later..</p><br/><br/>\n";

//
// PLAYER OF THE MONTH
//
}elseif($p == "player_of_the_month"){

	echo "<p class='head red pad'>Player Of the Month</p><div class='footer'></div>\n";
	echo "<p>Later..</p><br/><br/>\n";

//
// PLAYER OF THE WEEK
//
}elseif($p == "player_of_the_week"){

	echo "<p class='head red pad'>Player Of the Week</p><div class='footer'></div>\n";
	echo "<p>Later..</p><br/><br/>\n";

//
// KINGLIST (Records main)
//
}else{

	echo "<p class='head red pad'>King List";
	/*if(isset($t)){
		echo " $t";
	}*/
	echo "</p><div class='footer'></div>\n";

	echo "<div class='stdboxleft'>\n";
	if(isset($t)){
	$packs = array();
	$kinglist = array();
	$klteams = array();
	$klnats = array();
	$points = array(1 => 40, 2 => 30, 3 => 25, 4 => 22, 5 => 20, 6 => 18, 7 => 16, 8 => 14, 9 => 12, 10 => 11, 11 => 10, 12 => 9, 13 => 8, 14 => 7, 15 => 6, 16 => 5, 17 => 4, 18 => 3, 19 => 2, 20 => 1);
	if(isset($t)){
		$result = mysql_query("SELECT level.LevelIndex, levelpack.LongName, levelpack.PackName FROM level, levelpack WHERE level.LevelPackIndex = levelpack.LevelPackIndex AND levelpack.LevelPackCategory = '$t'");
	}else{
		$result = mysql_query("SELECT level.LevelIndex, levelpack.LevelPackCategory, levelpack.LongName, levelpack.PackName FROM level, levelpack WHERE level.LevelPackIndex = levelpack.LevelPackIndex");
	}
	while($row = mysql_fetch_array($result)){
		$no = 1;
		$restime = mysql_query("SELECT besttime.KuskiIndex, besttime.LevelIndex, kuski.Team, kuski.Country FROM besttime, kuski WHERE besttime.KuskiIndex = kuski.KuskiIndex AND besttime.LevelIndex = '".$row['LevelIndex']."' ORDER BY besttime.Time ASC, besttime.Apples DESC, besttime.Driven ASC LIMIT 0,20");
		while($rowt = mysql_fetch_array($restime)){
			$kuski = $rowt['KuskiIndex'];
			if(!in_array($row['LongName'], $packs)){
				$packno = $row['PackName'];
				$packs[$packno] = $row['LongName'];
			}
			if($row['LevelPackCategory'] == "hoyla"){
				$ps = $points[$no] / 2;
			}elseif($row['LevelPackCategory'] == "Moposite" && !isset($t)){
				continue;
			}else{
				$ps = $points[$no];
			}
			if(isset($kinglist[$kuski])){
				$kinglist[$kuski] = $ps + $kinglist[$kuski];
			}else{
				$kinglist[$kuski] = $ps;
			}
			if($rowt['Team'] != "" && $rowt['Team'] != NULL){
				$team = $rowt['Team'];
				if(isset($klteams[$team])){
					$klteams[$team] = $ps + $klteams[$team];
				}else{
					$klteams[$team] = $ps;
				}
			}
			if($rowt['Country'] != "" && $rowt['Country'] != NULL){
				$nat = $rowt['Country'];
				if(isset($klnats[$nat])){
					$klnats[$nat] = $ps + $klnats[$nat];
				}else{
					$klnats[$nat] = $ps;
				}
			}
			$no++;
		}
	}
	arsort($kinglist);
	$no = 1;
	echo "<table>";
	foreach($kinglist as $kuski => $points){
		echo "<tr><td>$no.</td><td>".kuski($kuski)."</td><td>".round($points, 0)." pts.</td></tr>\n";
		$no++;
	}
	echo "</table>";
	}

	echo "<table>\n";
	echo "<th colspan='3'>Players</th>\n";
	$result = mysql_query("SELECT Kinglist, KuskiIndex, Team, Country FROM kuski WHERE Kinglist != '0' ORDER BY Kinglist DESC");
	$no = 1;
	$klteams = array();
	$klnats = array();
	while($row = mysql_fetch_array($result)){
		echo "<tr><td>$no.</td><td>".kuski($row['KuskiIndex'])."</td><td align='right'>".$row['Kinglist']." pts.</td></tr>\n";
		$nat = $row['Country'];
		$team = $row['Team'];
		if($nat != "" && $nat != NULL){
			if(isset($klnats[$nat])){
				$klnats[$nat] = $row['Kinglist'] + $klnats[$nat];
			}else{
				$klnats[$nat] = $row['Kinglist'];
			}
		}
		if($team != "" && $team != NULL){
			if(isset($klteams[$team])){
				$klteams[$team] = $row['Kinglist'] + $klteams[$team];
			}else{
				$klteams[$team] = $row['Kinglist'];
			}
		}
		$no++;
	}
	echo "</table>\n";
	echo "</div>\n";



	echo "<div class='stdboxright'>\n";

	echo "<table>\n";
	echo "<th colspan='3'>Level Packs in category</th>\n";
	foreach($packs as $short => $long){
		echo "<tr><td><a href='/records/pack/$short/'>$long</a></td></tr>\n";
		$no++;
	}
	echo "</table>\n";

	echo "<table>\n";
	echo "<th colspan='3'>Teams</th>\n";
	arsort($klteams);
	$no = 1;
	foreach($klteams as $team => $points){
		echo "<tr><td>$no.</td><td>".team($team)."</td><td align='right'>".round($points, 0)." pts.</td></tr>\n";
		$no++;
	}
	echo "</table>\n";

	echo "<table>\n";
	echo "<th colspan='3'>Countries</th>\n";
	arsort($klnats);
	$no = 1;
	foreach($klnats as $nat => $points){
		echo "<tr><td>$no.</td><td>".nation($nat)."</td><td align='right'>".round($points, 0)." pts.</td></tr>\n";
		$no++;
	}
	echo "</table>\n";
	echo "</div>\n";

	}

?>