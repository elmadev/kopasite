<?php
ini_set('display_errors', 0);
/* Some necessary stuff from vk's mapmaker script*/
list ($endiantest) = array_values (unpack ('L1L', pack ('V',1)));
if ($endiantest != 1) define ('BIG_ENDIAN_MACHINE',1);
if (defined ('BIG_ENDIAN_MACHINE')) $unpack_workaround = 'big_endian_unpack';
else $unpack_workaround = 'unpack';

/* Function from vk's mapmaker script that recieves info about polys and objects from level */
function getLevData($file)
{
	global $unpack_workaround;

	$f = fopen($file, "rb") or die("Couldn't open $file");
	fread($f, 130);
	$numpolys = floatval( implode("", unpack("d", fread($f, 8))) ) - 0.4643643;
	for($i=0; $i < $numpolys; $i++)
	{
		$grass = implode("", unpack("L", fread($f, 4)));
		$vertices = implode("", unpack("L", fread($f, 4)));
		if (!$grass)
		{
			for($j=0; $j< $vertices; $j++)
			{
				$x = implode("", $unpack_workaround("d", fread($f, 8)));
				$y = implode("", $unpack_workaround("d", fread($f, 8)));
				$polys[$i][$j] = array($x, $y);
			}
		}
		else
			fread($f, 16*$vertices);
	}
	$numobjects = floatval( implode("", unpack("d", fread($f, 8))) ) - 0.4643643;
	for($i=0; $i < $numobjects; $i++)
	{
		$x = implode( "", $unpack_workaround("d", fread($f, 8)) );
		$y = implode( "", $unpack_workaround("d", fread($f, 8)) );
		$a = implode( "", unpack("l", fread($f, 4)) );
		$b = implode( "", unpack("l", fread($f, 4)) );
		$c = implode( "", unpack("l", fread($f, 4)) );
		$objects[$i] = array($x, $y, $a, $b, $c);
	}

	return array($polys, $objects);
}

/* Function that checks the object type from a given index found in replay file (not used) */
function getObjectType($filename, $object){
	list($polys, $objects) = getLevData($filename);
	$type = $objects[$object]['2'];
	return "$type";
}

/* Function that counts number of apples in a level */
function applesInLev($filename){
	list($polys, $objects) = getLevData($filename);
	$apples = 0;
	foreach($objects as $o){
		$type = $o['2'];
		if($type == 2){
			$apples++;
		}
	}
	return $apples;
}

/* Function that counts number of killers in a level */
function killersInLev($filename){
	list($polys, $objects) = getLevData($filename);
	$killers = 0;
	foreach($objects as $o){
		$type = $o['2'];
		if($type == 3){
			$killers++;
		}
	}
	return $killers;
}


/* *** getRecInfo(); *********************** *** ** *
   * Authors: milagros, skint0r and Viper_KillerGuy
   * Date: 2005-11-01
   * Updated: 2010-07-14 by Kopaka
   *********** *** ** *

   A function to return time, level name or CRC from a .rec file.
   $filename is obviously the file you should pass as a parameter.
   $tlc specifies wether you want the time, the level name or the crc from
   the replay, use the values "t", "l" or "c" respectively.
   The function shows the time by default, so you don't *really*
   need to pass the $tlc parameter unless you want the level name.
   Ex: to get the level name from a replay: getRecInfo("01mopo.rec", l); 
   
   Update includes extra security, checking if last object is indeed flower
   and if all apples have been taken. It also includes counting apples and
   returning number of apples if replay is not finished and "a" parameter is given.
   Also gives possibility to get time if not finished with "n" parameter.
   This update requires the 3 functions getLevData, applesInLev and killersInLev */

