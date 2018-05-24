<?php
/**
 * cms class loads, saves, searches and manages pages and structure of the website
 * http://www.hiteshagrawal.com/mysql/database-class-in-php5
 * 
 * currently meant for MySQL only
 * 
 * @author kms
 * @author clemens
 */
class Database {
	protected $user;
    protected $password;
    protected $database;
    protected $host;

    // Database Connection Link
    protected $conn;

    public function __construct($user, $password, $database, $host) {
	    $this->host = $host;
	    $this->user = $user;
	    $this->password = $password;
	    $this->database = $database;
	      	 
	    $this->conn = mysqli_connect(
	    	$this->host,$this->user,$this->password);
	    if (!$this->conn) {
	    	throw new Exception("Error connecting to the database: " . 
	    		mysqli_connect_error() . "; ErrorNo:" . mysqli_connect_errno());
	    }
	    	//mysql_query("SET NAMES 'utf8'");
		//mysql_query("SET CHARACTER SET 'utf8'");
		$this->conn->set_charset('utf8');
	
		if ($this->conn) {
	    		mysqli_select_db($this->conn,$this->database);
		} else {
	    		echo "unable to connect to db" . mysql_error();
	    }	
    }

    /**
     * close the mysql link on exit
     */
    public function __destruct() {
    	@mysqli_close($this->conn);
    }

    /**
     * query the database
     * @param String $sql query string
     * @return value will vary depending on the query type.
     * 	SELECT queries will return an array of data, INSERT the insert id and 
     * 	UPDATE/DELETE the number of updated rows
     */
 	public function query($sql) {
		$res = mysqli_query($sql, $this->conn);
		if (!$res) {
			throw new Exception("Error while executing query:\n" .
				"$sql\n" .	
				"Error No: " . mysqli_connect_errno($this->conn) . "\n" .
				mysqli_connect_error($this->conn));
		}
		$queryType = $this->determineQueryType($sql);
        	if ($queryType == "SELECT") {
        		if (mysql_num_rows($res) > 0) {
    	        	$rows = array();
					while ($row = mysql_fetch_assoc($res)) {
						$rows[] = $row;
					}
             		return $rows;
				} else {
					return array();
				}
			} else if ($queryType == "INSERT") {
				return mysqli_insert_id($this->conn);
			} else if ($queryType == "UPDATE" || $queryType == "DELETE") {
				return mysqli_affected_rows($this->conn);
			}
    }
    
    /**
     * determine the type of a query
     * @param string $sql query string
     * @return string query type, which should be one of SELECT, INSERT or UPDATE
     */
    protected function determineQueryType($sql) {
    	return strtoupper(substr(trim($sql), 0, 6));	
    }
}
?>
