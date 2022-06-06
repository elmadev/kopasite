<?php

echo "<p class='head red pad'>Download</p><div class='footer'></div>\n";

include_once("/classes/db_upload_class.php");
$result = new Upload;
$result->orderby = "DateTime DESC";
$result->limit = "0,25";
$result->rows = "KuskiIndex, Filetype, Datetime, Filename, UploadIndex";
$result->where = "Privacy = 'Public'";
$data = $result->select();
echo "<table id='downloads' class='tablesorter'>\n";
echo "<thead><tr><th>Filename</th><th>Upload by</th><th>Filetype</th><th>Uploaded on</th></tr></thead><tbody>\n";
foreach($data as $row){
	echo "<tr><td><a href='$url/up/".$row['UploadIndex']."'>".$row['Filename']."</a></td><td>".kuski($row['KuskiIndex'], false)."</td><td>".$row['Filetype']."</td><td>".$row['Datetime']."</td></tr>\n";
}
echo "</tbody></table>\n";

?>

<script>
$(document).ready(function()
    {
        $("#downloads").tablesorter();
    }
); 
</script>