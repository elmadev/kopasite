<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	$pack = hax($_GET['pack']);
}

echo "<div class='stdboxleft'><table>";
include_once("../classes/db_comment_class.php");
$result = new Comment;
$result->where = "LevelPackIndex = '$pack'";
$result->orderby = "Datetime DESC";
$data = $result->select();
foreach($data as $row){
	echo "<tr><td>[".$row['Datetime']."] (".kuski($row['KuskiIndex'], false).") ".$row['Comment']."</td></tr>";
}
echo "</table></div>";

include_once("../classes/talk_class.php");
$talk = new Talk;
$talk->type = "pack";
$talk->id = $pack;
$talk->writeBox();

?>