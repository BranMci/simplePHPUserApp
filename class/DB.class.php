<?php
//DB.class.php

class DB {
	protected $db_name = 'users';
	protected $db_user = 'tablemaster';
	protected $db_pass = 'alongandcomplexpasswordisbest';
	protected $db_host = 'localhost';

	//Open a connection to the db. This should be called on every page that uses the db.

	public function connect() {
		$connection = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
		mysql_select_db($this->$db_name);

		return true;
	}

	//Returns an associated array from a mysql row set, where the keys are column names.
	//If singleRow is set to true, a single row will be returned instead of an array of rows.
	//Note to self: defining a constant like this amounts to a default value that can be overriden.

	public function processRowSet($rowSet, $singleRow=false){
		$resultArray = array();
		while($row = mysql_fetch_assoc($rowSet)) {
			array_push($resultArray, $row);
		}

		if($singleRow === true) 
			return $resultArray[0];

		return $resultArray;
	}

	//Select rows from the database. 
	//Returns a full row or rows from $table using $where as a location.
	//Return value is an asociative array with column names as keys.

	public function select($table, $where, $columns="*") {
		//extra credit: allow for a new argument to pass column names to the query, default to all
		if($columns != "*") {
			$column = "";
			foreach($columns as $title) {
				$column .= ($column == "") ? "" : ", ";
				$column .= $title;	
			}
			$columns = $column;
		}

		$sql = "SELECT $columns FROM $table WHERE $where";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);

		return $this->processRowSet($result);
	}

	//Updates a current row in the database.
	//Accepts an associative array of data, where the keys are column names,
	//and the values are data that will be inserted into those columns. (hence $column => $value in foreach)
	//$table is the name of the table, and $where is the sql where clause.

	public function update($data, $table, $where) {
		foreach ($data as $column => $value) {
			$sql = "UPDATE $table SET $column = $value WHERE $where";
			mysql_query($sql) or die(mysql_error());
		}
		return true;
	}

	//Inserts a new row into the database.
	//Accepts an associative array of data. Keys are column names.
	//Values are data to be inserted into the corresponding column.
	//$table is the name of the table.
	public function insert($data, $table) {
		$columns = "";
		$values = "";

		foreach ($data as $column => $value) {
			//If $columns is empty, do nothing. Otherwise, add a comma and space.
			$columns .= ($columns == "") ? "" : ", ";
			$columns .= $column;
			$values .= ($values == "") ? "" : ", ";
			$values .= $value;
		}

		$sql = "insert into $table ($columns) values ($values)";

		mysql_query($sql) or die(mysql_error());

		//Returns the ID (AUTO_INCREMENT) of the last sql operation.
		return mysql_insert_id();


	}

	//Extra credit: extend the db class to have a function that deletes a row from the table.

	public function delete_user($table, $where) {
		$sql = "DELETE FROM $table WHERE $where";
		mysql_query($sql) or die(mysql_error());
	}
}

?>