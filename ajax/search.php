<?php
if(!$nonajax){
	include("../../kopasitedb.php");
	include("../functions.php");

	$search = hax($_GET['search']);;
	$url = "";
}


echo "<p class='head3 pad red'>Search results</p>\n";
echo "<div class='stdboxleft'>\n";
echo "<p class='head2 red'>Players</p>\n";
include_once("../classes/db_kuski_class.php");
$result = new Kuski;
$result->where = "Kuski LIKE '".$search."%'";
$result->orderby = "Kuski ASC";
$result->rows = "KuskiIndex";
$data = $result->select();
echo "<table>\n";
if(empty($data)){
	echo "<tr><td>No results</td></tr>\n";
}
foreach($data as $row){
	echo "<tr><td>".kuski($row['KuskiIndex'])."</td></tr>\n";
}
echo "</table>\n";
echo "</div>\n";

echo "<div class='stdboxright'>\n";
echo "<p class='head2 red'>Levels</p>\n";
include_once("../classes/db_level_class.php");
$result = new Level;
$result->where = "LevelName LIKE '".$search."%'";
$result->orderby = "LevelName ASC";
$result->rows = "LevelIndex";
$data = $result->select();
echo "<table>\n";
if(empty($data)){
	echo "<tr><td>No results</td></tr>\n";
}
foreach($data as $row){
	echo "<tr><td>".lev($row['LevelIndex'])."</td></tr>\n";
}
echo "</table>\n";
echo "</div>\n";

?>