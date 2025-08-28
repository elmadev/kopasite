<?php

require_once("db_class.php");
class DBlog extends Database{

    function __construct(){
        $this->tablename       = 'sitelog';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('LogIndex', 'KuskiIndex', 'LogType', 'IP', 'DateTime', 'Date', 'Time', 'Referer', 'Browser', 'Page', 'Unique');
        $this->fieldlist['LogIndex'] = array('pkey' => 'y');
		$this->fieldlist['KuskiIndex'] = array('key' => 'y');
				
    } // end class constructor

} // end class

?>