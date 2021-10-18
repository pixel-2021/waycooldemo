<?php
	include_once ('ez_sql_core.php');

	include_once ('ez_sql_mysqli.php');
class Model {
	private $connection;
	private $pdo;

	public function __construct()
	{
		global $config;	 

		//this->settings = parse_ini_file("settings.ini.php");
        $dsn  = 'mysql:dbname=' . $config['db_name'] . ';host=' . $config['db_host'] . '';
        try {
			
		/*	print_r('jjj'); die();
			
            # Read settings from INI file, set UTF8
            $this->pdo = new PDO($dsn,  $config['db_username'], $config['db_password'], array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
            
            # We can now log any exceptions on Fatal error. 
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            # Connection succeeded, set the boolean to true.
            $this->bConnected = true;  */
			
			$this->pdo = new ezSQL_mysqli( $config['db_username'],$config['db_password'],$config['db_name'], $config['db_host']);
			
			
			
			
        }
        catch (PDOException $e) {
            # Write into log
            echo $this->ExceptionLog($e->getMessage());
            die();
        }	
     	
		
	}
	
	
	  public function CloseConnection()
    {
        # Set the PDO object to null to close the connection
        # http://www.php.net/manual/en/pdo.connections.php
        $this->pdo = null;
    }
	

    
    /**
     *	Every method which needs to execute a SQL query uses this method.
     *	
     *	1. If not connected, connect to the database.
     *	2. Prepare Query.
     *	3. Parameterize Query.
     *	4. Execute Query.	
     *	5. On exception : Write Exception into the log + SQL query.
     *	6. Reset the Parameters.
     */
    private function Init($query, $parameters = "")
    {
        # Connect to database
        if (!$this->bConnected) {
            $this->Connect();
        }
        try {
            # Prepare query
            $this->sQuery = $this->pdo->prepare($query);
            
            # Add parameters to the parameter array	
            $this->bindMore($parameters);
            
            # Bind parameters
            if (!empty($this->parameters)) {
                foreach ($this->parameters as $param => $value) {
                    
                    $type = PDO::PARAM_STR;
                    switch ($value[1]) {
                        case is_int($value[1]):
                            $type = PDO::PARAM_INT;
                            break;
                        case is_bool($value[1]):
                            $type = PDO::PARAM_BOOL;
                            break;
                        case is_null($value[1]):
                            $type = PDO::PARAM_NULL;
                            break;
                    }
                    // Add type when binding the values to the column
                    $this->sQuery->bindValue($value[0], $value[1], $type);
                }
            }
            
            # Execute SQL 
            $this->sQuery->execute();
        }
        catch (PDOException $e) {
            # Write into log and display Exception
            echo $this->ExceptionLog($e->getMessage(), $query);
            die();
        }
        
        # Reset the parameters
        $this->parameters = array();
    }
    
    /**
     *	@void 
     *
     *	Add the parameter to the parameter array
     *	@param string $para  
     *	@param string $value 
     */
    public function bind($para, $value)
    {
        $this->parameters[sizeof($this->parameters)] = [":" . $para , $value];
    }
    /**
     *	@void
     *	
     *	Add more parameters to the parameter array
     *	@param array $parray
     */
    public function bindMore($parray)
    {
        if (empty($this->parameters) && is_array($parray)) {
            $columns = array_keys($parray);
            foreach ($columns as $i => &$column) {
                $this->bind($column, $parray[$column]);
            }
        }
    }
    /**
     *  If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row
     *	If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows
     *
     *   	@param  string $query
     *	@param  array  $params
     *	@param  int    $fetchmode
     *	@return mixed
     */
  
    
    /**
     *  Returns the last inserted id.
     *  @return string
     */
    public function lastInsertId()
    {
	
        return $this->pdo->insert_id;
    }
    
    /**
     * Starts the transaction
     * @return boolean, true on success or false on failure
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }
    
    /**
     *  Execute Transaction
     *  @return boolean, true on success or false on failure
     */
    public function executeTransaction()
    {
        return $this->pdo->commit();
    }
    
    /**
     *  Rollback of Transaction
     *  @return boolean, true on success or false on failure
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }
    
    /**
     *	Returns an array which represents a column from the result set 
     *
     *	@param  string $query
     *	@param  array  $params
     *	@return array
     */
    public function column($query, $params = null)
    {
        $this->Init($query, $params);
        $Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);
        
        $column = null;
        
        foreach ($Columns as $cells) {
            $column[] = $cells[0];
        }
        
