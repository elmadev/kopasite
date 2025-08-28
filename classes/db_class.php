<?php

class Database{
	var $tablename;         // table name
	var $dbname;            // database name
	var $fieldlist;         // list of fields in this table
	var $data_array;        // data from the database
	var $errors;            // array of error messages

	var $rows;
	var $from;
	var $where;
	var $groupby;
	var $having;
	var $orderby;
	var $limit;

	function __construct(){ // constructor
		$this->tablename       = 'default';
		$this->dbname          = 'default';

		$this->fieldlist = array('column1', 'column2', 'column3');
		$this->fieldlist['column1'] = array('pkey' => 'y');
	} //function Database

	function db_connect($dbname){

		$dbconnect  = NULL;
		$dbhost     = "localhost";
		$dbusername = "root";
		$dbuserpass = "";
		$query      = NULL;

		global $dbconnect, $dbhost, $dbusername, $dbuserpass;

		if (!$dbconnect) $dbconnect = mysql_connect($dbhost, $dbusername, $dbuserpass);
		if(!$dbconnect){
			return 0;
		}elseif(!mysql_select_db($dbname)){
			return 0;
		}else{
			return $dbconnect;
		}
	} // function db_connect

	function select(){
		$this->data_array = array();

		global $dbconnect, $query;
		//$dbconnect = $this->db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);

		if (empty($this->rows)) {
			$select_str = '*';    // the default is all fields
		} else {
			$select_str = $this->rows;
		}

		if (empty($this->from)) {
			$from_str = $this->tablename;   // the default is current table
		} else {
			$from_str = $this->from;
		}

		if (empty($where)) {
			$where_str = NULL;
		} else {
			$where_str = "WHERE $where";
		}
		if (!empty($this->where)) {
			if (!empty($where_str)) {
				$where_str .= " AND $this->where";
			} else {
				$where_str = "WHERE $this->where";
			}
		}

		if (!empty($this->groupby)) {
			$group_str = "GROUP BY $this->groupby";
		} else {
			$group_str = NULL;
		}

		if (!empty($this->having)) {
			$having_str = "HAVING $this->having";
		} else {
			$having_str = NULL;
		}

		if (!empty($this->orderby)) {
			$sort_str = "ORDER BY $this->orderby";
		} else {
			$sort_str = NULL;
		}

		if (!empty($this->limit)) {
			$limit_str = "LIMIT $this->limit";
		} else {
			$limit_str = NULL;
		}

		$query = "SELECT $select_str
		FROM $from_str 
			$where_str 
			$group_str 
			$having_str 
			$sort_str 
			$limit_str";
		//$result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);
		$result = mysql_query($query) or die(mysql_error());
		//echo $query;
		while ($row = mysql_fetch_assoc($result)) {
			$this->data_array[] = $row;
		}

		mysql_free_result($result);
   
		return $this->data_array;
		//return $query;
      
	} // function select

	function insert ($fieldarray){
		$this->errors = array();
		global $dbconnect, $query;
		//$dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);

		$fieldlist = $this->fieldlist;
		foreach ($fieldarray as $field => $fieldvalue) {
			if (!in_array($field, $fieldlist)) {
				unset ($fieldarray[$field]);
			}
		}

		$query = "INSERT INTO $this->tablename SET ";
		foreach ($fieldarray as $item => $value) {
			$query .= "$item='$value', ";
		}
		foreach($fieldlist as $field => $value){
			if(!isset($fieldarray[$field])){
				if(isset($fieldlist[$field]['default']) && !is_numeric($field)){
					$query .= "$field='".$fieldlist[$field]['default']."', ";
				}
			}
		}
		$query = rtrim($query, ', ');

		$result = @mysql_query($query);
		if (mysql_errno() <> 0) {
			if (mysql_errno() == 1062) {
				$this->errors[] = "A record already exists with this ID.";
			} else {
				trigger_error(mysql_errno(), E_USER_ERROR);
			}
		}
		
		return;
   	   
   } // function insert

	function update ($fieldarray){
		$this->errors = array();
		global $dbconnect, $query;
		//$dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
		$fieldlist = $this->fieldlist;
		foreach ($fieldarray as $field => $fieldvalue) {
			if (!in_array($field, $fieldlist)) {
				unset ($fieldarray[$field]);
			}
		}
		$where  = NULL;
		$update = NULL;
		foreach ($fieldarray as $item => $value) {
			if (isset($fieldlist[$item]['pkey'])) {
				$where .= "$item='$value' AND ";
			} else {
				$update .= "$item='$value', ";
			}
		}
		$where  = rtrim($where, ' AND ');
		$update = rtrim($update, ', ');
		$query = "UPDATE $this->tablename SET $update WHERE $where";
		$result = mysql_query($query) or trigger_error($query, E_USER_ERROR);
      
		return;
      
	} // update

} // class Database
?>