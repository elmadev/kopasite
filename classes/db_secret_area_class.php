<?php

require_once("db_class.php");
class Secret_area extends Database{

    function Secret_area(){
        $this->tablename       = 'secret_area';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('SecretAreaIndex', 'KuskiIndex', 'LevelIndex', 'Datetime', 'Accept', 'Reject', 'RecData');
        $this->fieldlist['SecretAreaIndex'] = array('pkey' => 'y');
		$this->fieldlist['KuskiIndex'] = array('key' => 'y');
		$this->fieldlist['LevelIndex'] = array('key' => 'y');
				
    } // end class constructor

} // end class

?>