        return $column;
        
    }
    /**
     *	Returns an array which represents a row from the result set 
     *
     *	@param  string $query
     *	@param  array  $params
     *   	@param  int    $fetchmode
     *	@return array
     */
    public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        $this->Init($query, $params);
        $result = $this->sQuery->fetch($fetchmode);
        $this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued,
        return $result;
    }
    /**
     *	Returns the value of one single field/column
     *
     *	@param  string $query
     *	@param  array  $params
     *	@return string
     */
    public function single($query, $params = null)
    {
        $this->Init($query, $params);
        $result = $this->sQuery->fetchColumn();
        $this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued
        return $result;
    }
    /**	
     * Writes the log and returns the exception
     *
     * @param  string $message
     * @param  string $sql
     * @return string
     */
    private function ExceptionLog($message, $sql = "")
    {
        $exception = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";
        
        if (!empty($sql)) {
            # Add the Raw SQL to the Log
            $message .= "\r\nRaw SQL : " . $sql;
        }
        # Write into log
        $this->log->write($message);
        
        return $exception;
    }

	
	
	public function to_bool($val)
	{
	    return !!$val;
	}
	
	public function to_date($val)
	{
	    return date('Y-m-d', $val);
	}
	
	public function to_time($val)
	{
	    return date('H:i:s', $val);
	}
	
	public function to_datetime($val)
	{
	    return date('Y-m-d H:i:s', $val);
	}
	
	
	
	public function get_a_line($query=null,$output=ARRAY_A,$y=0)
	{
	
			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->pdo->query($query);
			}

			// If the output is an object then return object using the row offset..
			if ( $output == OBJECT )
			{
				return $this->pdo->last_result[$y]?$this->last_result[$y]:null;
				
			}
			// If the output is an associative array then return row as such..
			elseif ( $output == ARRAY_A )
			{
				$rslt=get_object_vars($this->pdo->last_result[$y]);
				$i=0;
				$rsltArr=array();
				foreach($rslt as $row=>$val)
				{
					$rsltArr[$row]=$val;
					$rsltArr[$i++]=$val;
					
				}
		
				return $rsltArr;
				
			}
			// If the output is an numerical array then return row as such..
			elseif ( $output == ARRAY_N )
			{
				return $this->pdo->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
			}
			// If invalid output type was specified..
			else
			{
				$this->pdo->show_errors ? trigger_error(" \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N",E_USER_WARNING) : null;
			}	

		
		 
     		
	
	}
	
		
	function get_rsltset($query=null, $output = ARRAY_A)
	{
			
			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->pdo->query($query);
			}

			// Send back array of objects. Each row is an object
			if ( $output == OBJECT )
			{
				return $this->pdo->last_result;
			}
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->pdo->last_result )
				{
					$i=0;
					foreach( $this->pdo->last_result as $row )
					{
						$j=0;
						$new_array[$i] = get_object_vars($row);
						
					
						foreach($row as $r=>$v)
						{
							$new_array[$i][$j] =$v;
							$j++;
						}

						if ( $output == ARRAY_N )
						{
							$new_array[$i] = array_values($new_array[$i]);
						}

						$i++;
					}
					
					return $new_array;
				}
				else
				{
					return array();
				}
			}
	}
	
	


	public function insert($query)
  	{
		
			// This keeps the connection alive for very long running scripts
			if ( $this->pdo->num_queries >= 500 )
			{
				$this->pdo->disconnect();
				$this->pdo->quick_connect($this->dbuser,$this->dbpassword,$this->dbname,$this->dbhost,$this->dbport,$this->encoding);
			}
			
			

			// Initialise return
			$return_val = 0;

			// Flush cached values..
			$this->pdo->flush();

			// For reg expressions
			$query = trim($query);

		

			// Keep track of the last query for debug..
			$this->pdo->last_query = $query;

			// Count how many queries there have been
			$this->pdo->num_queries++;
			
			// Start timer
			$this->pdo->timer_start($this->num_queries);

			

			// If there is no existing database connection then try to connect
			if ( ! isset($this->pdo->dbh) || ! $this->pdo->dbh )
			{
				$this->pdo->connect($this->pdo->dbuser, $this->pdo->dbpassword,$this->pdo->dbhost, $this->pdo->dbport);
				$this->pdo->select($this->pdo->dbname,$this->pdo->encoding);
				// No existing connection at this point means the server is unreachable
				if ( ! isset($this->pdo->dbh) || ! $this->pdo->dbh ||$this->pdo->dbh->connect_errno )
					return false;
			}

		
			$this->pdo->result = @$this->pdo->dbh->query($query);

			// If there is an error then take note of it..
			if ( $str = @$this->pdo->dbh->error )
			{
				$this->pdo->register_error($str);
				$this->pdo->show_errors ? trigger_error($str,E_USER_WARNING) : null;
				return false;
			}

			// Query was an insert, delete, update, replace
			if ( preg_match("/^(insert|delete|update|replace|truncate|drop|create|alter|begin|commit|rollback|set|lock|unlock|call)/i",$query) )
			{
				$is_insert = true;
				$this->pdo->rows_affected = @$this->pdo->dbh->affected_rows;
					
				// Take note of the insert_id
				if ( preg_match("/^(insert|replace)\s+/i",$query) )
				{
					 $this->pdo->insert_id = @$this->pdo->dbh->insert_id;
				}

				// Return number fo rows affected
				$return_val =$this->pdo->rows_affected;
			}
			// Query was a select
			else
			{
				$is_insert = false;

				// Take note of column info
				$i=0;
				while ($i < @$this->pdo->result->field_count)
				{
					$this->pdo->col_info[$i] = @$this->pdo->result->fetch_field();
					$i++;
				}

				// Store Query Results
				$num_rows=0;
				while ( $row = @$this->pdo->result->fetch_object() )
				{
					// Store relults as an objects within main array
					$this->pdo->last_result[$num_rows] = $row;
					$num_rows++;
				}

				@$this->pdo->result->free_result();

				// Log number of rows the query returned
				$this->pdo->num_rows = $num_rows;

				// Return number of rows selected
				$return_val = $this->pdo->num_rows;
			}

			// disk caching of queries
			$this->pdo->store_cache($query,$is_insert);

			// If debug ALL queries
			$this->pdo->trace || $this->pdo->debug_all ? $this->pdo->debug() : null ;

			// Keep tack of how long all queries have taken
			$this->pdo->timer_update_global($this->num_queries);

			// Trace all queries
			if ( $this->pdo->use_trace_log )
			{
				$this->pdo->trace_log[] = $this->pdo->debug(false);
			}

			return $return_val;

		
	
      
	}	
	

	
	 
		
		
	function get_client_ip() 
	{
		
			$ipaddress = '';			
			if (isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			return $ipaddress;
	}
	
		function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
			
			$output = NULL;
			if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
				
				$ip = $_SERVER["REMOTE_ADDR"];
				if ($deep_detect) {
					if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
						$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
					if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
						$ip = $_SERVER['HTTP_CLIENT_IP'];
				}
			}
		
			$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
			$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
			$continents = array(
				"AF" => "Africa",
				"AN" => "Antarctica",
				"AS" => "Asia",
				"EU" => "Europe",
				"OC" => "Australia (Oceania)",
				"NA" => "North America",
				"SA" => "South America"
			);
			
			if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
				$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
	//						print_r($ipdat);
