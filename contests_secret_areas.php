<?php
include_once("classes/db_secret_area_class.php");
echo "<div class='stdbox padtop'>\n";
echo "<p class='head3 red'>Secret Areas</p>\n";
echo "<input align='right' type='button' value='Show All' name='showall' id='showall' class='stdbutt'>\n";
$result = new Secret_area;
$result->orderby = "LevelIndex ASC, SecretAreaIndex ASC";
$result->rows = "LevelIndex, KuskiIndex, DateTime, SecretAreaIndex";
$result->where = "Accept = '1'";
$data = $result->select();
$most = array();
$mostall = array();
$levs = array();
echo "<table>\n";
foreach($data as $row){
	$kuski = $row['KuskiIndex'];
	if(!in_array($row['LevelIndex'], $levs)){
		echo "<tr><td>".lev($row['LevelIndex'])."</td><td>".kuski($row['KuskiIndex'])."</td><td>".$row['DateTime']."</td><td><a href='$url/inc/dl_secret_rec.php?rec=".$row['SecretAreaIndex']."'>Download</a></td></tr>\n";
		if(isset($most[$kuski])){
			$most[$kuski]++;
		}else{
			$most[$kuski] = 1;
		}
	$levs[] = $row['LevelIndex'];
	}else{
		echo "<tr style='display: none;' id='sec' class='size11'><td>".lev($row['LevelIndex'])."</td><td>".kuski($row['KuskiIndex'])."</td><td>".$row['DateTime']."</td><td><a href='$url/inc/dl_secret_rec.php?rec=".$row['SecretAreaIndex']."'>Download</a></td></tr>\n";
	}
	if(isset($mostall[$kuski])){
		$mostall[$kuski]++;
	}else{
		$mostall[$kuski] = 1;
	}
}
echo "</table>\n";

echo "<p class='head2 red'>Most secret areas found first</p>\n";
echo "<table>\n";
arsort($most);
foreach($most as $kuski => $sss){
	echo "<tr><td>".kuski($kuski)."</td><td>$sss</td><tr>";
}
echo "</table>\n";

echo "<p class='head2 red'>Most secret areas found</p>\n";
echo "<table>\n";
arsort($mostall);
foreach($mostall as $kuski => $sss){
	echo "<tr><td>".kuski($kuski)."</td><td>$sss</td><tr>";
}
echo "</table>\n";

echo "</div>\n";

?>

<script>
$("#showall").click(function () {
	$("tr").show();
});
</script>