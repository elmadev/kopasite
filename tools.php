<?php

if(isset($p) && in_array($p, array('cupsource', 'getrecinfo', 'replay_online'))){
	include("tools_".$p.".php");
}else{
	echo "<p class='head red pad'>Tools</p><div class='footer'></div>\n";
	echo "<table class='stdbox'>";
	$section = "Tools";
	$texts = array('cupSource' => 'A content management system made in PHP and MySQL which can be used to arrange Elasto Mania Cups.', 'getRecInfo' => 'An API to get information about a replay file.', 'Replay Online' => 'A replay flashplayer to view replays in your browser, made by Coco.');
	foreach($menupages[$section] as $infopage){
		echo "<tr><td><a href='$url/".strtolower($section)."/".str_replace(" ", "_", strtolower($infopage))."/'>$infopage</a></td></tr>";
		echo "<tr><td>".$texts[$infopage]."</td></tr>";
	}
	echo "</table>";
}

?>