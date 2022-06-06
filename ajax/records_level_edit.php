<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	$lev = hax($_GET['lev']);
	$newval = hax($_GET['newval']);
}
if($_GET['desc']){
	mysql_query("UPDATE level SET Description = '$newval' WHERE LevelIndex = '$lev'");
	include_once("../classes/db_level_class.php");
	$result = new Level;
	$result->where = "LevelIndex = '$lev'";
	$result->rows = "Description";
	$data = $result->select();
	foreach($data as $row){
		$desc = $row['Description'];
	}
	echo $desc;
}else{
	mysql_query("UPDATE level SET LongName = '$newval' WHERE LevelIndex = '$lev'");
	include_once("../classes/db_level_class.php");
	$result = new Level;
	$result->where = "LevelIndex = '$lev'";
	$result->rows = "LongName, LevelName";
	$data = $result->select();
	foreach($data as $row){
		$levname = $row['LongName'];
		$shortname = $row['LevelName'];
	}
	echo $shortname.": ".$levname;
}
?>