<?php

include_once("classes/db_tips_class.php");
$dbobject = new Tips;
$dbobject->orderby = "Priority DESC";
$data = $dbobject->select();
$first = 1;
$date = shuffle($data);
foreach ($data as $row) {
	if($first != 1){
		echo "<p style='width:1px;float:left;'><img src='images/cp_sep.gif' width='1' height='139' alt='' class='cp_sep'/></p>\n";
	}
	echo "<div style='width:207px;float:left;'><p class='head yellow pad'>".$row['Name']."</p>\n";
	echo "<span class='cp_web-txt'>".$row['Text']."&nbsp;<a href='".$row['Link']."' style='color:#E3DC21;'>more</a></span></div>";
	$first++;
	if($first == 4){
		break;
	}
} 
?>