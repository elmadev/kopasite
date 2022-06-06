<?php

if(isset($p)){
	$result = mysql_query("SELECT * FROM faq WHERE ShortName = '$p'");
	if(mysql_num_rows($result) > 0){
		$row = mysql_fetch_array($result);
		echo "<p class='head red pad'>Help</p><div class='footer'></div>\n";
		echo "<p class='head2 red pad'>".$row['Q']."</p><div class='footer'></div>\n";
		echo "<div class='stdbox'><p>".$row['A']."</p></div>\n";
	}else{
		$four0four = true;
	}
}else{
	echo "<p class='head red pad'>Help</p><div class='footer'></div>\n";
	$result = mysql_query("SELECT * FROM faq");
	echo "<div class='stdbox'>\n";
	while($row = mysql_fetch_array($result)){
		echo "<p class='head2 red pad'>".$row['Q']."</p><div class='footer'></div>\n";
		echo "<p>".$row['A']."</p>\n";
	}
	echo "</div>\n";
}

?>