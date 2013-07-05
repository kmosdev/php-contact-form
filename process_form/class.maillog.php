<?php 
require_once('config.php');

class MailLog {
	/*
	* Open the sql connection
	*/
	public function __construct() {
		global $config;
		$this->config = $config;

		// Set default timezone
  		date_default_timezone_set($this->config['timezone']);
		try { 
			// Create (connect to) SQLite database in file
			$this->db = new PDO('sqlite:'.$this->config['dbfile']);
			// Set errormode to exceptions
			$this->db->setAttribute(PDO::ATTR_ERRMODE, 
			                        PDO::ERRMODE_EXCEPTION);
			$query = "CREATE TABLE IF NOT EXISTS mlog (
			                id INTEGER PRIMARY KEY,";
			foreach($this->config['fields'] as $field) {
				$query .= (string) $field . ' TEXT,';
			}
			$query .= "time INTEGER)";
			// Create table mlog if it doesn't exist
			// now we can easily archive old files when they get too big
			$this->db->exec($query);
		} catch(PDOException $e) {
		    // Print PDOException message
		    return $e->getMessage();
	  	}
	}
	/*
	* Add a record
	*/
	public function add($data) {
		function addColon($a) {
			return ':'.$a;
		}

		$column_list = implode(',', $this->config['fields']);
		$keys = array_keys($data);

		$param_list = implode(',',array_map('addColon',$keys));

		if(empty($data['time'])) {
			$time = time();
			$data['time'] = $time;

			$column_list .= ',time';
			$param_list .= ',:time';
		}

		$sql = "insert into mlog (".$column_list.") VALUES (".$param_list.")";
		
		$statement = $this->db->prepare($sql);
		if ($statement === false) {
		  //die(print_r($this->db->errorInfo(), true));
			die();
		}
		
		$status = $statement->execute($data);
		return $status;
		
	}
	/*
	* Get Records
	*/
	public function getRecords() {
		$result = $this->db->query('SELECT * FROM mlog');
		return $result;
	}
	/*
	* Close the sql connection
	*/
	public function close() {
		$this->db = null;
	}
	
}
?>