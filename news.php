<?php

if(isset($_POST['sendcomment'])){
	$comment = hax($_POST['comment']);
	$datetime = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO news_comment (NewsIndex, KuskiIndex, Datetime, Comment) VALUES('$p', '$ki', '$datetime', '$comment')");
}

if($p != "archive"){
	$result = mysql_query("SELECT NewsIndex, Datetime, Headline, News FROM news WHERE NewsIndex = '$p'");
	while($row = mysql_fetch_array($result)){
		echo "<p class='head3 red pad'>" . $row['Headline'] . "</p>";
		echo "<p class='head2 red pad'>" . newsdate($row['Datetime']) . "</p>";
		echo "<p class='pad'>" . bbcode(substr_replace($row['News'], '', strcspn($row['News'], '~'), 1));
		$newsindex = $row['NewsIndex'];
		$rcomments = mysql_query("SELECT NewsIndex, COUNT(NewsCommentIndex) FROM news_comment WHERE NewsIndex = $newsindex");
		$rowc = mysql_fetch_array($rcomments);
		echo "</p><br />";
	}

	echo "<div class='newscomment'>";
	$result = mysql_query("SELECT NewsIndex, Datetime, KuskiIndex, Comment FROM news_comment WHERE NewsIndex = '$newsindex' ORDER BY DateTime ASC");
	while($row = mysql_fetch_array($result)){
		echo "<div class='newscomment'>";
		echo "<p class='pad red'>" . kuski($row['KuskiIndex']) . " at " . $row['Datetime'] . "</p>";
		echo "<p class='pad'>" . nl2br($row['Comment']) . "</p><br />";
		echo "</div>";
	}
	echo "</div>";

	if($loggedin){
		echo "<div class='newscomment margin'>";
		echo "<p class='red'>Write Comment</p>";
		echo "<form method='post' action='$self'>";
		echo "<textarea rows='5' cols='30' name='comment'></textarea><br />";
		echo "<input type='submit' value='Post' name='sendcomment'>";
		echo "</form>";
		echo "</div>";
	}
}else{
	$result = mysql_query("SELECT Datetime, Headline, NewsIndex FROM news ORDER BY Datetime DESC");
	while($row = mysql_fetch_array($result)){
		echo "<p class='pad'><a href='../".$row['NewsIndex']."'>".$row['Headline']."</a> (".$row['Datetime'].")</p>";
	}
}

?>