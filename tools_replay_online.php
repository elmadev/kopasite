<?php

echo "<p class='head red pad'>Replay Online</p><div class='footer'></div>\n";
echo "<p class='pad'>A replay flashplayer to view replays in your browser, made by Coco.</p><br/>";
echo "<applet code='RunReplay.class' archive='$url/inc/RunReplay.jar' alt='Watch Replay Online' width='800' height='710' align='middle'>";
echo "Java Launch Error !!!";
echo "</applet>";

echo "<p class='pad head1 red'>Get this on your own site</p>";
echo "<p class='pad'>Download the jar file <a href='http://trouvedec.free.fr/RunReplay.jar'>here</a>.</p>";
echo "<p class='pad'>HTML code example:</p><br/>";
echo "<p class='pad'>" . htmlentities("<applet code='RunReplay.class' archive='RunReplay.jar' alt='Watch Replay Online' width='800' height='710' align='middle'>") . "</p>";
echo "<p class='pad'>" . htmlentities("<param name='replay' value='rec/replay.rec'>") . "</p>";
echo "<p class='pad'>" . htmlentities("<param name='level' value='lev/level.lev'>") . "</p>";
echo "<p class='pad'>" . htmlentities("Java Launch Error !!!") . "</p>";
echo "<p class='pad'>" . htmlentities("</applet>") . "</p><br/>";
echo "<p class='pad'>If you remove the level and replay lines you will get the replay and level inputs like above.</p>";

$noright = true;

?>