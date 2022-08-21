<?php
include("../kopasitedb.php");
include("../functions.php");
include("../login.php");

$already_there = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

$slightly = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']);

$uri = str_replace($already_there, '', $slightly);

if($slightly != ""){
	$pieces = array_filter(explode("/", $slightly));
    if($pieces[2] == NULL){
        $p = 0;
      	$s = $pieces[1];
        if($pieces[3] == ""){
			$t = 0;
		}else{
			$t = $pieces[3];
		}
    }else{
        $s = $pieces[1];
		$p = $pieces[2];
		if($pieces[3] == ""){
			$t = 0;
		}else{
			$t = $pieces[3];
		}
    }
}

if($t != ""){
	include_once("../classes/db_upload_class.php");
	$result = new Upload;
	if(is_numeric($p) && isset($t)){
		$result->where = "Filename = '".hax(urldecode($t))."' AND Duplicate = '".hax(urldecode($p))."'";
		$code = false;
	}elseif(isset($t)){
		$result->where = "Filename = '".hax(urldecode($t))."' AND Code = '".hax(urldecode($p))."'";
		$code = true;
	}
	$result->rows = "FileData, Filename, Filetype, Privacy, UploadIndex, KuskiIndex";
	$data = $result->select();
	if(count($data) == 0){
		echo "File doesn't exists or wrong url.";
		die;
	}else{
		foreach($data as $row){
			if($row['Privacy'] == "Select" && $row['KuskiIndex'] != $ki){
				include_once("../classes/db_upload_users_class.php");
				$result = new Upload_users;
				$result->where = "UploadIndex = '".$row['UploadIndex']."' AND KuskiIndex = '".$ki."'";
				$checkusers = $result->select();
				if(count($checkusers) == 0){
					echo "You do not have access to this file.";
					die;
				}
			}
			if($row['Privacy'] == "Private" && $code == false){
				echo "File doesn't exists or wrong url.";
				die;
			}
			$data = $row['FileData'];
			$name = $row['Filename'];
			$size = strlen($data);
			$type = $row['Filetype'];
		}
		$imagetypes = array('png', 'jpg', 'jpeg', 'gif', 'apng', 'bmp');
		$htmltypes = array('htm', 'html', 'htmls', 'shtml');
		$flashtypes = array('swf');
		$texttypes = array('txt', 'text');
		if(in_array($type, $imagetypes)){
			header('Content-Type: image/jpeg');
		}elseif(in_array($type, $htmltypes)){
			header('Content-Type: text/html');
		}elseif(in_array($type, $flashtypes)){
			header('Content-Type: application/x-shockwave-flash');
		}elseif(in_array($type, $texttypes)){
			header('Content-Type: text/plain');
		}else{
			header("Content-type: $type");
			header("Content-Disposition: attachment; filename=\"$name\"");
		}
		header("Content-length: $size");
		header("Content-Description: PHP Generated Data");
		echo $data;
	}
}else{
	die;
	if(isset($_POST['uploadfile'])){
		include("uploadfile.php");
	}
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

	<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	  <title>Kopasite's simple upload page</title>
	  <link rel="icon" type="image/x-icon" href="../images/favicon.ico" />
	</head>
	<script src="../jquery.js"></script>
	<style type="text/css">
	html,body {
	   margin:0;
	   padding:0;
	}
	body {
		font-family:tahoma;
		background-image:url('../images/uploadback.jpg');
	}
	.upload {
		margin-top:150px;
		margin-bottom:100px;
		margin-left: auto ;
		margin-right: auto ;
		width: 700px;
		border: 1px solid #000000;
		background: #C4C4C4 ;
	}
	.bar {
		border: 1px solid #000000;
		background: #000000;
		color: #FFFFFF;
		text-align:center;

	}
	a:link.bar {
	        color: #FFFFFF;
			text-decoration: none;
	}
	a:visited.bar {
	        color: #FFFFFF;
			text-decoration: none;
	}
	a:active.bar {
	        color: #FFFFFF;
			text-decoration: none;
	}
	a:hover.bar	{
	        color: #FFFFFF;
			text-decoration: none;
	}
	#mid {
		float: left;
		width: 60%;
	}
	#left {
		float: left;
		width: 20%;
		text-align:left;
	}
	#right {
		float: right;
		width: 20%;
		text-align:right;
	}
	#footer {
		clear: both;
	}

	</style>
	<body>

	<?php
	echo "<div class='bar'>";
	echo "<div id='left'>";
	if(isset($k)){
		echo $k;
	}else{
		echo "&nbsp;";
	}
	echo "</div>";
	echo "<div id='mid'><a class='bar' href='http://kopasite.net'>Kopasite's simple upload page</a></div>";
	echo "<div id='right'><a class='bar' href='http://kopasite.net/download/'>Browse files</a></div>";
	echo "<div id='footer'></div>";
	echo "</div>";
	echo "<div align='center' class='upload'>";
	if(isset($success)){
		echo "<br/>" . $success;
	}
	?>
	<br/>Upload any file to save or share it. Max file size is 7 mb.<br/>
	<form method='post' enctype='multipart/form-data' action=''>
	<input type='file' name='file' size='70'> <input type="submit" value="Upload" name="uploadfile"><br/>
	<input name='MAX_FILE_SIZE' value='7000000' type='hidden'><br/>
	<table><tr>
	<td><input type="radio" value="60" name="Duration" checked="checked"> 60 days<br/>
	<input type="radio" value="3" name="Duration"> 3 days<br/>
	<input type="radio" value="0" name="Duration"> Forever</td>
	<td><input type="radio" value="Private" name="privacy" checked="checked" id="priv1"> Private<br/>
	<input type="radio" value="Public" name="privacy" id="priv2"> Public<br/>
	<input type="radio" value="Select" name="privacy" id="priv3"> Select..</td>
	<td><div style="display: none;" id="selusers"><input type="text" name="selectusers" size="20"/><br/>Type in users that<br/>can access the file.</div></td>
	</tr></table>
	Tags: <input type="text" name="tags" size="55"/><br/><br/>
	</form>
	<?php
	echo "</div>";
	if(isset($success)){
		?>
		<script>
		/* function SelectText(element) {
		    var doc = document;
		    var text = doc.getElementById(element);
		    if (doc.body.createTextRange) {
		        var range = document.body.createTextRange();
		        range.moveToElementText(text);
		        range.select();
		    } else if (window.getSelection) {
		        var selection = window.getSelection();
		        var range = document.createRange();
		        range.selectNodeContents(text);
		        selection.removeAllRanges();
		        selection.addRange(range);
		    }
		}
		SelectText('selectme'); */
		</script>
		<?php
	}
	?>
	<script>
	$("#priv3").change(function() {
		$("#selusers").show("fast");
	});
	$("#priv2").change(function() {
		$("#selusers").hide("fast");
	});
	$("#priv1").change(function() {
		$("#selusers").hide("fast");
	});
	</script>
	</body>

	</html>
<?php
}

?>