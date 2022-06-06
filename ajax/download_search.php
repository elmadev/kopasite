<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	
	$filename = hax($_GET['filename']);
	$filetype = hax($_GET['filetype']);
	$upby = hax($_GET['upby']);
	$tags = hax($_GET['tags']);
	$url = "";
}
include_once("../classes/db_upload_class.php");
$result = new Upload;
if($filename != ""){
	$where .= "Filename LIKE '".$filename."%'";
}
if($filetype != ""){
	if(isset($where)){
		$where .= " AND ";
	}
	$where .= "Filetype LIKE '".$filetype."%'";
}
if($upby != ""){
	if(isset($where)){
		$where .= " AND ";
	}
	$where .= "KuskiIndex = '".kuski2id($upby)."'";
}
if(isset($where)){
$result->where = $where . " AND Privacy = 'Public'";
}else{
	$result->where = "Privacy = 'Public'";
}
$result->limit = "0,25";
$result->orderby = "Datetime DESC";
$result->rows = "KuskiIndex, Filetype, Datetime, Filename, UploadIndex, Duplicate, Code";
$data = $result->select();
echo "<table id='downloads' class='tablesorter'>\n";
echo "<thead><tr><th>Filename</th><th>Upload by</th><th>Filetype</th><th>Uploaded on</th></tr></thead><tbody>\n";
if(count($data) > 0){
	foreach($data as $row){
		$dlurl = upurl($row['Filename'], $row['Duplicate'], $row['Code']);
		echo "<tr><td><a href='$dlurl'>".$row['Filename']."</a></td><td>".kuski($row['KuskiIndex'], false)."</td><td>".$row['Filetype']."</td><td>".$row['Datetime']."</td></tr>\n";
	}
}
echo "</tbody></table>\n";

?>