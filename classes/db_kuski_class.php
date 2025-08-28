<?php

require_once("db_class.php");
class Kuski extends Database{

    function __construct(){
        $this->tablename       = 'kuski';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('KuskiIndex', 'Kuski', 'Team', 'Country', 'Email', 'Registered', 'Password', 'Confirmed');
        $this->fieldlist['KuskiIndex'] = array('pkey' => 'y');
				
    } // end class constructor

} // end class

?>