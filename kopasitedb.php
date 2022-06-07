<?php
$GLOBALS["SQLI"] = mysqli_connect('[host]', '[user]', '[password]');
if (!$GLOBALS["SQLI"]) {
    die('Could not connect: ' . mysqli_error($GLOBALS["SQLI"]));
}
mysqli_select_db($GLOBALS["SQLI"], '[dbname]') or die(mysql_error());
?>