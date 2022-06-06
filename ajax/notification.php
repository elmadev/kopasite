<?php
session_start();
if(!$nonajax){
	include("../../kopasitedb.php");
	include("../functions.php");
	include("../login.php");
	$url = "";
}
include_once("../classes/db_time_class.php");
$result = new DBtime;
$result->bestall("all");
$result->rows = "TimeIndex, Time, KuskiIndex, LevelIndex, Position";
$result->orderby = "TimeIndex DESC";
$result->where = "EOLVerify = '1'";
$result->limit = "0,1";
$data = $result->select();
foreach($data as $row){
	if($row['TimeIndex'] != $_SESSION['lastrec'] && $ki != $row['KuskiIndex']){
		$_SESSION['lastrec'] = $row['TimeIndex'];
		echo "New time uploaded<br/>\n";
		echo HsToStr($row['Time'])." in ".lev($row['LevelIndex'])." by ".kuski($row['KuskiIndex'])."<br/>\n";
		?>
		<script>
		$("#notifi").show(400);
		$("#hidenotifi").click(function () {
			$("#notifi").hide(400);
		});
		</script>
		<?php
	}
}
?>
<input align="right" type="button" value="Hide" id="hidenotifi" class="stdbutt">