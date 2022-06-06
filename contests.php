<?php

if(isset($p) && in_array($p, array('secret_areas', 'elopa', 'smash_cup', 'team_cup', 'dragstrup_cup'))){
	include("contests_".$p.".php");
}else{
	echo "<p class='head red pad'>Contests</p><div class='footer'></div>\n";
	echo "<table class='stdbox'>";
	$section = "Contests";
	foreach($menupages[$section] as $infopage){
		echo "<tr><td><a href='$url/".strtolower($section)."/".str_replace(" ", "_", strtolower($infopage))."/' style='color:#000000'>$infopage</a></td></tr>";
	}
	echo "</table>";
}

?>