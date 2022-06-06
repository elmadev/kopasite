<?php

if($p != "search"){

	echo "<p class='head red pad'>Download</p><div class='footer'></div>\n";
	if($p == "my_uploads" && !$loggedin){
		echo "<p class='pad'>Please log in to see your uploads.</p><br/><br/>";
	}else{
		include_once("classes/db_upload_class.php");
		$result = new Upload;
		$result->orderby = "DateTime DESC";
		if($p == "my_uploads"){
			$result->where = "upload.KuskiIndex = '$ki'";
			$result->rows = "KuskiIndex, Filetype, Datetime, Filename, UploadIndex, Duplicate, Code, KuskiIndex as tokuski";
		}else{
			$result->where = "upload.Privacy != 'Private' AND (upload_users.KuskiIndex = '$ki' OR upload_users.KuskiIndex IS NULL)";
			$result->from = "upload LEFT JOIN upload_users ON upload.UploadIndex = upload_users.UploadIndex";
			$result->rows = "upload.KuskiIndex as upkuski, upload.Filetype, upload.Datetime, upload.Filename, upload.UploadIndex, upload.Duplicate, upload.Code, upload_users.KuskiIndex as tokuski";
			$result->limit = "0,50";
		}
		$data = $result->select();
		echo "<table id='downloads' class='tablesorter'>\n";
		echo "<thead><tr><th>Filename</th><th>by</th><th>&nbsp;</th><th>Uploaded on</th></tr></thead><tbody>\n";
		foreach($data as $row){
			$dlurl = upurl($row['Filename'], $row['Duplicate'], $row['Code']);
			echo "<tr><td><a href='$dlurl'>".$row['Filename']."</a></td><td>".kuski($row['upkuski'], false)."</td><td>".$row['Filetype']."</td><td>".$row['Datetime']."</td></tr>\n";
		}
		echo "</tbody></table>\n";
		?>
		<script>
		$(document).ready(function(){
			$("#downloads").tablesorter();
		});
		</script>
		<?php
	}

}elseif($p == "search"){
	echo "<p class='head red pad'>Search Downloads</p><div class='footer'></div>\n";

	echo "<div class='stdboxleft'>\n";
	echo "<table>\n";
	echo "<tr><td>Filename</td><td><input type='text' name='filename' id='filename' /></td></tr>\n";
	echo "<tr><td>Filetype</td><td><input type='text' name='filetype' id='filetype' /></td></tr>\n";
	echo "<tr><td>Uploaded by</td><td><input type='text' name='upby' id='upby' /></td></tr>\n";
	//echo "<tr><td>Tags</td><td><input type='text' name='tags' id='tags' /></td></tr>\n";
	echo "</table>\n";
	echo "</div>\n";

	echo "<div class='stdboxright'>";
//	echo "<table>\n";
//	echo "<tr><th>Popular filetypes</th></tr>\n";
//	echo "<tr><td>Level</td></tr>\n";
//	echo "<tr><td>Replay</td></tr>\n";
//	echo "<tr><td>LGR</td></tr>\n";
//	echo "</table>\n";
	echo "</div>\n";

	echo "<div class='stdbox'>\n";
	echo "<div id='searchresults'>";
	echo "</div>\n";
	echo "</div>\n";
}

?>

<script>
function searchdl(){
	if($("#filename").val() == '' && $("#filetype").val() == '' && $("#upby").val() == '' && $("#tags").val() == '') {
	}else{
		$('#searchresults').load('/ajax/download_search.php?filename=' + $("#filename").val() + '&filetype=' + $("#filetype").val() + '&upby=' + $("#upby").val() + '&tags=' + $("#tags").val());
	}
}
$("#filename").keyup(function () {
	searchdl();
});
$("#filetype").keyup(function () {
	searchdl();
});
$("#upby").keyup(function () {
	searchdl();
});
$("#tags").keyup(function () {
	searchdl();
});
</script>