//							die();

				if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
					switch ($purpose) {
						case "location":
							$output = array(
								"city"           => @$ipdat->geoplugin_city,
								"state"          => @$ipdat->geoplugin_regionName,
								"country"        => @$ipdat->geoplugin_countryName,
								"country_code"   => @$ipdat->geoplugin_countryCode,
								"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
								"continent_code" => @$ipdat->geoplugin_continentCode
							);
							break;
						case "address":
							$address = array($ipdat->geoplugin_countryName);
							if (@strlen($ipdat->geoplugin_regionName) >= 1)
								$address[] = $ipdat->geoplugin_regionName;
							if (@strlen($ipdat->geoplugin_city) >= 1)
								$address[] = $ipdat->geoplugin_city;
							$output = implode(", ", array_reverse($address));
							break;
						case "city":
							$output = @$ipdat->geoplugin_city;
							break;
						case "state":
							$output = @$ipdat->geoplugin_regionName;
							break;
						case "region":
							$output = @$ipdat->geoplugin_regionName;
							break;
						case "country":
							$output = @$ipdat->geoplugin_countryName;
							break;
						case "countrycode":
							$output = @$ipdat->geoplugin_countryCode;
							break;
					}
				}
			}
			
			//$country=$this->loadModel('country_model');
			
			
			$countryid="";
			
			if(empty($output) || $output==" " )
			{
				
				$countryid=$this->GetIPtocountry($ip);			
			}
			else
			{
				$countryid=$this->GetIPtocountry('',$output);
			}
			
			return $countryid;
		}
	public function GetIPtocountry($ip=null,$countrycode=null){		
		require_once(APP_DIR . "../common/qrycontainer.php");	
		$result = GetIPtocountry($this,$ip,$countrycode);	
		return $result;
	}	

}
?>