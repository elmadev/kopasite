<?php
include_once("classes/db_comment_class.php");

$talks = new Talk;
$talks->layout = "chat";
$talks->ki = $ki;
$talks->limit = 10;
$talks->echoTalks();

//$dbobject = new Comment;
//$dbobject->orderby = "Datetime DESC";
//$dbobject->limit = "0,10";
//$data = $dbobject->select();
//foreach($data as $row){
//	echo "<span class='lp_buttxt'><img src='$url/images/cp_rndbut.gif' width='6' height='6' alt='' class='cp_rndbut'/></span>";
//	echo "<p class='head1'>".kuski($row['KuskiIndex'], false)." >> ";
//	if($row['LevelIndex'] != 0){
//		echo lev($row['LevelIndex']);
//	}elseif($row['LevelPackIndex'] != 0){
//		echo levpack($row['LevelPackIndex'], "short");
//	}elseif($row['KuskiCommentIndex'] != 0){
//		echo kuski($row['KuskiCommentIndex'], false);
//	}else{
//		echo "Chat";
//	}
//	echo "<br/></p><p class='pad size11'>".$row['Comment']."<br/></p>";
//}

$talk = new Talk;
$talk->writeBox();

?>