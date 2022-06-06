<?php

require_once("db_class.php");
class DBtime extends Database{

    function DBtimes(){
        $this->tablename       = 'besttime';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('BesttimeIndex', 'TimeIndex', 'KuskiIndex', 'LevelIndex', 'Time', 'Apples', 'Driven');
        $this->fieldlist['BesttimeIndex'] = array('pkey' => 'y');
		$this->fieldlist['TimeIndex'] = array('key' => 'y');
		$this->fieldlist['KuskiIndex'] = array('key' => 'y');
		$this->fieldlist['LevelIndex'] = array('key' => 'y');
				
    } // end class constructor

	function bestall($bestall){
		if($bestall == "best"){
			$this->tablename = 'besttime';
			$this->fieldlist = null;
			$this->fieldlist = array('BesttimeIndex', 'TimeIndex', 'KuskiIndex', 'LevelIndex', 'Time', 'Apples', 'Driven');
			$this->fieldlist['BesttimeIndex'] = array('pkey' => 'y');
			$this->fieldlist['TimeIndex'] = array('key' => 'y');
			$this->fieldlist['KuskiIndex'] = array('key' => 'y');
		}
		if($bestall == "all"){
			$this->tablename = 'time';
			$this->fieldlist = null;
			$this->fieldlist = array('TimeIndex', 'KuskiIndex', 'LevelIndex', 'Time', 'Apples', 'Driven', 'Position', 'RecData');
			$this->fieldlist['TimeIndex'] = array('pkey' => 'y');
			$this->fieldlist['KuskiIndex'] = array('key' => 'y');
			$this->fieldlist['LevelIndex'] = array('key' => 'y');
		}
	}

} // end class

?>