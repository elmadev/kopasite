<?php

require_once("db_class.php");
class Levelpack extends Database{

    function __construct(){
        $this->tablename       = 'levelpack';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('LevelPackIndex', 'KuskiIndex', 'PackName', 'LongName', 'Description', 'Secret', 'Amount');
        $this->fieldlist['LevelPackIndex'] = array('pkey' => 'y');
		$this->fieldlist['KuskiIndex'] = array('key' => 'y');
				
    } // end class constructor

} // end class

?>