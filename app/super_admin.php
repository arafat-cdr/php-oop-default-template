<?php
require_once(__DIR__.'/conn.php');
/**

**	USING FUNCTIONS
**  dbSelect('my_table', $select, "WHERE fecha = '$fecha'");
**  dbInsert('my_table', $form_data);
**  dbUpdate('my_table', $form_data, "WHERE id = '$id'");
**  dbdDelete('my_table', "WHERE id = '$id'");
*/
class super_admin {
	
	public $conn;

	public function __construct() {
		$obj = new Conn();
		$this->conn = $obj->db_connect();

	}

	public function dbSelect($table_name, $select='*', $where_clause='') {
		// check for optional where clause
		$whereSQL = '';

		if(!empty($where_clause)) {
		    // check to see if the 'where' keyword exists
		    if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
		        // not found, add key word
		        $whereSQL = " WHERE ".$where_clause;
		    } else {
		        $whereSQL = " ".trim($where_clause);
		    }
		}
		// start the actual SQL statement
		$sql = "SELECT ".$select." FROM ".$table_name." ";
		// append the where statement
		$sql .= $whereSQL;
		// run and return the query result

		//echo $sql; exit();

		$res = $this->conn->query($sql);

		$data = array();
		
		if($res) {

			while ($row = mysqli_fetch_object($res)) {
			         $data[] = $row;
			    }

			return $data;

		} else {
			return FALSE;
		}
		
	}

	public function dbInsert($table_name, $form_data) {
		// retrieve the keys of the array (column titles)
		$fields = array_keys($form_data);
		// build the query
		$sql = "INSERT INTO ".$table_name."(`".implode('`,`', $fields)."`) VALUES('".implode("','", $form_data)."')";
		// run and return the query result resource
		
		//echo $sql; exit();

		$res = $this->conn->query($sql);

		if($res) {
			return $this->conn->insert_id;
		}
		else {
			return FALSE;
		}
		
	}

	public function dbUpdate($table_name, $form_data, $where_clause=''){
		// check for optional where clause
		$whereSQL = '';
		if(!empty($where_clause))
		{
		    // check to see if the 'where' keyword exists
		    if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
		    {
		        // not found, add key word
		        $whereSQL = " WHERE ".$where_clause;
		    } else
		    {
		        $whereSQL = " ".trim($where_clause);
		    }
		}
		// start the actual SQL statement
		$sql = "UPDATE ".$table_name." SET ";
		// loop and build the column /
		$sets = array();
		foreach($form_data as $column => $value)
		{
		     $sets[] = "`".$column."` = '".$value."'";
		}
		$sql .= implode(', ', $sets);
		// append the where statement
		$sql .= $whereSQL;
		
		//echo $sql; die();

		// run and return the query result
		$res = $this->conn->query($sql);

		if($this->conn->affected_rows) {

			return TRUE;
		}

		return  FALSE;

	}

	public function dbDelete($table_name, $where_clause='') {
		// check for optional where clause
		$whereSQL = '';
		if(!empty($where_clause))
		{
		    // check to see if the 'where' keyword exists
		    if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
		    {
		        // not found, add keyword
		        $whereSQL = " WHERE ".$where_clause;
		    } else
		    {
		        $whereSQL = " ".trim($where_clause);
		    }
		}
		// build the query
		$sql = "DELETE FROM ".$table_name.$whereSQL;
		// run and return the query result resource

		$res = $this->conn->query($sql);

		if($res) {

			return TRUE;
		}

		return  FALSE;
	}
	
}