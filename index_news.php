<?php

$result = mysql_query("SELECT NewsIndex, Datetime, Headline, News FROM news ORDER BY Datetime DESC LIMIT 0,1");
while($row = mysql_fetch_array($result)){
	echo "<p class='head3 white pad'>" . $row['Headline'] . "</p>";
	echo "<p class='head2 yellow pad'>" . newsdate($row['Datetime']) . "</p>";
	echo "<p class='pad lyellow'>" . bbcode(substr($row['News'], 0, strcspn($row['News'], '~')));
	$newsindex = $row['NewsIndex'];
	$rcomments = mysql_query("SELECT NewsIndex, COUNT(NewsCommentIndex) FROM news_comment WHERE NewsIndex = $newsindex");
	$rowc = mysql_fetch_array($rcomments);
	echo " <a href='news/$newsindex/' class='yellow'>More & comments (" . $rowc['COUNT(NewsCommentIndex)'] . ")</a>";
	echo "</p>";
}

?>