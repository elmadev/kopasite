<?php header("Content-type: text/xml"); ?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<rss version="2.0">
<channel>
  <title>Kopasite</title>
  <link>http://kopasite.net</link>
  <description>Kopasite.net</description>

<?php
function ordinal($cdnl){
    $test_c = abs($cdnl) % 10;
    $ext = ((abs($cdnl) %100 < 21 && abs($cdnl) %100 > 4) ? 'th'
            : (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1)
            ? 'th' : 'st' : 'nd' : 'rd' : 'th'));
    return $cdnl.$ext;
}
include("../kopasitedb.php");
include("functions.php");
$items = array();
$result = mysql_query("SELECT Time, LevelIndex, KuskiIndex, Position FROM time WHERE EOLVerify = '1' ORDER BY TimeIndex DESC LIMIT 0,1");
while($row = mysql_fetch_array($result)){
	echo "<item>";
	$lev = lev($row['LevelIndex'], true);
	echo "<title>".HsToStr($row['Time'])." (".ordinal($row['Position']).") in ".$lev." by ".kuski($row['KuskiIndex'], false, false)."</title>";
	echo "<link><![CDATA[http://kopasite.net/records/level/".$lev."]]></link>";
	echo "<description>cat face</description>";
	echo "</item>";

}
?>

</channel>
</rss>