<?php
if(!$nonajax){
	include("../../kopasitedb.php");
	include("../functions.php");
	$lev = hax($_GET['lev']);
}

echo "<div class='stdbox'>";
echo "<table>";
echo "<tr><th>Map</th></tr>";
echo "<tr><td class='center'><img id='mapfull' src='/inc/domimap.php?lev=$lev&width=602'></td></tr>";
echo "</table>";
echo "</div>";


?>