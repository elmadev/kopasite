<?php

require_once("db_class.php");
class Upload extends Database{

    function Upload(){
        $this->tablename       = 'upload';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('UploadIndex', 'KuskiIndex', 'Privacy', 'Duration', 'Duplicate', 'Filename', 'Filetype', 'FileData', 'DateTime');
        $this->fieldlist['UploadIndex'] = array('pkey' => 'y');
		$this->fieldlist['KuskiIndex'] = array('key' => 'y');
				
    } // end class constructor

} // end class

?>