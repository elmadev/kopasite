<?php

class Logging{

	function Logging(){ // constructor
		$ip = hax($_SERVER['REMOTE_ADDR']);
		$referer = hax($_SERVER['HTTP_REFERER']);
		$browser = hax($_SERVER['HTTP_USER_AGENT']);
		$page = hax($_SERVER['REQUEST_URI']);
		if(isset($GLOBALS['ki'])){
			$logki = $GLOBALS['ki'];
		}else{
			$logki = 0;
		}
		$datetime = date("Y-m-d H:i:s");
		$date = date("Y-m-d");
		$logtime = date("H:i:s");
		$result = mysql_query("SELECT LogIndex FROM sitelog WHERE IP = '$ip' AND Date = '$date'");
		if(mysql_num_rows($result) > 0){
			$unique = 0;
		}else{
			$unique = 1;
		}
		include_once("db_log_class.php");
		$ins = new DBlog;
		$fieldarray = array('KuskiIndex' => $logki, 'LogType' => 'Hit', 'IP' => $ip, 'DateTime' => $datetime, 'Date' => $date, 'Time' => $logtime, 'Referer' => $referer, 'Browser' => $browser, 'Page' => $page, 'U' => $unique);
		$ins->insert($fieldarray);
	}



}

?>