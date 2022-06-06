<?
$GLOBALS["SQLI"] = mysqli_connect('[host]', '[user]', '[password]');
if (!$GLOBALS["SQLI"]) {
    die('Could not connect: ' . mysql_error());
}
mysqli_select_db($GLOBALS["SQLI"], '[dbname]') or die(mysql_error());
?>