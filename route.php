<?php
$already_there = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

$slightly = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']);

$uri = str_replace($already_there, '', $slightly);

if($slightly != ""){
	$pieces = array_filter(explode("/", $slightly));
	if(count($pieces) == 3){
		$s = $pieces[1];
		$p = $pieces[2];
		$t = $pieces[3];
	}elseif(count($pieces) == 2){
		$s = $pieces[1];
		$p = $pieces[2];
	}elseif(count($pieces) == 1){
		$s = $pieces[1];
	}
}

?>