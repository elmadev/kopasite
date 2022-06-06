<?php

require_once("db_time_class.php");
class Times extends DBtime{

	var $nick;
	var $pack;
	var $level;
	var $bestall;
	var $fields;

	function Times(){ // constructor
		$this->bestall = "best";
	}


	private function verifyVariables(){
		if(!in_array($this->bestall, array('best', 'all'))){
			$this->bestall = "best";
		}
	}

	function getTimes(){
		$this->verifyVariables();
		$this->where = "KuskiIndex = '" . $this->nick . "'";
		$this->from = "besttime";
		return $this->select();
	}


}