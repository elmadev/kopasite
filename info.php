<?php

if(isset($p) && in_array($p, array('about_elasto_mania', 'about_kopasite', 'site_map', 'contact'))){
	include("info_".$p.".php");
}else{
	echo "<p class='head red pad'>Info</p><div class='footer'></div>\n";
	echo "<table class='stdbox'>";
	$section = "Info";
	foreach($menupages[$section] as $infopage){
		echo "<tr><td><a href='$url/".strtolower($section)."/".str_replace(" ", "_", strtolower($infopage))."/' style='color:#000000'>$infopage</a></td></tr>";
	}
	echo "</table>";
}

?>