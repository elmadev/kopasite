<?php

$section = upperfirst($s);
$page = upperfirst($p);
$tab = $t;

if($s == "news" && $p != "archive"){
	$result = mysql_query("SELECT NewsIndex, Headline FROM news WHERE NewsIndex = '$p'");
	$row = mysql_fetch_array($result);
	$page = $row['Headline'];
}

echo "<p class='head white pad'>$section</p><p class='head2 white padtop'>";
if(isset($page)){
	echo "&nbsp;&#187; $page";
}
if(isset($tab)){
	echo " &#187; $tab";
}
echo "</p>";

?>