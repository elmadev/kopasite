<?php
if(!$nonajax){
	include("../../kopasitedb.php"); 
	include("../functions.php");
	
	$type = hax($_GET['type']);
	$val = hax($_GET['val']);
	$user = hax($_GET['user']);
	$url = "/kopasite";
}

if($type == "nick"){
	if(userexists($val)){
		echo "User name already exists.";
	}else{
		if(mysql_query("UPDATE kuski SET Kuski = '$val' WHERE KuskiIndex = '$user'")){
			echo "$val";
		}
	}
}
if($type == "team"){
	if(mysql_query("UPDATE kuski SET Team = '$val' WHERE KuskiIndex = '$user'")){
		echo "$val";
	}
}
if($type == "country"){
	if(mysql_query("UPDATE kuski SET Country = '$val' WHERE KuskiIndex = '$user'")){
		echo nation($val, false);
	}
}
if($type == "mail"){
	if(isValidEmail($val)){
		if(mysql_query("UPDATE kuski SET Email = '$val' WHERE KuskiIndex = '$user'")){
			echo "$val";
		}
	}else{
		echo "Unvalid mail adress.";
	}
}
if($type == "pass"){
	$new = hax($_GET['new']);
	$new2 = hax($_GET['new2']);
	include_once("../classes/db_kuski_class.php");
	$result = new Kuski;
	$result->where = "KuskiIndex = '$user'";
	$data = $result->select();
	foreach($data as $row){
		if(md5($val) == $row['Password']){
			if($new == $new2){
				if(mysql_query("UPDATE kuski SET Password = '".md5($val)."' WHERE KuskiIndex = '$user'")){
					echo "Password changed.";
				}
			}else{
				echo "Passwords doesn't match.";
			}
		}else{
			echo "Wrong old password.";
		}
	}
}

?>