<?php

if(isset($p) && in_array($p, array('kuski_list', 'interviews'))){
	include("info_".$p.".php");
}else{
	headline("Community");
	echo "<table class='stdbox'>";
	$section = "Community";
	foreach($menupages[$section] as $infopage){
		echo "<tr><td><a href='$url/".strtolower($section)."/".str_replace(" ", "_", strtolower($infopage))."/' style='color:#000000'>$infopage</a></td></tr>";
	}
	echo "</table><br/><br/><br/>";
}

?>