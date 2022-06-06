<?php
include("/home/kopaka/kopasitedb.php");

$points = array(1 => 40, 2 => 30, 3 => 25, 4 => 22, 5 => 20, 6 => 18, 7 => 16, 8 => 14, 9 => 12, 10 => 11, 11 => 10, 12 => 9, 13 => 8, 14 => 7, 15 => 6, 16 => 5, 17 => 4, 18 => 3, 19 => 2, 20 => 1);
//$result = mysql_query("SELECT * FROM updateschedule");
$result = mysql_query("SELECT LevelIndex, LevelPackIndex FROM level"); // recalc all
if(mysql_num_rows($result) > 0){
	while($row = mysql_fetch_array($result)){
		if($row['LevelIndex'] != 0){
			echo $row['LevelIndex'] . "-";
			$times = mysql_query("SELECT BestTimeIndex, KuskiIndex FROM besttime WHERE LevelIndex = '".$row['LevelIndex']."' ORDER BY Time ASC, Apples DESC, Driven DESC");
			$no = 1;
			$pojos = "";
			$pojosarr = array();
			while($rowt = mysql_fetch_array($times)){
				//mysql_query("UPDATE besttime SET Position = '$no' WHERE BestTimeIndex = '".$rowt['BestTimeIndex']."'");
				$pojos .= $rowt['KuskiIndex'] . ",";
				$k = $rowt['KuskiIndex'];
				if(isset($points[$no])){
					$pojosarr[$k] = $points[$no];
				}
				$no++;
			}
			//mysql_query("DELETE FROM updateschedule WHERE UpdateScheduleIndex = '".$row['UpdateScheduleIndex']."'");

			$points_before = mysql_query("SELECT Points FROM level WHERE LevelIndex = '".$row['LevelIndex']."'");
			$rowb = mysql_fetch_array($points_before);
			$pojos_before = explode(",", $rowb['Points']);
			$p_before_arr = array();
			$no = 1;
			foreach($pojos_before as $k){
				$p_before_arr[$k] = $points[$no];
				$no++;
			}
			$pojos_change = array();
			foreach($pojosarr as $k => $p){
				$pojos_change[$k] = $p - $p_before_arr[$k];
			}
			foreach($pojos_change as $k => $p){
				mysql_query("UPDATE kuski SET Kinglist = Kinglist+".$p." WHERE KuskiIndex = '".$k."'");
				//echo "UPDATE kuski SET Kinglist = Kinglist+".$p." WHERE KuskiIndex = '".$k."'<br/>";
				$r = mysql_query("SELECT KuskiIndex FROM points WHERE KuskiIndex = '".$k."' AND Pack = '".$row['LevelPackIndex']."'");
				//echo "SELECT KuskiIndex FROM points WHERE KuskiIndex = '".$k."' AND Pack = '".$row['LevelPackIndex']."'<br/>";
				if(mysql_num_rows($r) > 0){
					mysql_query("UPDATE points SET Points = '".$pojosarr[$k]."' WHERE KuskiIndex = '".$k."' AND Pack = '".$row['LevelPackIndex']."'");
					//echo "UPDATE points SET Points = '".$pojosarr[$k]."' WHERE KuskiIndex = '".$k."' AND Pack = '".$row['LevelPackIndex']."'<br/>";
				}else{
					mysql_query("INSERT INTO points (KuskiIndex, Pack, Points) VALUES('".$k."', '".$row['LevelPackIndex']."', '".$pojosarr[$k]."')");
					//echo "INSERT INTO points (KuskiIndex, Pack, Points) VALUES('".$k."', '".$row['LevelPackIndex']."', '".$pojosarr[$k]."')<br/>";
				}
			}
			$pojos = substr($pojos, 0, -1);
			mysql_query("UPDATE level SET Points = '".$pojos."' WHERE LevelIndex = '".$row['LevelIndex']."'");
			//echo "UPDATE level SET Points = '".$pojos."' WHERE LevelIndex = '".$row['LevelIndex']."'";
		}
	}
}

?>