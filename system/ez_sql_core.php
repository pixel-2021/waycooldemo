<?php

	/**********************************************************************
	*  Author: Justin Vincent (jv@vip.ie)
	*  Web...: http://justinvincent.com
	*  Name..: ezSQL
	*  Desc..: ezSQL Core module - database abstraction library to make
	*          it very easy to deal with databases. ezSQLcore can not be used by
	*          itself (it is designed for use by database specific modules).
	*
	*/

	/**********************************************************************
	*  ezSQL Constants
	*/

	define('EZSQL_VERSION','2.17');
	define('OBJECT','OBJECT',true);
	define('ARRAY_A','ARRAY_A',true);
	define('ARRAY_N','ARRAY_N',true);

	/**********************************************************************
	*  Core class containg common functions to manipulate query result
	*  sets once returned
	*/

	class ezSQLcore
	{

		var $trace            = false;  // same as $debug_all
		var $debug_all        = false;  // same as $trace
		var $debug_called     = false;
		var $vardump_called   = false;
		var $show_errors      = true;
		var $num_queries      = 0;
		var $last_query       = null;
		var $last_error       = null;
		var $col_info         = null;
		var $captured_errors  = array();
		var $cache_dir        = false;
		var $cache_queries    = false;
		var $cache_inserts    = false;
		var $use_disk_cache   = false;
		var $cache_timeout    = 24; // hours
		var $timers           = array();
		var $total_query_time = 0;
		var $db_connect_time  = 0;
		var $trace_log        = array();
		var $use_trace_log    = false;
		var $sql_log_file     = false;
		var $do_profile       = false;
		var $profile_times    = array();

		// == TJH == default now needed for echo of debug function
		var $debug_echo_is_on = true;

		/**********************************************************************
		*  Constructor
		*/

		function ezSQLcore()
		{
		}

		/**********************************************************************
		*  Get host and port from an "host:port" notation.
		*  Returns array of host and port. If port is omitted, returns $default
		*/

		function get_host_port( $host, $default = false )
		{
			$port = $default;
			if ( false !== strpos( $host, ':' ) ) {
				list( $host, $port ) = explode( ':', $host );
				$port = (int) $port;
			}
			return array( $host, $port );
		}

		/**********************************************************************
		*  Print SQL/DB error - over-ridden by specific DB class
		*/

		function register_error($err_str)
		{
			// Keep track of last error
			$this->last_error = $err_str;

			// Capture all errors to an error array no matter what happens
			$this->captured_errors[] = array
			(
				'error_str' => $err_str,
				'query'     => $this->last_query
			);
		}

		/**********************************************************************
		*  Turn error handling on or off..
		*/

		function show_errors()
		{
			$this->show_errors = true;
		}

		function hide_errors()
		{
			$this->show_errors = false;
		}

		/**********************************************************************
		*  Kill cached query results
		*/

		function flush()
		{
			// Get rid of these
			$this->last_result = null;
			$this->col_info = null;
			$this->last_query = null;
			$this->from_disk_cache = false;
		}

		/**********************************************************************
		*  Get one variable from the DB - see docs for more detail
		*/
		
		function get_var($query=null,$x=0,$y=0)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_var(\"$query\",$x,$y)";

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// Extract var out of cached results based x,y vals
			if ( $this->last_result[$y] )
			{
				$values = array_values(get_object_vars($this->last_result[$y]));
			}

			// If there is a value return it else return null
			return (isset($values[$x]) && $values[$x]!=='')?$values[$x]:null;
		}

		/**********************************************************************
		*  Get one row from the DB - see docs for more detail
		*/

		function get_row($query=null,$output=OBJECT,$y=0)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_row(\"$query\",$output,$y)";

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// If the output is an object then return object using the row offset..
			if ( $output == OBJECT )
			{
				return $this->last_result[$y]?$this->last_result[$y]:null;
			}
			// If the output is an associative array then return row as such..
			elseif ( $output == ARRAY_A )
			{
				return $this->last_result[$y]?get_object_vars($this->last_result[$y]):null;
			}
			// If the output is an numerical array then return row as such..
			elseif ( $output == ARRAY_N )
			{
				return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
			}
			// If invalid output type was specified..
			else
			{
				$this->show_errors ? trigger_error(" \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N",E_USER_WARNING) : null;
			}

		}

		/**********************************************************************
		*  Function to get 1 column from the cached result set based in X index
		*  see docs for usage and info
		*/
		
		function get_a_line($query=null,$output=ARRAY_A,$y=0)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_row(\"$query\",$output,$y)";
			

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// If the output is an object then return object using the row offset..
			if ( $output == OBJECT )
			{
				return $this->last_result[$y]?$this->last_result[$y]:null;
				
			}
			// If the output is an associative array then return row as such..
			elseif ( $output == ARRAY_A )
			{
				$rslt=get_object_vars($this->last_result[$y]);
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
				return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
			}
			// If invalid output type was specified..
			else
			{
				$this->show_errors ? trigger_error(" \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N",E_USER_WARNING) : null;
			}

		}
		
		
		function get_columnCount($query)
		{
			if ( $query )
			{
				$this->query($query);
			}
			$cnt=0;
			
			
			
			foreach($this->last_result as $row)
			{
				foreach($row  as $r=>$v)
				{
					$cnt++;
				}
				break;
			}
			return $cnt;			
		}

		function get_col($query=null,$x=0)
		{

			$new_array = array();

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// Extract the column values
			for ( $i=0; $i < count($this->last_result); $i++ )
			{
				$new_array[$i] = $this->get_var(null,$x,$i);
			}

			return $new_array;
		}


		/**********************************************************************
		*  Return the the query as a result set - see docs for more details
		*/

		function get_results($query=null, $output = OBJECT)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_results(\"$query\", $output)";

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// Send back array of objects. Each row is an object
			if ( $output == OBJECT )
			{
				return $this->last_result;
			}
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->last_result )
				{
					$i=0;
					foreach( $this->last_result as $row )
					{

						$new_array[$i] = get_object_vars($row);

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

		
		function get_rsltset($query=null, $output = ARRAY_A)
		{

			// Log how the function was called
			$this->func_call = "\$db->get_results(\"$query\", $output)";

			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}

			// Send back array of objects. Each row is an object
			if ( $output == OBJECT )
			{
				return $this->last_result;
			}
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->last_result )
				{
					$i=0;
					foreach( $this->last_result as $row )
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

		/**********************************************************************
		*  Function to get column meta data info pertaining to the last query
		* see docs for more info and usage
		*/

		function get_col_info($info_type="name",$col_offset=-1)
		{

			if ( $this->col_info )
			{
				if ( $col_offset == -1 )
				{
					$i=0;
					foreach($this->col_info as $col )
					{
						$new_array[$i] = $col->{$info_type};
						$i++;
					}
					return $new_array;
				}
				else
				{
					return $this->col_info[$col_offset]->{$info_type};
				}

			}

		}

		/**********************************************************************
		*  store_cache
		*/

		function store_cache($query,$is_insert)
		{

			// The would be cache file for this query
			$cache_file = $this->cache_dir.'/'.md5($query);

			// disk caching of queries
			if ( $this->use_disk_cache && ( $this->cache_queries && ! $is_insert ) || ( $this->cache_inserts && $is_insert ))
			{
				if ( ! is_dir($this->cache_dir) )
				{
					$this->register_error("Could not open cache dir: $this->cache_dir");
					$this->show_errors ? trigger_error("Could not open cache dir: $this->cache_dir",E_USER_WARNING) : null;
				}
				else
				{
					// Cache all result values
					$result_cache = array
					(
						'col_info' => $this->col_info,
						'last_result' => $this->last_result,
						'num_rows' => $this->num_rows,
						'return_value' => $this->num_rows,
					);
					file_put_contents($cache_file, serialize($result_cache));
					if( file_exists($cache_file . ".updating") )
						unlink($cache_file . ".updating");
				}
			}

		}

		/**********************************************************************
		*  get_cache
		*/

		function get_cache($query)
		{

			// The would be cache file for this query
			$cache_file = $this->cache_dir.'/'.md5($query);

			// Try to get previously cached version
			if ( $this->use_disk_cache && file_exists($cache_file) )
			{
				// Only use this cache file if less than 'cache_timeout' (hours)
				if ( (time() - filemtime($cache_file)) > ($this->cache_timeout*3600) &&
					!(file_exists($cache_file . ".updating") && (time() - filemtime($cache_file . ".updating") < 60)) )
				{
					touch($cache_file . ".updating"); // Show that we in the process of updating the cache
				}
				else
				{
					$result_cache = unserialize(file_get_contents($cache_file));

					$this->col_info = $result_cache['col_info'];
					$this->last_result = $result_cache['last_result'];
					$this->num_rows = $result_cache['num_rows'];

					$this->from_disk_cache = true;

					// If debug ALL queries
					$this->trace || $this->debug_all ? $this->debug() : null ;

					return $result_cache['return_value'];
				}
			}

		}

		/**********************************************************************
		*  Dumps the contents of any input variable to screen in a nicely
		*  formatted and easy to understand way - any type: Object, Var or Array
		*/

		function vardump($mixed='')
		{

			// Start outup buffering
			ob_start();

			echo "<p><table><tr><td bgcolor=ffffff><blockquote><font color=000090>";
			echo "<pre><font face=arial>";

			if ( ! $this->vardump_called )
			{
				echo "<font color=800080><b>ezSQL</b> (v".EZSQL_VERSION.") <b>Variable Dump..</b></font>\n\n";
			}

			$var_type = gettype ($mixed);
			print_r(($mixed?$mixed:"<font color=red>No Value / False</font>"));
			echo "\n\n<b>Type:</b> " . ucfirst($var_type) . "\n";
			echo "<b>Last Query</b> [$this->num_queries]<b>:</b> ".($this->last_query?$this->last_query:"NULL")."\n";
			echo "<b>Last Function Call:</b> " . ($this->func_call?$this->func_call:"None")."\n";
			echo "<b>Last Rows Returned:</b> ".count($this->last_result)."\n";
			echo "</font></pre></font></blockquote></td></tr></table>".$this->donation();
			echo "\n<hr size=1 noshade color=dddddd>";

			// Stop output buffering and capture debug HTML
			$html = ob_get_contents();
			ob_end_clean();

			// Only echo output if it is turned on
			if ( $this->debug_echo_is_on )
			{
				echo $html;
			}

			$this->vardump_called = true;

			return $html;

		}

		/**********************************************************************
		*  Alias for the above function
		*/

		function dumpvar($mixed)
		{
			$this->vardump($mixed);
		}

		/**********************************************************************
		*  Displays the last query string that was sent to the database & a
		* table listing results (if there were any).
		* (abstracted into a seperate file to save server overhead).
		*/

		function debug($print_to_screen=true)
		{

			// Start outup buffering
			ob_start();

			echo "<blockquote>";

			// Only show ezSQL credits once..
			if ( ! $this->debug_called )
			{
				echo "<font color=800080 face=arial size=2><b>ezSQL</b> (v".EZSQL_VERSION.") <b>Debug..</b></font><p>\n";
			}

			if ( $this->last_error )
			{
				echo "<font face=arial size=2 color=000099><b>Last Error --</b> [<font color=000000><b>$this->last_error</b></font>]<p>";
			}

			if ( $this->from_disk_cache )
			{
				echo "<font face=arial size=2 color=000099><b>Results retrieved from disk cache</b></font><p>";
			}

			echo "<font face=arial size=2 color=000099><b>Query</b> [$this->num_queries] <b>--</b> ";
			echo "[<font color=000000><b>$this->last_query</b></font>]</font><p>";

				echo "<font face=arial size=2 color=000099><b>Query Result..</b></font>";
				echo "<blockquote>";

			if ( $this->col_info )
			{

				// =====================================================
				// Results top rows

				echo "<table cellpadding=5 cellspacing=1 bgcolor=555555>";
				echo "<tr bgcolor=eeeeee><td nowrap valign=bottom><font color=555599 face=arial size=2><b>(row)</b></font></td>";


				for ( $i=0; $i < count($this->col_info); $i++ )
				{
					/* when selecting count(*) the maxlengh is not set, size is set instead. */
					echo "<td nowrap align=left valign=top><font size=1 color=555599 face=arial>{$this->col_info[$i]->type}";
					if (!isset($this->col_info[$i]->max_length))
					{
						echo "{$this->col_info[$i]->size}";
					} else {
						echo "{$this->col_info[$i]->max_length}";
					}
					echo "</font><br><span style='font-family: arial; font-size: 10pt; font-weight: bold;'>{$this->col_info[$i]->name}</span></td>";
				}

				echo "</tr>";

				// ======================================================
				// print main results

			if ( $this->last_result )
			{

				$i=0;
				foreach ( $this->get_results(null,ARRAY_N) as $one_row )
				{
					$i++;
					echo "<tr bgcolor=ffffff><td bgcolor=eeeeee nowrap align=middle><font size=2 color=555599 face=arial>$i</font></td>";

					foreach ( $one_row as $item )
					{
						echo "<td nowrap><font face=arial size=2>$item</font></td>";
					}

					echo "</tr>";
				}

			} // if last result
			else
			{
				echo "<tr bgcolor=ffffff><td colspan=".(count($this->col_info)+1)."><font face=arial size=2>No Results</font></td></tr>";
			}

			echo "</table>";

			} // if col_info
			else
			{
				echo "<font face=arial size=2>No Results</font>";
			}

			echo "</blockquote></blockquote>".$this->donation()."<hr noshade color=dddddd size=1>";

			// Stop output buffering and capture debug HTML
			$html = ob_get_contents();
			ob_end_clean();

			// Only echo output if it is turned on
			if ( $this->debug_echo_is_on && $print_to_screen)
			{
				echo $html;
			}

			$this->debug_called = true;

			return $html;

		}

		/**********************************************************************
		*  Naughty little function to ask for some remuniration!
		*/

	
	
	

		/**********************************************************************
		*  Timer related functions
		*/

		function timer_get_cur()
		{
			list($usec, $sec) = explode(" ",microtime());
			return ((float)$usec + (float)$sec);
		}

		function timer_start($timer_name)
		{
			$this->timers[$timer_name] = $this->timer_get_cur();
		}

		function timer_elapsed($timer_name)
		{
			return round($this->timer_get_cur() - $this->timers[$timer_name],2);
		}

		function timer_update_global($timer_name)
		{
			if ( $this->do_profile )
			{
				$this->profile_times[] = array
				(
					'query' => $this->last_query,
					'time' => $this->timer_elapsed($timer_name)
				);
			}

			$this->total_query_time += $this->timer_elapsed($timer_name);
		}

		/**********************************************************************
		* Creates a SET nvp sql string from an associative array (and escapes all values)
		*
		*  Usage:
		*
		*     $db_data = array('login'=>'jv','email'=>'jv@vip.ie', 'user_id' => 1, 'created' => 'NOW()');
		*
		*     $db->query("INSERT INTO users SET ".$db->get_set($db_data));
		*
		*     ...OR...
		*
		*     $db->query("UPDATE users SET ".$db->get_set($db_data)." WHERE user_id = 1");
		*
		* Output:
		*
		*     login = 'jv', email = 'jv@vip.ie', user_id = 1, created = NOW()
		*/

		function get_set($params)
		{
			if( !is_array( $params ) )
			{
				$this->register_error( 'get_set() parameter invalid. Expected array in '.__FILE__.' on line '.__LINE__);
				return;
			}
			$sql = array();
			foreach ( $params as $field => $val )
			{
				if ( $val === 'true' || $val === true )
					$val = 1;
				if ( $val === 'false' || $val === false )
					$val = 0;

				switch( $val ){
					case 'NOW()' :
					case 'NULL' :
					  $sql[] = "$field = $val";
						break;
					default :
						$sql[] = "$field = '".$this->escape( $val )."'";
				}
			}

			return implode( ', ' , $sql );
		}
		
		
        function insert_log($operation,$table,$id="",$comments="",$module="",$query="")
        {
           
       
           try{
            $user_name = $_SESSION["UName"];
            $user_id = $_SESSION["UserId"];
            $logge_date = date("Y-m-d H:i:s");
           
         /*              TYPES OF INSERT QUERY      */
        // $query="insert into m_country(select `brand_id`,`brand_name` from `cntl_brand` where brand_id=8)";
         //$query="insert into m_country(select `brand_id`,`brand_name` from `cntl_brand`)";
         //$query="insert into m_country(countryID,CountryName)(select `brand_id`,`brand_name` from `cntl_brand`)";
       //  $query="insert into m_country (countryname,sttaus,vvvvv)values ('ddd,ccc','4','dddd,vvvv,bbbb,nnn'";
         //$query="insert into m_country values ('ddd,ccc','4','dddd,vvvv,bbbb,nnn')";
        // $query="INSERT INTO cntl_brand (brand_id,email,status) VALUES (25,'kk@gm,ail.com',5)ON DUPLICATE KEY UPDATE email='sh,iv@gmail.com', status='2,7'";
        
           /*           have to workout      */
           
       //  $query="INSERT INTO cntl_brand (brand_id,email) VALUES(1,'sdsdsd,sdsd'),(4,'ererere,errer@fdf')";
         //$query="INSERT INTO cntl_brand(brand_id,brand_name) VALUES(1,2),(4,5),(7,8) on duplicate key update brand_name='uuuu'";
        
        /*              TYPES OF INSERT QUERY      */
        
               
           /*     GET COLUMNS OF TABLE BY PASSED TABLE ARGUEMENT  */
            $col_res = $this->get_rsltset("desc $table");
            if(!$col_res)
              //  throw new Exception("Error in query execution");
                  $d=0;
                  $cntt=count($col_res);
                   foreach($col_res as $col)
                   {
                       $ass_col .= $col[0];
                       if($d<$cntt-1)
                       $ass_col.="|";
                       $d++;
                   }
              // echo $ass_col; exit;
            /*     GET COLUMNS OF TABLE    */
      
            switch ($operation)
            {
                case "insert":
                
                // If insert operation
                   //echo $query; die();
                    $col = explode($table, $query);
                    
                    if(strpos(strtolower($query),'duplicate') !== false&&strpos(strtolower($query),'values') !== false)
                    {
                      
                        $split_by_on = explode("on duplicate", strtolower($query));
                        
                        $update = str_replace(array("duplicate","key"), "", $split_by_on[1]);  // Update query
                        
                        $insert = str_replace(array("insert","into","$table"), "", $split_by_on[0]);
                        $second = explode("values",trim($insert));
                        
                        if(!empty($second[0]))
                        {
                            $column_comma = substr(trim($second[0]), 1, -1);
                            $value_comma = substr(trim($second[1]), 1, -1);
                          
                            $col_array = explode(",", $column_comma);
                            $val_array = explode(",",$value_comma);
                       
                            $vcnt=count($val_array);
                            $old_val="";
                            $arr_app=array();
                               for($v=0;$v<$vcnt;$v++)
                                {
                                  
                                  $occur=substr_count($val_array[$v], "'");
                                  
                                  if($occur!=2&&$occur!=0) {
                                      
                                        $app=$val_array[$v].",".$val_array[$v+1];
										$app=getRealescape($app);
                                        unset($val_array[$v+1]);
                                    }
                                    else{
                                         $app=$val_array[$v];
										 $app=getRealescape($app);
                                    }
                                    
                                if(!empty($app))
                                  {
                                    $arr_app[]=getRealescape($app);
                                  }
                                  
                                  }
                         //   echo "<pre>"; print_r($arr_app);die();
                            $old_db_val=  str_replace("'","",implode("|",$arr_app));
                         
                            $count_col = count($col_array);
                           
                       // $index = $this->get_rsltset("SHOW INDEX FROM cntl_brand WHERE Column_name = 'brand_id'");
                             $index = $this->get_rsltset("SHOW INDEX FROM $table");
                           //  echo "<pre>";  print_r($index); exit;
                             $cnt = count($index);
                             if($cnt>1)
                             {
                                 $col_arr_unique = array();
                                 foreach ($index as $col)
                                 {
                                     $col_arr_unique[] = $col['Column_name'];   // Array of Unique column of table
                                 }
                             }
                            
                            $db_col = str_replace(",", "|", trim($column_comma));
                            
                            $where_cond="";
                            $ins_arr_coll=array();
                           
                            for($r=0;$r<$count_col;$r++)
                            {
                              // echo $col_array[$r]."<br>";
                        //   echo "<pre>"; print_r($col_arr_unique); exit;
                                
                                if(!empty($col_arr_unique)&&in_array($col_array[$r], $col_arr_unique))
                                {
                                    
                                    $col=$col_array[$r];
                                    $val=$arr_app[$r];
                                    
                                    $where_cond.= "$col=".$val."";
                                    $where_cond.=" or ";
                                    
                                }
                            
                            }
                          //  die();
                            $where_cond = substr($where_cond,0,-3);
                            if(!empty($where_cond))
                                $wc="where $where_cond";
                            else
                                $wc="";
                   //  echo "select * from $table $wc"; die();
                            $check_dup_qry = $this->get_rsltset("select * from $table $wc");
                   
                            if($check_dup_qry>0)  //If duplicate row exists
                            {
                                $opr="update";
                                $old_val="";
                                
                                $get_val_col = str_replace(array("update"," "), "", $update);
                                $a=array('","',"','");
                                $temp = str_replace($a, "", $get_val_col);
                                $result=  explode(",", $temp);                  // Split update statement by comma
                                $cnt=count($result);
                              
                                for($u=0;$u<$cnt;$u++)
                                {

                                  $occur=substr_count($result[$u], "'");

                                  if($occur!=2&&$occur!=0) {

                                        $app=$result[$u].",".$result[$u+1];
										$app=getRealescape($app);
                                        unset($result[$u+1]);
                                    }
                                    else{
                                         $app=$result[$u];
										 $app=getRealescape($app);
                                    }
                                
                                   $sp = explode("=",$app);
                              //   echo "<pre>";                                 print_r($sp); exit;
                                   if(!empty($sp[1]))
                                   $rr[trim($sp[0])]=  str_replace ("'", "", $sp[1]);
                                
                                }
                                   
                                    $key_col = array_keys($rr);         // fields to be updated
                                    $value_col = array_values($rr);     // values to be updated
                                    $db_col_up = implode("|",$key_col);
                                    $db_col_new_val=implode("|",$value_col);
                                    $operation="update";
                                    $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col_up','$operation','$old_db_val','$db_col_new_val','$module','$comments','$logge_date')";
                                  
                                    $this->insert($str);    // Inserted duplicate key update
                           
                            }
                            else {
                                 
                                 $split_val_ins = explode("values",trim(strtolower($insert)));
                      
                       // preg_match_all("^\((.*?)\)^",$second[0],$fields);
                        //echo "<pre>"; print_r($fields);
                        if(!empty($split_val_ins[0]))
                        {
                            $column_comma = substr(trim($split_val_ins[0]), 1, -1);
                            $db_col = str_replace(",", "|", trim($column_comma));
                        }
                        /*  SPLITING FOR NORMAL INSERT QUERY WITHOUT COLUMN  */
                        else {
                             $db_col = $ass_col;
                        }
                      
                        $value_comma = str_replace(' ','',substr(trim($split_val_ins[1]), 1, -1));
						$value_comma =getRealescape($value_comma);
                        
                        $a=array('","',"','",",'","',");
                        $db_col_val = str_replace($a, "|", trim($value_comma));
                       
                        $db_colum_val = str_replace("'", "", $db_col_val);
                       
                        $str="insert into tri_userlog(user_id,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col','$operation','','$db_colum_val','$module','$comments','$logge_date')";
                        
                        $this->insert($str);
                             
                            
                            }
                        
                        }
                                              
                    }
                    
                    /*  SPLITING FOR NORMAL INSERT QUERY IF "VALUES" IS PRESENTED  */
                    else if (strpos(strtolower($query),'values') !== false)
                    {
                     
                   
                        $second = explode("values",trim(strtolower($col[1])));
                        
                        
                        if(!empty($second[0]))
                        {
                            $column_comma = substr(trim($second[0]), 1, -1);
                            $db_col = str_replace(",", "|", trim($column_comma));
                        }
                        /*  SPLITING FOR NORMAL INSERT QUERY WITHOUT COLUMN  */
                        else {
                             $db_col = $ass_col;
                        }
                        
                        
                        $clear_val = str_replace(" ","",$second[1]);
                        if (strpos(strtolower($clear_val),'),(') !== false)
                        {
                            preg_match_all("^\((.*?)\)^",$clear_val,$fields);
                       
                           foreach ($fields[1] as $ins_val)
                           {
                                
                                $a=array('","',"','",",'","',");
                                $db_col_val = str_replace($a, "|", trim($ins_val));
                                $db_col_val_mul=  str_replace("'", "", $db_col_val);
								$result= preg_split("/('[^'\\\\]*(?:\\\\.[^'\\\\]*)*')/", $db_col_val,-1,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
								$db_col_val_mul=getRealescape($db_col_val_mul);
                                
                                 $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col','$operation','','$db_col_val_mul','$module','$comments','$logge_date')";
                                
                                 $this->insert($str);
                                
                                
                           }
                           
                            //echo "<pre>"; print_r($fields);
                        }
                        
                      else
                      {
						
						  
						  // $result= preg_split("/('[^'\\\\]*(?:\\\\.[^'\\\\]*)*')/", $second[1],-1,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
						    // print_r($result);
						  // die();
                            $value_comma = str_replace(' ','',substr(trim($second[1]), 1, -1));
							

                            $a=array('","',"','",",'","',");
                            $db_col_val = str_replace($a, "|", trim($value_comma));
                            $db_col_val = substr(trim($db_col_val), 1, -1);
						
							
                          //  $db_colum_val = str_replace("'", "", $db_col_val);
							$db_colum_val=getRealescape($db_col_val);

                            $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col','$operation','','$db_colum_val','$module','$comments','$logge_date')";
                            
                            $this->insert($str);
                      }
                     
                    }
                    /*  SPLITING FOR NORMAL INSERT QUERY   */
                    
                    else {
                             
          /*     FOR "insert into replica (select `brand_id`,`category_id`,`brand_name`,`status`,`adminid` from `cntl_brand`)" QUERY TYPE      */
          
                $sql_qry = substr(trim($col[1]), 1, -1);
                
                if (strpos($sql_qry,')') !== false)
                {
                    $split_2_col = explode(")", $sql_qry);
                    $get_val_by_selectqry = str_replace ('(','',$split_2_col[1]);
                    $sql_select_qry=$get_val_by_selectqry;
                    
                    $db_insert_col = str_replace(",", "|", $split_2_col[0]);
                    $db_col = $db_insert_col;
                }
                else
                {
                     //COLUMNS OF SELECT QUERY
                     /* $qry_cut_select = str_replace('select', '', $sql_qry);
                      $split_by_from = explode("from", $qry_cut_select);
                      $sel_col=$split_by_from[0];

                      $result = str_replace("`", "", $sel_col);
                      $db_col = str_replace(",", "|", $result);*/
                    $db_col=$ass_col;
                    $sql_select_qry=$sql_qry;
                }
     
         // echo $sql_select_qry;
          $res_val = $this->get_rsltset($sql_select_qry);
         // echo "<pre>"; print_r($res_val);
       /*      INSERTED VALUE FROM THAT SELECT SUBQUERY   */
           if(count($res_val)>0)
           {
               
               for($v=0;$v<count($res_val);$v++)
               {
                    $val_arr=array();
                    $cnt_val = count($res_val[$v]);
                    
                    for($c=0;$c<$cnt_val;$c++)
                    {
                         if(!empty($res_val[$v][$c]))
                            $val_arr[] = $res_val[$v][$c];
                         else
                            $val_arr[] ="NULL";
                       
                    }
                   // echo "<pre>"; print_r($val_arr);
                   
                   $db_col_new_value = implode("|", $val_arr);
				   $db_colum_val=getRealescape($db_col_new_value);
				   
                 //  echo $db_col_new_value."<br>";
                   $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col','$operation','','$db_col_new_value','$module','$comments','$logge_date')";
                   
                   $this->insert($str);
                   
               }
           }
           /*     FOR "insert into replica (select `brand_id`,`category_id`,`brand_name`,`status`,`adminid` from `cntl_brand`)" QUERY TYPE      */
                    
                    
                    }
               
                    break;
                case "update";
               
        // $query="update cntl_brand set status=1,brand_name='ee,ddd' where status=2 and admin_id='4'";
        // $query="UPDATE cntl_brand SET status = (SELECT concat_ws('-',IsActive,CountryName) FROM m_country WHERE CountryId=2),email='asas,@dfdff.com',brand_name=(select CountryName from m_country where CountryId=2) WHERE brand_id=3";
      //   $query="UPDATE cntl_brand b, m_country c SET b.brand_id = c.CountryId,b.brand_name=c.CountryName WHERE b.brand_id = c.countryId";
        //UPDATE wp_options SET option_value = replace(option_value, 'http://www.oldurl', 'http://www.newurl') WHERE option_name = 'home' OR option_name = 'siteurl';
        //update tableA a left join tableB b on a.name_a = b.name_b set validation_check = if(start_dts > end_dts, 'VALID', '')            
        //UPDATE Reservations r JOIN Train t ON (r.Train = t.TrainID) SET t.Capacity = t.Capacity + r.NoSeats WHERE r.ReservationID = ?;            
    //UPDATE T1, T2, [INNER JOIN | LEFT JOIN] T1 ON T1.C1 = T2. C1 SET T1.C2 = T2.C2, T2.C3 = expr WHERE condition             
    //UPDATE my_table SET field = CASE WHEN id IN (/* true ids */) THEN TRUE WHEN id IN (/* false ids */) THEN FALSE END WHERE id in (true ids + false_ids)
    //UPDATE my_table SET field = CASE WHEN id IN (/* true ids */) THEN TRUE WHEN id IN (/* false ids */) THEN FALSE ELSE field=field  END Without the ELSE, I assume the evaluation chain stops at the last WHEN and executes that update. Also, you are not limiting the rows that you are trying to update; if you don't do the ELSE you should at least tell the update to only update the rows you want and not all (as you are doing). Loot at the WHERE clause below:               
   //  echo $table."----".$query; die();
         $op_qry = strtolower($query);
       /*  if($table=="u_doctorspecialities")
         echo "update".$query; die();
         */
                    $first = explode("set",$op_qry,2);
                    //echo $first[1]."<br>";
					
						
                    
                   // echo "<pre>"; print_r($rrr);
                      preg_match_all("#\(((?>[^\(\)]+)|(?R))*\)#x",$first[1],$subqry, PREG_PATTERN_ORDER); 
					   
					   
                  
                      if ((strpos($first[1],'(') <= 0 || substr_count($first[1], "select") >1 )&&!empty($subqry[1][0]))
                      {
						  
                          $loop_cnt=substr_count($first[1], "select");
                        
                          if(substr_count($first[1], "select")>1)
                          {
							  
                                //echo $first[1]."<br>";
                                //  preg_match("/\((.*)\)/", $first[1],$matches);       //get string with in closed brackets
                                preg_match_all("#\(((?>[^\(\)]+)|(?R))*\)#x",$first[1],$sub_qry, PREG_PATTERN_ORDER);
                                $arr_val_add=array();
                                $which_replace=array();
                                foreach($sub_qry[0] as $qry)
                                {
                                    $sql = substr($qry,1,-1);
                                    $res_val = $this->get_a_line($sql);
                                    $arr_val_add[] = "'".$res_val[0]."'";
                                    $which_replace[]=$qry;
                                    
                                }
                                $new_val_to_update = str_replace("'","",implode("|", $arr_val_add));
                                
                                $newval_update_query = str_replace($which_replace, $arr_val_add,$op_qry);
                                $first = explode("set",$newval_update_query);
                                $tables = str_replace("update", "", $first[0]);
                                
                                $sec_split = explode("where", $first[1]);
                                $col_val=$sec_split[0];
                                
                                $condition = strstr($op_qry, "where");
                                
                                $result = explode(",",$col_val);
                               
                                $rr=array();
                          $cnt=count($result);
                        for($s=0;$s<$cnt;$s++)
                        {

                          $occur=substr_count($result[$s], "'");

                          if($occur!=2&&$occur!=0) {

                                $app=$result[$s].",".$result[$s+1];
                                unset($result[$s+1]);
                            }
                            else{
                                 $app=$result[$s];
                            }

                           $sp = explode("=",$app);
                         
                           if(!empty($sp[1]))
                           $rr[trim($sp[0])]=  str_replace("'", "", $sp[1]);
                           
                        }
                       
                        $key_col = array_keys($rr);         // fields to be updated

                        $value_col = array_values($rr);     // new values to be updated in fields
                        
                        
                        $w_condition=strstr($newval_update_query, "where");
                        
                          //strspn($val_arr, $a);
                        $get_id=rtrim(ltrim($w_condition));
                         $select_col = implode(",",$key_col);
                     
                        //echo "select $select_col from $table where $get_id"; exit;
                        $res_old = $this->get_rsltset("select $select_col from $table $get_id");
                        $db_column_val_update = implode("|", $value_col);
                
                
                 // echo "<pre>"; print_r($res_old); exit;
                    $db_column=implode("|", $key_col);
                //   echo $db_column_val_update."---".$db_column;
           if(count($res_old)>0)
           {
               for($v=0;$v<count($res_old);$v++)
               {
                    $val_arr=array();
                    $cnt_val = count($res_old[$v]);
                    
                    for($c=0;$c<$cnt_val;$c++)
                    {
                        if(!empty($res_old[$v][$c]))
                        $val_arr[] = $res_old[$v][$c];
                    }
                    
                     if(strpos($tables,",")!==false)
                        $db_column_new=$db_column_val_update[$v];
                    else
                        $db_column_new=$db_column_val_update;
                   $db_col_old_value = implode("|", $val_arr);
				   $db_col_old_value=getRealescape($db_col_old_value);
				   $db_column_new=getRealescape($db_column_new);
				   
                 //  echo $db_col_old_value."<br>";
                   $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_column','$operation','$db_col_old_value','$db_column_new','$module','$comments','$logge_date')";
                   
                   $this->insert($str);
                
               }
              
           }
                        
                            
                          }
                          
                      }
                      else
                      {
                         
						  
						
                          $tables = str_replace("update", "", $first[0]);
						  
						
                          $sec_split = explode("where", $first[1]);
                          $col_val=$sec_split[0];
                          
						
						
                          $condition = strstr($op_qry, "where");
						  
						  
                         
                     //     $result = explode(",",$col_val);
						  
						//   preg_split("/('[^'\\\\]*'|\"[^\"]*\")/U", $col_val, null, PREG_SPLIT_DELIM_CAPTURE);
						$result= preg_split("/('[^'\\\\]*(?:\\\\.[^'\\\\]*)*')/", $col_val,-1,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
                 
                          $rr=array();
						 
                         $cnt=count($result);
                        for($s=0,$g=0,$y=0;$s<$cnt;$s++)
                        {
                       //   $occur=substr_count($result[$s], "'");
							
                       /*   if($occur!=2&&$occur!=0) {

                                $app=$result[$s].",".$result[$s+1];
                                unset($result[$s+1]);
                            }
                            else{
                              echo   $app=$result[$s];
                            }
						*/
							if($s%2)
							{
								//echo $result[$s];
								$key = trim($result[$s]);
								$key=trim($key,"'");
								$value_col[$y++]=$key;
								
							}
							else
							{
								  if(!empty($result[$s]) && trim($result[$s])!=''){
								    $key=str_replace(",","",$result[$s]);
									$key=trim(str_replace("=","",$key));
									$key_col[$g++]=$key;
								  }
								  else
								  {
									  break;
								  }
							  
							}		
						}	
									
                  
                     
                    /*     If update using joining multiple tables    */
					
				
					
                    if(strpos($tables,",")!==false)
                    {
                        /*    get old values before update    */
                       
					
                        $old_col = implode(",", $key_col);
                        $old_qry="select $old_col from $tables $condition";
					   
                        $res_old = $this->get_rsltset($old_qry);
                        
                        /*    get new values after update    */
                        $new_col = implode(",", $value_col);
                        
                        $new_qry="select $new_col from $tables $condition";
                        $new_val_set = $this->get_rsltset($new_qry);
                        $n_arr=array();
                        $res=array();
                        $ncnt=count($new_val_set);
                        for($n=0;$n<$ncnt;$n++)
                        {
                            $val_arr=array();
                            $cnt_val = count($new_val_set[$n]);
                    
                            for($d=0;$d<$cnt_val;$d++)
                            {
                                  
                                    if(!empty($new_val_set[$n][$d]))
                                    $val_arr[] = $new_val_set[$n][$d];
                            }
                            $n_arr[] = implode("|", $val_arr);
                        }
					
                       
                        $db_column_val_update =  $n_arr;
                       // echo "<pre>"; print_r($db_column_val_update); exit;
                        /*  If update using joining multiple tables    */
                    }
                    else
                    {
                        
                        //strspn($val_arr, $a);
                        $get_id=rtrim(ltrim($condition));
                        $select_col = implode(",",$key_col);
					
                        //echo "select $select_col from $table $get_id"; exit;
                        $res_old = $this->get_rsltset("select $select_col from $table $get_id");
                        $db_column_val_update = implode("|", $value_col);
                    }
                  
				   
                //  echo "<pre>"; print_r($res_old); exit;
                    $db_column=implode("|", $key_col);
                //   echo $db_column_val_update."---".$db_column;
                      $val_arr=array();
				 
					  
           if(count($res_old)>0)
           {
		
			   
               for($v=0;$v<count($res_old);$v++)
               {
                   
                    $cnt_val = count($res_old[$v]);
                   
                    for($c=0;$c<$cnt_val;$c++)
                    {
                        if(!empty($res_old[$v][$c])||$res_old[$v][$c]==0)
                        {
                            $val_arr[] = $res_old[$v][$c];
                        }
                    }
					
		                     
                     if(strpos($tables,",")!==false)
                        $db_column_new=$db_column_val_update[$v];
                    else
                        $db_column_new=$db_column_val_update;
					
                   
                 
                    $db_col_old_value = implode("|", array_filter($val_arr,'strlen'));
					
					  $db_col_old_value=getRealescape($db_col_old_value);
					  $db_column_new=getRealescape($db_column_new);
					
                 
                     $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_column','$operation','$db_col_old_value','$db_column_new','$module','$comments','$logge_date')";
                
                   $this->insert($str);
                
               }
              
           }
                      }
         
                     break;
                case "delete":
         
            // $query="update cntl_brand set status=1 where status=2";
          // $query="delete from cntl_brand where status=2";
         // $query="delete t2 from t2 inner join t1 on a = d";
    // dint wrked  //$query="update qh_users set IsActive = '2' where UserId = (select AdminUserId from un_practices where PracticeId =  '$id')";       
       //   $query="DELETE cb FROM cntl_brand b INNER JOIN m_country c on c.countryId=b.brand_id WHERE b.IsActive=1";
               // $query="update u_doctorspecialities set IsActive = 2 where DoctorId = 1";
                    $op_qry=strtolower($query);
                 //   $table="u_doctorspecialities";
             //  echo $op_qry; die();
                     if (strpos($op_qry,'update') !== false)
                     {
                         /* for status update delete operations */
                        $first = explode("set",$op_qry);
                      
                         if (strpos($first[1],'select') !== false)
                         {
                            preg_match_all("#\(((?>[^\(\)]+)|(?R))*\)#x",$first[1],$sub_qry_dlt, PREG_PATTERN_ORDER);
                            
                            $getid = $this->get_a_line($sub_qry_dlt[1][0]);
                            
                            $splited_str = str_replace($sub_qry_dlt[0][0], $getid[0], $first[1]);
                         }
                         else
                         {
                             $splited_str = $first[1];
                         }
                         
                        $sec_split = explode("where",$splited_str);
                        
                        
                        $col_val=$sec_split[0];
//echo "<pre>"; print_r($sec_split); exit;
                        $cond_col=$sec_split[1];
                       
                        $check_col = explode(",", $col_val);

                      //  echo $get_old_col = $check_col[0];

                        $result = explode(",",$col_val);

                        $rr=array();
                        $cnt=count($result);
                        for($s=0;$s<$cnt;$s++)
                        {

                          $occur=substr_count($result[$s], "'");

                          if($occur!=2&&$occur!=0) {

                                $app=$result[$s].",".$result[$s+1];
                                unset($result[$s+1]);
                            }
                            else{
                                 $app=$result[$s];
                            }

                           $sp = explode("=",$app);
                           if(!empty($sp[1]))
                           $rr[trim($sp[0])]=  str_replace ("'", "", $sp[1]);

                        }
                        $key_col = array_keys($rr);         // fields to be updated

                        $value_col = array_values($rr);     // new values to be updated in fields

                       
                        $get_id=rtrim(ltrim($cond_col));   // full where condition of update query
                        
                        $select_col = implode(",",$key_col);

                    // echo "select $select_col from $table where $get_id"; exit;
                        $res_old = $this->get_rsltset("select $select_col from $table where $get_id");

                       $db_column_val_update = implode("|", $value_col);
                       $db_column=implode("|", $key_col);
              //   echo $db_column_val_update."---".$db_column;
                        if(count($res_old)>0)
                        {

                            for($v=0;$v<count($res_old);$v++)
                            {
                                 $val_arr=array();
                                 $cnt_val = count($res_old[$v]);

                                 for($c=0;$c<$cnt_val;$c++)
                                 {
                                     if(!empty($res_old[$v][$c]))
                                     $val_arr[] = $res_old[$v][$c];
                                 }
                               //  echo "<pre>"; print_r($val_arr);
               
                                $db_col_old_value = implode("|", $val_arr);
								
					  $db_col_old_value=getRealescape($db_col_old_value);
					  $db_column_val_update=getRealescape($db_column_val_update);
								
                             //  echo $db_col_old_value."<br>"; exit;
                                $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_column','$operation','$db_col_old_value','$db_column_val_update','$module','$comments','$logge_date')";

                                $this->insert($str);
                            }
                        }
                     }
                     else if(strpos($op_qry,'truncate') !== false)
                     {
                         /*      Truncate table       */
                         
                         $qry="select * from $table";
                          $res_old = $this->get_rsltset($qry);
                      //  echo "<pre>"; print_r($res_old);
                       
                            if(count($res_old)>0)
                            {
                                
                                for($v=0;$v<count($res_old);$v++)
                                {
                                    $val_arr=array();
                                    $cnt_val = count($res_old[$v])/2;
                                 
                                    for($c=0;$c<$cnt_val;$c++)
                                    {
                                        if(!empty($res_old[$v][$c]))
                                            $val_arr[] = $res_old[$v][$c];
                                        else
                                            $val_arr[] ="NULL";
                                    }
                                    // echo "<pre>"; print_r($val_arr);
                                    
                                    $db_col_old_value = implode("|", $val_arr);
									
									 $db_col_old_value=getRealescape($db_col_old_value);
					
                                   // echo $db_col_old_value."<br>";
                                    $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$ass_col','$operation','$db_col_old_value','','$module','$comments','$logge_date')";
                                   // echo $str; exit;
                                    
                                    $this->insert($str);
                                    
                                }
                            }
                     }
                     else  if (strpos($op_qry,'join') !== false)
                     {
                     //   echo $op_qry."<br>";
                        $select_qry = str_replace('from','',strstr($op_qry, "from"));
                        $arr = explode("where",$select_qry);
                        
                        $condition = strstr($op_qry, "where");
                        $sql_dl_qry = "select * from $arr[0] $condition";
                        
                        $res_old = $this->get_rsltset($sql_dl_qry);
                        
                        
                         if(count($res_old)>0)
                            {
                                
                                for($v=0;$v<count($res_old);$v++)
                                {
                                    $val_arr=array();
                                    $cnt_val = count($res_old[$v])/2;
                                 
                                    for($c=0;$c<$cnt_val;$c++)
                                    {
                                        if(!empty($res_old[$v][$c]))
                                            $val_arr[] = $res_old[$v][$c];
                                        else
                                            $val_arr[] ="NULL";
                                    }
                                    // echo "<pre>"; print_r($val_arr);
                                    
                                    $db_col_old_value = implode("|", $val_arr);
									 $db_col_old_value=getRealescape($db_col_old_value);
					
                                   // echo $db_col_old_value."<br>";
                                    $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$ass_col','$operation','$db_col_old_value','','$module','$comments','$logge_date')";
                                   // echo $str; exit;
                                    
                                    $this->insert($str);

                                }
                            }
                        
                        
                     }
                     else
                     {
                       
                        $split_by_where = explode("where", $op_qry);
                        $condition = $split_by_where[1];
                        $qry="select * from $table where $condition";
                        
                        $res_old = $this->get_rsltset($qry);
                      //  echo "<pre>"; print_r($res_old);
                       
                            if(count($res_old)>0)
                            {
                                
                                for($v=0;$v<count($res_old);$v++)
                                {
                                    $val_arr=array();
                                    $cnt_val = count($res_old[$v])/2;
                                 
                                    for($c=0;$c<$cnt_val;$c++)
                                    {
                                        if(!empty($res_old[$v][$c]))
                                            $val_arr[] = $res_old[$v][$c];
                                        else
                                            $val_arr[] ="NULL";
                                    }
                                    // echo "<pre>"; print_r($val_arr);
                                    
                                    $db_col_old_value = implode("|", $val_arr);
									 $db_col_old_value=getRealescape($db_col_old_value);
					 
                                   // echo $db_col_old_value."<br>";
                                    $str="insert into tri_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$ass_col','$operation','$db_col_old_value','','$module','$comments','$logge_date')";
                                   // echo $str; exit;
                                    
                                    $this->insert($str);

                                }
                            }
                     }
               
                  break;
         
            }
            //throw new Exception("Error occured in operations!"); 
         } catch (Exception $ex) {
                    // $ex->getMessage();
           }
            return TRUE;
            //echo $db_colum_val; exit;
           
        }
        
	//=====================================================================================

	}
