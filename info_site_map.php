<?php

echo "<p class='head red pad'>Site Map</p><div class='footer'></div>\n";

echo "<table class='stdbox'>";
foreach($menupages as $sections => $sss){
	echo "<tr><th>$sections</th></tr>";
	foreach($sss as $pages){
		echo "<tr><td><a href='$url/".strtolower($sections)."/".str_replace(" ", "_", strtolower($pages))."/' style='color:#000000'>$pages</a></td></tr>";
	}
}
echo "</table>";

?>