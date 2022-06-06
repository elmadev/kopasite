<?php
// NEWS SECTION //
if($s == "news"){
	$result = mysql_query("SELECT Datetime, Headline, NewsIndex FROM news ORDER BY Datetime DESC LIMIT 0,5");
	$no = 1;
	while($row = mysql_fetch_array($result)){
		if($no == 1){
			echo "<p style='width:208px;float:left;font:11px/14px arial;color:#000000; float:left;'>";
		}
		echo "<img src='/kopasite/images/out_cp_bul.gif' width='5' height='5' alt='' class='out_cp_bul'/><a href='/news/".$row['NewsIndex']."/' style='color:#000000'>".$row['Headline']."</a>";
		if($no == 2){
			echo "</p>";
			$no = 1;
		}else{
			echo "<br/>";
			$no++;
		}
	}
	echo "<img src='/kopasite/images/out_cp_bul.gif' width='5' height='5' alt='' class='out_cp_bul'/><a href='../archive/' style='color:#000000'>More..</a>";
}else{
// NEWS SECTION end //
	$menupages = array('Records' => array('Kinglist', 'Compare', 'Player Of the Month', 'Player Of the Week'), 'Info' => array('About Elasto Mania', 'Site Map', 'About Kopasite', 'Contact'), 'Contests' => array('Secret Areas', 'eLopa', 'Smash Cup', 'Team Cup', 'Dragstrup Cup'), 'Download' => array('Recent', 'My Uploads', 'Search'), 'Community' => array('Kuski List', 'Interviews'), 'Tools' => array('cupSource', 'getRecInfo', 'Replay Online'));

	$no = 1;
	$noall = 0;
	if(array_key_exists($section, $menupages)){
		foreach($menupages[$section] as $menupage){
			if($no == 1){
				echo "<p style='width:208px;float:left;font:11px/14px arial;color:#000000; float:left;'>";
			}
			echo "<img src='/kopasite/images/out_cp_bul.gif' width='5' height='5' alt='' class='out_cp_bul'/><a href='$url/".strtolower($section)."/".str_replace(" ", "_", strtolower($menupage))."/' style='color:#000000'>".$menupage."</a>";
			if($no == 2){
				echo "</p>";
				$no = 1;
			}else{
				echo "<br/>";
				$no++;
			}
			$noall++;
		}
		while($noall < 5){
			if($no == 1){
				echo "<p style='width:208px;float:left;font:11px/14px arial;color:#000000; float:left;'>";
			}
			echo "&nbsp;";
			if($no == 2){
				echo "</p>";
				$no = 1;
			}else{
				echo "<br/>";
				$no++;
			}
			$noall++;
		}
	}
}
?>