function getRecInfo($filename, $tlc=t) {

	/* Specify directory with levels */
	$leveldir = "";

	/* First of all, check if the file even exists */
	if(!file_exists($filename)) {
		return "The filename specified does not exist.";
	}

	/* $f is a file pointer to the filename */
	$f = fopen($filename, "r");

	/* $no is set as the number of frames in the replay */
	list(, $no) = unpack("V", fread($f, 4));

	/* Read 12 bytes of junk */
	for($i = 0; $i < 12; $i++) {
		fread($f, 1);
	}

	/* The next 4 bytes is the CRC checksum */
	$crc = bin2hex(fread($f, 4));

	/* The 12 next bytes is the name of the level file */
        $lev = fread($f, 12);
	/* remove some junk after filename */
		list($splitlev, $splitlevext) = explode(".",$lev);
		$lev = "$splitlev.lev";
		$levdir = $leveldir . $lev;

	/* Read 27 * rec frames + 4 bytes of junk */
	for($i = 0; $i < 27 * $no + 4; $i++) {
		fread($f, 1);
	}

	/* $no is set as number of events in the replay */
	list(, $no) = unpack("V", fread($f, 4));

	/* For each event, read info and check if $k is 0, i.e. an object
           $j is the number of the object, $d is the time of the event */
	if($tlc != "c" && $tlc != "l"){
		$killers = killersInLev("level.lev");
		$apples = applesInLev("level.lev");
		$lowestflower = $apples + $killers;
		$apps = 0;
		for($i = 0; $i < $no; $i++) {
			list(, $d) = unpack("d", fread($f, 8));
			list(, $j) = unpack("V", fread($f, 4));
			list(, $k) = unpack("V", fread($f, 4));
			if ($k == 0) {
				/* If higher than apple indices its a flower */
				if($j >= $lowestflower){
					$time = $d;
				/* Otherwise its an apple if higher than killer indices */
				}elseif($j >= $killers){
					$apps++;
				}
			}
			if ($d != $time) {
				$time = -1;
			}
		}
	}

	/* Close file */
	fclose($f);

	/* Check if all apples are taken */
	if($time >= 0){	
		if ($apps < $apples){
			$time = -1;
		}
	}

	/* If the replay is finished, do some weird calculatinons
           and set $outtime to the time in the format 0:00,00 */
	if ($time >= 0) {
		$i = $time * 62500 / 273;
		$outtime = sprintf("%01d:%02d,%02d", $i/6000, ($i/100)%60, $i%100);
	}

	/* Else, $time is -1 which means the rec is not finished, and we set $outtime to null */
	else {
		$i = $time * 62500 / 273;
		$nonfinish = sprintf("%01d:%02d,%02d", $i/6000, ($i/100)%60, $i%100);
		$outtime = "nf";
	}

	/* If the user specified the l parameter, we output the level name */
	if ($tlc == l) {
		return $lev;
	}
	
	/* If not, perhaps the user want the CRC from the replay? */
	elseif ($tlc == c) {
		return $crc;
	}

	/* return number of apples taken in replay if not finished, or time if finished */
	elseif ($tlc == a){
		if($time == -1){
			return $apps;
		}else{
			return $outtime;
		}
	}

	/* return number of apples no matter if finished or not */
	elseif ($tlc == p){
	}

	/* return time no matter if finished or not */
	elseif ($tlc == n){
		return $nonfinish;
	}

	/* Else, the user either specified the t parameter, or none at all, so we output the time */
	else {
		return $outtime;
	}
}

function hax( $value ){
	if($value == NULL){
		return NULL;
	}else{
		if( get_magic_quotes_gpc() )
		{
			  $value = stripslashes( $value );
		}
		//check if this function exists
		if( function_exists( "mysql_real_escape_string" ) )
		{
			  $value = mysql_real_escape_string( $value );
		}
		//for PHP version < 4.3.0 use addslashes
		else
		{
			  $value = addslashes( $value );
		}
		$value = htmlentities($value, ENT_QUOTES);
		return $value;
	}
}

$rec = $_GET['rec'];
$file = fopen($rec, 'rb');
$fc = fopen("replay.rec", "wb");
while(!feof ($file)){
	$line = fread ($file, 1028);
	fwrite($fc,$line);
}
fclose($fc);
$file = null;
$fc = null;
$line = null;

$lev = $_GET['lev'];
if(isset($lev)){
	$file = fopen($lev, 'rb');
	$fc = fopen("level.lev", "wb");
	while(!feof ($file)){
		$line = fread ($file, 1028);
		fwrite($fc,$line);
	}
	fclose($fc);
	$file = null;
	$fc = null;
	$line = null;
}

if($_GET['parr2'] == "l"){
	echo getRecInfo("replay.rec", "l");
	echo "\n";
	echo getRecInfo("replay.rec", "c");
}else{
	echo getRecInfo("replay.rec");
	echo "\n";
	echo getRecInfo("replay.rec", "a");
}

?>