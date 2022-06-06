<?php

require_once("db_class.php");
class Upload_users extends Database{

    function Upload_users(){
        $this->tablename       = 'upload_users';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('UploadUserIndex', 'UploadIndex', 'KuskiIndex');
		$this->fieldlist['UploadUserIndex'] = array('pkey' => 'y');
        $this->fieldlist['UploadIndex'] = array('key' => 'y');
		$this->fieldlist['KuskiIndex'] = array('key' => 'y');
				
    } // end class constructor

} // end class

?>