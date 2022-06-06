<?php
$goahead = false;
$error = "";
die;
if ($_FILES["file"]["error"] > 0){
	$error = "Error: " . $_FILES["file"]["error"] . "<br />\n";
	$goahead = false;
}

$blacklist = array(".php", ".phtml", ".php3", ".php4", ".js", ".shtml", ".pl", ".py", ".exe");
foreach ($blacklist as $file){
	if(preg_match("/$file\$/i", $_FILES["file"]["name"])){
		$error = "Error: Uploading executable files Not Allowed\n";
		$goahead = false;
	}
}

if($goahead){
	$result = mysql_query("SELECT Filename, KuskiIndex, Duplicate FROM upload WHERE Filename = '".$_FILES["file"]["name"]."' ORDER BY Duplicate ASC");
	if(mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)){
			$duplicate = $row['Duplicate'];
		}
		$duplicate++;
	}else{
		$duplicate = 0;
	}

	$path = $_FILES["file"]["tmp_name"];
	$data = addslashes(fread(fopen($path, "r"), filesize($path)));

	$path_parts = pathinfo($_FILES["file"]["name"]);

	if($_POST['privacy'] == "Private"){
		$code = randomPrefix(15);
	}else{
		$code = null;
	}

	mysql_query("INSERT INTO upload (KuskiIndex, Privacy, Duration, Duplicate, Code, Filename, Filetype, FileData, DateTime) VALUES('$ki', '".$_POST['privacy']."', '".$_POST['Duration']."', '$duplicate', '$code', '".$_FILES["file"]["name"]."', '".strtolower($path_parts['extension'])."', '$data', '".date("Y-m-d H:i:s")."')");
	$id = mysql_insert_id();

	$tags = explode(",", $_POST['tags']);
	foreach($tags as $t){
		mysql_query("INSERT INTO upload_tags (UploadIndex, Tag) VALUES('$id', '$t')");
	}

	$selectusers = explode(",", $_POST['selectusers']);
	foreach($selectusers as $su){
		if($su != NULL && $su != ""){
			$nickid = kuski2id(trim($su));
			if($nickid != 0){
				mysql_query("INSERT INTO upload_users (UploadIndex, KuskiIndex) VALUES('$id', '".$nickid."')");
			}
		}
	}
	

	$success = "Upload succesful!<br/>\n";
	$success .= $_FILES["file"]["name"] . " " . getsize($_FILES["file"]["size"]) . "<br/>\n";
	$success .= "<div id='selectme'><a href='".upurl($_FILES["file"]["name"], $duplicate, $code)."'>http://kopasite.net".upurl($_FILES["file"]["name"], $duplicate, $code)."</a></div><br/>\n";
}
?>