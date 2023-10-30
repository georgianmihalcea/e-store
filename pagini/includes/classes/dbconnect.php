<?php

class Database {

	private $connection = null;
	private $is_real_escape_string_active = null;
    private $db_host = null;
    private $db_user = null;
    private $db_pass = null;
    private $db_name = null;
	public function __construct($db_host, $db_user, $db_pass, $db_name) {
		$this->is_real_escape_string_active = function_exists("mysqli_real_escape_string");
        $this->host = $db_host;
        $this->user = $db_user;
        $this->pass = $db_pass;
        $this->name = $db_name;

	}

	public function open() {

            // Open database connection
		    $this->connection = mysqli_connect($this->host, $this->user, $this->pass) or die(mysqli_error());
            // Select target database
		    mysqli_select_db($this->connection, $this->name) or die(mysqli_error());


	}

    public function sanitize($var)
    {
        $this->open();
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $this->connection->real_escape_string($var);
    }


	public function execute($statement) {

		// Open database connection
		$this->open();
	    mysqli_query($this->connection, "SET NAMES 'utf8'");
        mysqli_report(MYSQLI_REPORT_ERROR);
		// Execute database statement
		$result = mysqli_query($this->connection, $statement);

		$last_id = mysqli_insert_id($this->connection);

		// Close database connection
		if($result){
			$results = array(
			"status" => 1,
            "results" => $result,
			"last_id" =>$last_id
			);
		}else{
			$results = array(
			"status" => 0,
            "results" => $result,
            "error" => mysqli_error($this->connection),
			);
		}

		$this->close();
		// Return results
		return $results;
	}

    public function update($statement) {

		// Open database connection
		$this->open();
	    mysqli_query($this->connection, "SET NAMES 'utf8'");
        mysqli_report(MYSQLI_REPORT_ERROR);
		// Execute database statement
		$result = mysqli_query($this->connection, $statement);

		// Close database connection
		if($result){
			$results = array(
			"status" => 1,
            "results" => $result,
			);
		}else{
			$results = array(
			"status" => 0,
            "results" => $result,
            "error" => mysqli_error($this->connection),
			);
		}

		$this->close();
		// Return results
		return $results;
	}

	public function select($statement) {
	
		// Open database connection
		$this->open();
	    mysqli_query($this->connection, "SET NAMES 'utf8'");
        mysqli_report(MYSQLI_REPORT_ERROR);
		// Execute database statement
		$result = mysqli_query($this->connection, $statement)or die(mysqli_error($this->connection));
		// Close database connection
				$this->close();
		// Return results
		return $result;
	}
    public function error() {
		$this->open();
        return mysqli_error($this->connection);
		$this->close();
	}
	public function escape($result) {
		return mysqli_real_escape_string($result);
	}
    public function escape_html($result) {
		return htmlspecialchars($result);
	}
    public function unescape_html($result) {
		return htmlspecialchars_decode($result);
	}
    public function html_encode($result) {
		return htmlentities($result);
	}
    public function html_decode($result) {
		return html_entity_decode($result);
	}
	public function fetch($result) {
		return mysqli_fetch_array($result);
	}
	public function result($result) {
		return mysqli_result($result);
	}
	public function free_result($result) {
		return mysqli_free_result($result);
	}
	public function assoc($result) {
		return mysqli_fetch_assoc($result);
	}
	public function num($result) {
		return mysqli_num_rows($result);
	}
    public function obj($result) {
		return mysqli_fetch_object($result);
	}

	public function close() {

		// Close database connection
		if (isset($this->connection)) {
			mysqli_close($this->connection);
		}
	}
}


$database = new Database($db['db_host'], $db['db_user'], $db['db_pass'], $db['db_name']);
