<?php

require_once("db_class.php");
class Tips extends Database{

    function Tips(){
        $this->tablename       = 'tips';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('TipsIndex', 'Name', 'Text', 'Link', 'Priority');
        $this->fieldlist['TipsIndex'] = array('pkey' => 'y');
				
    } // end class constructor

} // end class

?>