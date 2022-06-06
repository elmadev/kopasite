<?php
session_start();
if(!$nonajax){
	include("../../kopasitedb.php");
	include("../functions.php");
	include("../login.php");
}

$id = hax($_GET['i']);
$onoff = hax($_GET['onoff']);
$result = mysql_query("SELECT KuskiIndex, RecData FROM time WHERE TimeIndex = '".$id."'");
$row = mysql_fetch_array($result);
if($row['KuskiIndex'] == $ki && $loggedin && $row['RecData'] != NULL){
	if($onoff == 1){
		mysql_query("UPDATE besttime SET Shared = '1' WHERE TimeIndex = '".$id."'");
		mysql_query("UPDATE time SET Shared = '1' WHERE TimeIndex = '".$id."'");
	}elseif($onoff == 0){
		mysql_query("UPDATE besttime SET Shared = '0' WHERE TimeIndex = '".$id."'");
		mysql_query("UPDATE time SET Shared = '0' WHERE TimeIndex = '".$id."'");
	}
}

?>