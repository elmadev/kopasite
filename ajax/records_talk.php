<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	$lev = hax($_GET['lev']);
}

echo "<div class='stdbox'><table>";
include_once("../classes/db_comment_class.php");
$result = new Comment;
$result->where = "LevelIndex = '$lev'";
$result->orderby = "Datetime DESC";
$data = $result->select();
foreach($data as $row){
	echo "<tr><td>[".$row['Datetime']."] (".kuski($row['KuskiIndex'], false).") ".$row['Comment']."</td></tr>";
}
echo "</table></div>";

include_once("../classes/talk_class.php");
$talk = new Talk;
$talk->type = "level";
$talk->id = $lev;
$talk->writeBox();

?>