<?php
class Database
{
    // Connection parameters
	
    var $host = "";
    var $user = "";
    var $password = "";
    var $database = "";

    var $persistent = false;

	// Database connection handle 
    var $conn = NULL;

    // Query result 
    var $result = false;

//    function DB($host, $user, $password, $database, $persistent = false)
    function Database()
    {
		$config = new Config();

		$this->host = $config->host;
		$this->user = $config->user;
		$this->password = $config->password;
		$this->database = $config->database;
   	
	}

    function open()
    {


        // Connect to the MySQL server 
        $this->conn = mysqli_connect($this->host, $this->user, $this->password,$this->database);
        if (!$this->conn) {
		header("Location: error.html");
		//echo mysql_error();
	    exit;
            return false;
        }
        return true;
    }

    function close()
    {
        return (mysqli_close($this->conn));
    }
    
    function error()
    {
        return (mysqli_error());
    }

    function query($sql = '')
    {
        $this->result = mysqli_query($this->conn,$sql);
		return ($this->result);
    }

    function numRows()
    {
        return (mysqli_num_rows($this->result));
    }

    function fetchArray()
    {
        return (mysqli_fetch_array($this->result, MYSQLI_BOTH));
    }

     function mysqli_result($result, $row, $field = 0) {
        // Adjust the result pointer to that specific row
        $result->data_seek($row);
        // Fetch result array
        $data = $result->fetch_array();
     
        return $data[$field];
    }

    function escapestring($data) {
         return (mysqli_real_escape_string($this->conn, $data)); 
    }

  }
?>