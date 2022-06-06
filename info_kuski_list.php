<?php

headline("Kuski List");

include_once("classes/db_kuski_class.php");

$result = new Kuski;
$result->orderby = "Kuski ASC";
$result->where = "Confirmed = '1'";
$data = $result->select();
echo "<table id='kuskilist' class='tablesorter'>\n";
echo "<thead><tr><th>Kuski</th><th>Nation</th><th>Registered</th></tr></thead><tbody>\n";
foreach($data as $row){
	echo "<tr><td>".kuski($row['KuskiIndex'])."</td><td>".nation($row['Country'])."</td><td>".substr($row['Registered'],0,10)."</td></tr>\n";
}
echo "</tbody></table>\n";

?>

<script>
$(document).ready(function() 
    { 
        $("#kuskilist").tablesorter(); 
    } 
); 
</script>