<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	include("../login.php");
	$pl = hax($_GET['pl']);
}

include_once("../classes/talk_class.php");

echo "<div class='stdbox'>";
$talks = new Talk;
$talks->id = $pl;
$talks->type = "kuski";
$talks->ki = $ki;
$talks->echoTalks();
echo "</div>";


$talk = new Talk;
$talk->type = "kuski";
$talk->id = $pl;
$talk->writeBox();

?>