<?php

require_once("db_class.php");
class Level extends Database{

    function __construct(){
        $this->tablename       = 'level';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('LevelIndex', 'LevelPackIndex', 'LevelName', 'CRC', 'LongName', 'Description', 'LevelData', 'EOLIndex');
        $this->fieldlist['LevelIndex'] = array('pkey' => 'y');
		$this->fieldlist['LevelPackIndex'] = array('key' => 'y');
				
    } // end class constructor

} // end class

?>