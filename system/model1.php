<?php
class Model {
	private $connection;

	public function __construct()
	{
		global $config;	   
     	
		$this->connection = mysql_connect($config['db_host'], $config['db_username'], $config['db_password']) or die('MySQL Error: '. mysql_error());
		mysql_select_db($config['db_name'], $this->connection);
		
	}

	public function escapeString($string)
	{
		return mysql_real_escape_string($string);
	}

	public function escapeArray($array)
	{
	    array_walk_recursive($array, create_function('&$v', '$v = mysql_real_escape_string($v);'));
		return $array;
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
	
	public function query($qry)
	{
		$result = mysql_query($qry) or die('MySQL Error: '. mysql_error());
		$resultObjects = array();

		while($row = mysql_fetch_object($result)) $resultObjects[] = $row;

		return $resultObjects;
	}
	
	
	
	public function get_a_line($qry)
	{
 
		$result = mysql_query($qry) or die('MySQL Error: '. mysql_error());
		//$resultObjects = array();

		$line = mysql_fetch_array ($result);

     		mysql_free_result ($result);

     		return $line;
	
	}
	
		
	public function get_rsltset($qry)
	{
		$result = mysql_query($qry) or die('MySQL Error: '. mysql_error());
		//$resultObjects = array();
$rsltset=array();
		   if (! ($result))//$mysql is for the query
	    		{
    	            throw new Exception("err");
      				$men = mysql_errno();
                    $mem = mysql_error();
                        
	      			echo ("<h4>$mysql  $men $mem</h4>");
					exit;
	    		}
				else
	    		{
					$xx = 0 ;
      				while ( $row = mysql_fetch_array ($result) ) 
	      			{
	        			$rsltset[$xx] = $row;
						$xx++;
	      			}

      				mysql_free_result($result);
      				return $rsltset;  
				}
	
	}
	
	

	public function execute($qry)
	{
		$exec = mysql_query($qry) or die('MySQL Error: '. mysql_error());
		return $exec;
	}
	
	public function insert($mysql) 

  	{
		try{
      		if (! (mysql_query ("$mysql")))//$mysql is for the query
        	{
				throw new Exception("err");
          		$men = mysql_errno();
          		$mem = mysql_error();
				exit;
        	}
                return 1;
		}
		catch (Exception $ex){};
	}	
	
	public function LastInsertId()
	{
		return mysql_insert_id();
	}
	
	   function insert_log($operation,$table,$id="",$comments="",$module="",$query="")
        {
           
       
           try{
            $user_name = isset($_SESSION["UName"]);
            $user_id = isset($_SESSION["UserId"]);
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
                  $d='';
				  $ass_col='';
                  $cntt=count($col_res);
                   foreach($col_res as $col)
                   {
					   $d=0;
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
                                        unset($val_array[$v+1]);
                                    }
                                    else{
                                         $app=$val_array[$v];
                                    }
                                    
                                if(!empty($app))
                                  {
                                    $arr_app[]=$app;
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
                                        unset($result[$u+1]);
                                    }
                                    else{
                                         $app=$result[$u];
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
                                    $str="insert into ca_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col_up','$operation','$old_db_val','$db_col_new_val','$module','$comments','$logge_date')";
                                  
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
                        
                        $a=array('","',"','",",'","',");
                        $db_col_val = str_replace($a, "|", trim($value_comma));
                       
                        $db_colum_val = str_replace("'", "", $db_col_val);
                       
                        $str="insert into ca_userlog(user_id,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col','$operation','','$db_colum_val','$module','$comments','$logge_date')";
                        
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
                                
                                 $str="insert into ca_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col','$operation','','$db_col_val_mul','$module','$comments','$logge_date')";
                                
                                 $this->insert($str);
                                
                                
                           }
                           
                            //echo "<pre>"; print_r($fields);
                        }
                        
                      else
                      {
                            $value_comma = str_replace(' ','',substr(trim($second[1]), 1, -1));

                            $a=array('","',"','",",'","',");
                            $db_col_val = str_replace($a, "|", trim($value_comma));
                            $db_col_val = substr(trim($db_col_val), 1, -1);
                            $db_colum_val = str_replace("'", "", $db_col_val);

                            $str="insert into ca_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col','$operation','','$db_colum_val','$module','$comments','$logge_date')";
                            
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
                 //  echo $db_col_new_value."<br>";
                   $str="insert into m_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_col','$operation','','$db_col_new_value','$module','$comments','$logge_date')";
                   
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
                    $first = explode("set",$op_qry);
                    //echo $first[1]."<br>";
                    
                   // echo "<pre>"; print_r($rrr);
                       preg_match_all("#\(((?>[^\(\)]+)|(?R))*\)#x",$first[1],$subqry, PREG_PATTERN_ORDER);
                  
                      if ((strpos($first[1],'(') !== false || strpos($first[1],'select') !== false)&&!empty($subqry[1][0]))
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
                        $get_id=$w_condition;
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
                 //  echo $db_col_old_value."<br>";
                   $str="insert into m_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_column','$operation','$db_col_old_value','$db_column_new','$module','$comments','$logge_date')";
                   
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
                         
                          $result = explode(",",$col_val);
                    //echo "<pre>"; print_r($result); exit;
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
                           {
                               $val_ent = html_entity_decode($sp[1]);
                               $rr[trim($sp[0])]=  str_replace ("'", "", $val_ent);
                           }
                          // &#44;
                        }
                        $key_col = array_keys($rr);         // fields to be updated

                        $value_col = array_values($rr);     // new values to be updated in fields
               //    echo "<pre>"; print_r($value_col); exit;
                     
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
                        $get_id=$condition;
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
                        if(isset($res_old[$v][$c]) && (!empty($res_old[$v][$c])||$res_old[$v][$c]==0))
                        {
                            $val_arr[] = $res_old[$v][$c];
                        }
                    }
                     
                     if(strpos($tables,",")!==false)
                        $db_column_new=$db_column_val_update[$v];
                    else
                        $db_column_new=$db_column_val_update;
                    
                 
                    $db_col_old_value = implode("|", array_filter($val_arr,'strlen'));
                 
                    $str="insert into m_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_column','$operation','$db_col_old_value','$db_column_new','$module','$comments','$logge_date')";
                  
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

                       
                        $get_id=$cond_col;   // full where condition of update query
                        
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
                             //  echo $db_col_old_value."<br>"; exit;
                                $str="insert into m_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$db_column','$operation','$db_col_old_value','$db_column_val_update','$module','$comments','$logge_date')";

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
                                   // echo $db_col_old_value."<br>";
                                    $str="insert into m_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$ass_col','$operation','$db_col_old_value','','$module','$comments','$logge_date')";
                                   // echo $str; exit;
                                    
                                    $this->insert($str);
                                    
                                }
                            }
                     }
                     else  if (strpos($op_qry,'join') !== false)
                     {
                        echo $op_qry."<br>";
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
                                   // echo $db_col_old_value."<br>";
                                    $str="insert into m_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$ass_col','$operation','$db_col_old_value','','$module','$comments','$logge_date')";
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
                                   // echo $db_col_old_value."<br>";
                                    $str="insert into m_userlog(UserId,Username,Type,Id,ColName,Operation,OldValue,NewValue,Module,Comment,LoggedDate)values('$user_id','$user_name','$table','$id','$ass_col','$operation','$db_col_old_value','','$module','$comments','$logge_date')";
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
}
?>