<?php

require_once("db_class.php");
class Comment extends Database{

    function Comment(){
        $this->tablename       = 'comment';
        $this->dbname          = 'kopasite';
        $this->fieldlist       = array('CommentIndex', 'KuskiIndex', 'LevelIndex', 'LevelPackIndex', 'KuskiCommentIndex', 'Datetime', 'Comment', 'Private');
        $this->fieldlist['CommentIndex'] = array('pkey' => 'y');
		$this->fieldlist['KuskiIndex'] = array('key' => 'y');
		$this->fieldlist['LevelIndex'] = array('key' => 'y');
		$this->fieldlist['LevelPackIndex'] = array('key' => 'y');
		$this->fieldlist['KuskiCommentIndex'] = array('key' => 'y');
		$this->fieldlist['Datetime'] = array('default' => date("Y-m-d H:i:s"));
				
    } // end class constructor

} // end class

?>