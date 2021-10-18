<?php

error_reporting(0);

//Announcement

 function getAnnouncement($db){ 	
     $strQry =" select * from ".tbl_announce."  where isactive=1 order by announcedate desc limit 0,15";
	 
	 $resulst=$db->get_rsltset($strQry);	
	 	
	  
 	 return $resulst;
 } 

//News Details
  function getNewsDetails($db,$projectstatus){ 	
     $strQry =" select * from ".tbl_news."  where isactive=1 and tittlename_url='".$projectstatus."'";
	 
	 $resulst=$db->get_a_line($strQry);	
	 	
	  
 	 return $resulst;
 } 
 
 //News Images Details
  function getNewsImagesDetails($db,$projectstatus){ 	
     $strQry =" select i.* from ".tbl_news." n
LEFT JOIN ".tbl_newsimg." i
ON n.newsid = i.newsid  where n.isactive=1 and i.isactive=1 and n.tittlename_url='".$projectstatus."' order by i.imgorder asc";

	
	 $resulst=$db->get_rsltset($strQry);	
	 	
	  
 	 return $resulst;
 } 

//PressRelease

function getPressReleaseList($db,$LIMIT,$filter) {
	
   if($LIMIT != ''){ $LIMITS = " LIMIT 0,".$LIMIT."";}	 
   
	  $limtstr="";
	  if($filter['action'] == 'pagination'){
		  if(isset($filter['page']))
		  $LIMITS=" limit ".(((int)$filter['page']-1)*$LIMIT).", $LIMIT ";
	  }
	 // echo $filter['prjt_sts'];
	
	$strQry1 ="SELECT * FROM ".tbl_press." where isactive = 1 order by pressdate Desc";
    $rsltMenu1=$db->get_rsltset($strQry1);
	  ########## Get Overall count ###########
	  
	  

   
	     $strQry ="SELECT * FROM ".tbl_press." where isactive = 1 order by pressdate Desc ".$LIMITS."";



	$rsltMenu=$db->get_rsltset($strQry);	
				
		 
		  
		if($filter['action'] == 'pagination' || $filter['action'] == 'filter'){
		  if(count($rsltMenu)>0){
			  
			  $strHtml ='';	
			  $dots = '';
			  foreach($rsltMenu as $rst){ 
			  //$testimoniallist['categoryslug']
			 
				
			 	 $new = '';
				 
				  $ImgsQry ="SELECT * FROM ".tbl_pressimg." where isactive = 1 and pressid=".$rst['pressid']." order by pressimgorder asc";
				  $rsltimags=$db->get_rsltset($ImgsQry);	
				 
				$strHtml .=' <div class="has-animate pressRelease-list col-md-4 col-sm-4 col-xs-12">
										<a class="fancybox-media vid-link" data-fancybox-group="button'.$rst['pressid'].'" href="'.BASE_URL.'uploads/pressrelease/'.$rst['pressimage'].'"><div class="pressRelease-date-container">
											<span class="date">'.date('d-F-Y', strtotime($rst['pressdate'])).'</span>
										</div>	
										<p class="thumb-img"><img src="'.BASE_URL.'uploads/pressrelease/'.$rst['pressimage'].'" alt="" /></p>
										<p class="pressRelease-title">'.$rst['presstitle'].'</p>
										<span class="source-title">'.$rst['presssource'].'</span></a>';
										  if(count($rsltimags)>0){
											    foreach($rsltimags as $imglist){ 
													$strHtml .=' <a class="fancybox-media vid-link" data-fancybox-group="button'.$rst['pressid'].'" href="'.BASE_URL.'uploads/pressrelease/'.$imglist['pressimgname'].'" title="'.$imglist['pressimgtitle'].'"></a>';
												}
										  }
										
										
									$strHtml .='</div>';
				 
				 
		
			
						
				  }	
				  		
						 echo json_encode(array("oppcnt"=>count($rsltMenu),"maincount" => count($rsltMenu1),"product_cont"=>$strHtml));				
					
			  }
			  else
			  {
				  echo json_encode(array("oppcnt"=>count($rsltMenu),"product_cont"=>'<div class="col-md-12 col-sm-12 col-xs-12 nopad common-msg"><div class="common-msginner"> No Objects Found</div></div>'));	
			  }
		}
		else
		{
			return $rsltMenu;	
		}
  }
 
 
 //TV Commercials

function getTVCommercialsList($db,$LIMIT,$filter) {	
 
 
  

   if($LIMIT != ''){ $LIMITS = " LIMIT 0,".$LIMIT."";}	 
   
	  $limtstr="";
	  if($filter['action'] == 'pagination'){
		  if(isset($filter['page']))
		  $LIMITS=" limit ".(((int)$filter['page']-1)*$LIMIT).", $LIMIT ";
	  }
	 // echo $filter['prjt_sts'];
		 
	  
	

		$strQry1 ="SELECT * FROM ".tbl_commercials." where isactive = 1 order by date Desc";


		
		
	$rsltMenu1=$db->get_rsltset($strQry1);
	
	
	
	
	  ########## Get Overall count ###########
	  
	  

   
	     $strQry ="SELECT * FROM ".tbl_commercials." where isactive = 1 order by date Desc ".$LIMITS."";



	$rsltMenu=$db->get_rsltset($strQry);	
				
		 
		  
		if($filter['action'] == 'pagination' || $filter['action'] == 'filter'){
		  if(count($rsltMenu)>0){
			  
			  $strHtml ='';	
			  $dots = '';
			  foreach($rsltMenu as $rst){ 
			  //$testimoniallist['categoryslug']
			 
				
			 	 $new = '';
				 
				 $url = $rst['youtube_url'];
parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );

				 	$strHtml .='<div class="has-animate pressRelease-list col-md-4 col-sm-4 col-xs-12">
										<a class="fancybox-media vid-link" data-fancybox-group="button'.$rst['commid'].'" href="'.$rst['youtube_url'].'"><div class="pressRelease-date-container">
											<span class="date">'.date('d-F-Y', strtotime($rst['date'])).'</span>
										</div>	
										<p class="thumb-img"><img src="http://img.youtube.com/vi/'.$my_array_of_vars['v'].'/0.jpg" alt="" /></p>
										<p class="pressRelease-title">'.$rst['fields_name'].'</p>
										<span class="source-title"> </span></a>
									</div>';
									
				
						
				  }	
				  		
						 echo json_encode(array("oppcnt"=>count($rsltMenu),"maincount" => count($rsltMenu1),"product_cont"=>$strHtml));				
					
			  }
			  else
			  {
				  echo json_encode(array("oppcnt"=>count($rsltMenu),"product_cont"=>'<div class="col-md-12 col-sm-12 col-xs-12 nopad common-msg"><div class="common-msginner"> No Objects Found</div></div>'));	
			  }
		}
		else
		{
			return $rsltMenu;	
		}
  }
  
  
   //News

function getNewsList($db,$LIMIT,$filter) {	
 
 
  

   if($LIMIT != ''){ $LIMITS = " LIMIT 0,".$LIMIT."";}	 
   
	  $limtstr="";
	  if($filter['action'] == 'pagination'){
		  if(isset($filter['page']))
		  $LIMITS=" limit ".(((int)$filter['page']-1)*$LIMIT).", $LIMIT ";
	  }
	  
	

		$strQry1 ="SELECT * FROM ".tbl_news." where isactive = 1 order by news_date Desc";
		$rsltMenu1=$db->get_rsltset($strQry1);
	
	
	
	
	  ########## Get Overall count ###########
	  
	  

   
	     $strQry ="SELECT * FROM ".tbl_news." where isactive = 1 order by news_date Desc ".$LIMITS."";



	$rsltMenu=$db->get_rsltset($strQry);	
				
		 
		  
		if($filter['action'] == 'pagination' || $filter['action'] == 'filter'){
		  if(count($rsltMenu)>0){
			  
			  $strHtml ='';	
			  $dots = '';
			  foreach($rsltMenu as $rst){ 
		
				
			 	 $new = '';
				
				 $strHtml .='<div class="news-content has-animate row">
									<div class="news-date-badge col-md-3 col-sm-3 col-xs-3">
										<div class="news-date-container">
											<span class="date">'.date('d', strtotime($rst['news_date'])).'</span>
											<span class="year">'.date('F-Y', strtotime($rst['news_date'])).'</span>
										</div>	
									</div>
									<div class="news-list col-md-9 col-sm-9 col-xs-9">
										<p class="news-title"><a href="'.BASE_URL.'news_and_events/dv/'.$rst['tittlename_url'].'">'.$rst['news_title'].'
										</a></p>
									</div>
								</div>';
						
				  }	
				  		
						 echo json_encode(array("oppcnt"=>count($rsltMenu),"maincount" => count($rsltMenu1),"product_cont"=>$strHtml));				
					
			  }
			  else
			  {
				  echo json_encode(array("oppcnt"=>count($rsltMenu),"product_cont"=>'<div class="col-md-12 col-sm-12 col-xs-12 nopad common-msg"><div class="common-msginner"> No Objects Found</div></div>'));	
			  }
		}
		else
		{
			return $rsltMenu;	
		}
  }
  
  
     //Centers

function getCentersList($db,$LIMIT,$filter) {
	
/*	categ_select
country_select*/

$state='';
$city='';

//$state_select = is_int($filter['state_select']);
	if ($filter['state_select']!="NaN" && $filter['state_select']!='') {
		$state=" and cd.state='".$filter['state_select']."'";
	}
	
	//$city_select = is_int($filter['city_select']);
	if ($filter['city_select']!="NaN" && $filter['city_select']!='') {
		$city=" and cd.city='".$filter['city_select']."'";
	}

	
	
	if($LIMIT != ''){ $LIMITS = " LIMIT 0,".$LIMIT."";}	 
   
	  $limtstr="";
	  if($filter['action'] == 'pagination'){
		  if(isset($filter['page']))
		  $LIMITS=" limit ".(((int)$filter['page']-1)*$LIMIT).", $LIMIT ";
	  }
	  
	

		$strQry1 ="SELECT cd.*,c.name FROM ".tbl_centers." cd 
		  LEFT JOIN ".tbl_countries." c ON cd.city = c.countryID 
		 where cd.isactive = 1 and cd.ccid='".$filter['categ_select']."' and cd.contryid='".$filter['country_select']."' $state $city order by cd.custname asc";
		 
	
		$rsltMenu1=$db->get_rsltset($strQry1);
	
	
	
	  ########## Get Overall count ###########
	  
	  

   
	     $strQry ="SELECT cd.*,c.name FROM ".tbl_centers." cd 
		  LEFT JOIN ".tbl_countries." c ON cd.city = c.countryID 
		 where cd.isactive = 1 and cd.ccid='".$filter['categ_select']."' and cd.contryid='".$filter['country_select']."' $state $city order by cd.custname asc ".$LIMITS."";


	$rsltMenu=$db->get_rsltset($strQry);	
				
		 
		  
		if($filter['action'] == 'pagination' || $filter['action'] == 'filter'){
		  if(count($rsltMenu)>0){
			  
			  $strHtml ='';	
			  $dots = '';
			  foreach($rsltMenu as $rst){  
			 	 $new = '';
				 
				  $strHtml .='<div class="station-list_details">
										<div class="sation-list_address" data-head="Address"><address>
										   <span class="font-bold text-green title">'.$rst['custname'].'</span>
											'.$rst['address'].'
										</address></div>
										<div class="sation-list_city" data-head="City">
											<span class="city_name">'.$rst['name'].'</span>
										</div>
										<div class="sation-list_contact" data-head="Contact Details"><span>'.$rst['emailid'].'</span><span>
										'.$rst['contact'].'</span></div>										
									</div>';
				
			
						
				  }	
				  		
						 echo json_encode(array("oppcnt"=>count($rsltMenu),"maincount" => count($rsltMenu1),"product_cont"=>$strHtml));				
					
			  }
			  else
			  {
				  echo json_encode(array("oppcnt"=>count($rsltMenu),"product_cont"=>'<div class="col-md-12 col-sm-12 col-xs-12 nopad common-msg"><div class="common-msginner"> No Objects Found</div></div>'));	
			  }
		}
		else
		{
			return $rsltMenu;	
		}
	
	
}

//Category

function getCategory($db,$catid){ 	


$ids = join(', ', $catid);

 $strQry ="SELECT * FROM ".tbl_categorycenters." where isactive = 1 and ccid in ($ids) order by ccid asc ";
 

	 $resulst=$db->get_rsltset($strQry);		 
 	 return $resulst;
 } 
 
 
 function getState($db,$catid,$contry){ 	


$ids = join(', ', $catid);

 
 /*$strQry ="SELECT c.* FROM ".tbl_countries." c LEFT JOIN ".tbl_centers." cd
ON cd.contryid = c.countryID where cd.ccid in ($ids) and c.country_parent_id=$contry and c.level = 1 and cd.isactive = 1 order by  c.name asc ";*/


$strQry ="SELECT c.* FROM ".tbl_countries." c LEFT JOIN ".tbl_centers." cd
ON cd.state = c.countryID where cd.ccid in ($ids) and cd.contryid=$contry and c.level = 1 and cd.isactive = 1 group by c.countryID order by  c.name asc ";


	
	 $resulst=$db->get_rsltset($strQry);		 
 	 return $resulst;
 } 
 
 
 
  function getCity($db,$filter){ 	
  
  
  
$strQry ="SELECT c.* FROM ".tbl_countries." c LEFT JOIN ".tbl_centers." cd
ON cd.city = c.countryID where cd.ccid = '".$filter['categ_select']."' and cd.contryid='".$filter['country_select']."' and cd.state='".$filter['state_select']."' and c.country_parent_id='".$filter['state_select']."' and c.level = 2 and cd.isactive = 1 group by c.countryID order by  c.name asc ";


	
	 $resulst_list=$db->get_rsltset($strQry);	
	 
	 $strSelHtml =  "<option value=''>Select City</option>";
		
		if(!empty($resulst_list)) {
			foreach($resulst_list as $val) {	
				$strSelHtml=$strSelHtml."<option value=".$val['countryID']." >".$val['name']."</option>";
			}
		}	
		echo json_encode(array("rslt"=>$strSelHtml)); //status update success
		
 	// return $resulst;
 } 
 
   function getStatelist($db,$filter){ 	
  
  
  
$strQry ="SELECT c.* FROM ".tbl_countries." c LEFT JOIN ".tbl_centers." cd
ON cd.state = c.countryID where cd.ccid = '".$filter['categ_select']."' and cd.contryid='".$filter['country_select']."' and c.level = 1 and cd.isactive = 1 group by c.countryID order by  c.name asc ";




	
	 $resulst_list=$db->get_rsltset($strQry);	
	 
	 $strSelHtml =  "<option value=''>Select State</option>";
		
		if(!empty($resulst_list)) {
			foreach($resulst_list as $val) {	
				$strSelHtml=$strSelHtml."<option value=".$val['countryID']." >".$val['name']."</option>";
			}
		}	
		echo json_encode(array("rslt"=>$strSelHtml)); //status update success
		
 	// return $resulst;
 } 
  

//Current Opening

function getCurrentOpeningList($db,$LIMIT,$filter) {
	
   if($LIMIT != ''){ $LIMITS = " LIMIT 0,".$LIMIT."";}	 
   
	  $limtstr="";
	  if($filter['action'] == 'pagination'){
		  if(isset($filter['page']))
		  $LIMITS=" limit ".(((int)$filter['page']-1)*$LIMIT).", $LIMIT ";
	  }
	 // echo $filter['prjt_sts'];
	
	$strQry1 ="SELECT * FROM ".tbl_jobcareer." where isactive = 1 order by regdate Desc";
    $rsltMenu1=$db->get_rsltset($strQry1);
	  ########## Get Overall count ###########
	  
	  

   
	     $strQry ="SELECT * FROM ".tbl_jobcareer." where isactive = 1 order by regdate Desc ".$LIMITS."";



	$rsltMenu=$db->get_rsltset($strQry);	
				
		 
		  
		if($filter['action'] == 'pagination' || $filter['action'] == 'filter'){
		  if(count($rsltMenu)>0){
			  
			  $strHtml ='';	
			  $dots = '';
			  foreach($rsltMenu as $rst){ 
			  //$testimoniallist['categoryslug']
			 
				
			 	 $new = '';
				 
				  $strHtml .='<div class="openings-list_content">
									
                                    
                                    <div class="openings-list_brief"> 
										<div class="openings-list_postion" data-head="Position">
											<span class="font-regular postion_title">'.$rst['jobtitle'].'</span>
										</div>
										<div class="openings-list_location" data-head="Location">
											<span class="location_title">'.$rst['location'].'</span>
										</div>
										<div class="openings-list_action" data-id="'.$rst['jobid'].'">
											<span class="action_title" >Apply Now</span>
										</div>									
									</div>
									<div class="openings-details">
										<div class="openings-details_summary">
											'.$rst['description'].'
										</div>
										<div class="openings-details_candidate-profile">
											'.$rst['responsibility'].'										
										</div>
										<div class="openings-details_candidate-profile">
											'.$rst['qualification'].'										
										</div>									
									</div>									
								</div>';
				  
			
				 
				 
		
			
						
				  }	
				  		
						 echo json_encode(array("oppcnt"=>count($rsltMenu),"maincount" => count($rsltMenu1),"product_cont"=>$strHtml));				
					
			  }
			  else
			  {
				  echo json_encode(array("oppcnt"=>count($rsltMenu),"product_cont"=>'<div class="col-md-12 col-sm-12 col-xs-12 nopad common-msg"><div class="common-msginner"> No Objects Found</div></div>'));	
			  }
		}
		else
		{
			return $rsltMenu;	
		}
  }
 
 
 // Contact us mail
 
  function save_contact_enquiry_details_todb($db,$filter){ 
       if(($filter['name']!="")&&($filter['email']!="")&&($filter['phone']!="")){
 
$today = date("Y-m-d h:i:s");
    $strQry ="INSERT INTO ".tbl_contact_us." (`name`, `email`, `phone`,`subject`, `message`,`createddate`) VALUES ('".addslashes($filter['name'])."','".$filter['email']."','".addslashes($filter['phone'])."','".addslashes($filter['subject'])."','".addslashes($filter['message'])."','".$today."')";
	
	$rsltMenu=$db->insert($strQry);	
	if($rsltMenu==1){
		
		
		$subject = 'Dodla Dairy :: General Enquiry';

$message = '<table width="500"  border="0" cellpadding="3" cellspacing="0" bordercolor="#000" bgcolor="#ffffff" style="border: solid 1px #4e3101">
  <tr>
    <td><table width="500" height="" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td height="24" colspan="3" valign="top" style="background:#ed1c24 " ><font face="Arial, Helvetica, sans-serif" size="4" color="#FFFFFF"><strong>General Enquiry</strong></font></td>
      </tr>
	  
      <tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Name</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['name'].'</font>        </td>
      </tr>
	  
   
	  
      <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Email</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['email'].'</font></td>
      </tr>
      <tr>
        <td height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Phone</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['phone'].'</font></td>
      </tr>
	  
	   <tr>
        <td height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Phone</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['subject'].'</font></td>
      </tr>
	
      <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Message</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font></td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['message'].'</font></td>
      </tr>
        </table></td>
  </tr>
</table>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From:"'.FROMEMAIL.'"'. "\r\n";
$headers .= 'Bcc: "'.BCCEMAIL.'"' . "\r\n";


mail(TOEMAIL, $subject, $message, $headers);

		 echo json_encode(array("rslt"=>count($rsltMenu)));
		 
		 
		}
		else{
			echo json_encode(array("rslt"=>0));
			}
			
			}
		else{
			echo json_encode(array("rslt"=>0));
			}

   
     
 } 
 
 function getEproductcat($db){ 	
	 
     //$strQry =" select c.* from ".tbl_category." c  inner join ".tbl_product." p  on c.categoryID=p. categoryid and p.IsActive=1 where c.IsActive=1 and c.parentid=0 and c.cattype=1 group by c.categoryID order by c.sortorder "; 
	 $strQry =" select c.* from ".tbl_category." c  inner join ".tbl_product." p  on c.categoryID=p. categoryid and p.IsActive=1 where c.IsActive=1 and c.parentid=0 and c.cattype=1 group by c.categoryID order by c.sortorder "; 
	 //echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);	

 	 return $resulst;
 }

 

 function getEproductsubcat($db,$ctid){ 	
     //$strQry =" select * from ".tbl_category."  where IsActive=1 and categoryslug = '".$ctid."'";
	 //$strQry =" select * from ".tbl_category." where IsActive=1 and parentid = (select categoryID from ".tbl_category." where categoryslug = '".$ctid."') ";
	 $strQry = "select * from ".tbl_product." where IsActive=1 and producttype=1 and (categoryid = (select categoryID from ".tbl_category." where categoryslug = '".$ctid."') or subcategoryid = (select categoryID from ".tbl_category." where categoryslug = '".$ctid."')) order by ".tbl_product.".mydate desc";
	 //echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
 	 return $resulst;
 } 

 function getEproductcatname($db,$ctid){ 
     $strQry =" select * from ".tbl_category."  where IsActive=1 and cattype=1 and categoryslug = '".$ctid."'"; 
	 $resulst=$db->get_a_line($strQry);	
	 //print_r($resulst);		exit;
 	 return $resulst;
 }

 function getEproductcatprod($db,$ctid){ 	
     //$strQry =" SELECT p.* FROM ".tbl_product." p INNER JOIN ".tbl_category." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and c.cattype=1 and p.IsActive = 1 and p.producttype=1 AND c.categoryslug = '".$ctid."' order by p.mydate desc";
	 $strQry =" SELECT p.* FROM ".tbl_product." p INNER JOIN ".tbl_category." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and c.cattype=1 and p.IsActive = 1 and p.producttype=1 AND c.categoryslug = '".$ctid."' ORDER BY p.sortorder asc ";
	//echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;
 	 return $resulst;
 } 

 function getEproductcatprods($db){ 	
     //$strQry =" SELECT p.* FROM ".tbl_product." p INNER JOIN ".tbl_category." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and c.cattype=1 and p.IsActive = 1 and p.producttype=1  order by p.mydate desc";
	 $strQry =" SELECT p.* FROM ".tbl_product." p INNER JOIN ".tbl_category." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and c.cattype=1 and p.IsActive = 1 and p.producttype=1  order by p.sortorder asc";
	 //echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
 	 return $resulst;
 } 
 
 function getEproductdetail($db,$ptid){ 	
 
	 $strQry =" select * from ".tbl_product."  where IsActive=1 and  producttype=1 and  productslug = '".$ptid."'"; 
	 $resulst=$db->get_a_line($strQry);
	 //print_r[$resulst];		exit;
	 return $resulst;
 } 
  
 function getEproductdetailname($db,$ptid){ 	
 
	 $strQry =" select c.* from ".tbl_product." p INNER JOIN ".tbl_category." c where p.categoryid = c.categoryID and c.IsActive=1 and c.cattype=1  and  p.producttype=1  and p.IsActive=1 and p.productslug ='".$ptid."'";
	// echo $strQry;		exit;
	 $resulst=$db->get_a_line($strQry);
	 return $resulst;
 }

 function getEproductdetailspec($db,$ptid){ 	
 
	 $strQry = "SELECT ps.*, p.* FROM ".tbl_product_specification." ps INNER JOIN ".tbl_product." p WHERE ps.IsActive = 1 AND p.IsActive = 1  and p.productID = ps.productID  and  p.producttype=1 AND productslug = '".$ptid."' order by ps.sorting_order ";
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
 }
 
 function getEproductdetailgall($db,$ptid){ 	
 
	 $strQry = "SELECT pg.*, p.* FROM ".tbl_product_gallery." pg INNER JOIN ".tbl_product." p WHERE pg.IsActive = 1 AND p.IsActive = 1  and  p.producttype=1 and p.productID = pg.productID AND productslug = '".$ptid."' order by pg.sorting_order ";
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
 }
 
 function getEproductdetaildwld1($db,$ptid){ 	
 
	 $strQry = "SELECT pd.*, p.* FROM ".tbl_product_downloads." pd INNER JOIN ".tbl_product." p WHERE pd.manuals_id = '1' and pd.IsActive = 1 AND p.IsActive = 1  and  p.producttype=1 and p.productID = pd.productID AND productslug = '".$ptid."' order by pd.sorting_order";
	// echo $strQry; die();
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
 }
 
 function getEproductdetaildwld2($db,$ptid){ 	
 
	 $strQry = "SELECT pd.*, p.* FROM ".tbl_product_downloads." pd INNER JOIN ".tbl_product." p WHERE pd.manuals_id = '2' and pd.IsActive = 1 AND p.IsActive = 1 and  p.producttype=1 and p.productID = pd.productID AND productslug = '".$ptid."' order by pd.sorting_order";
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
 }
 
 function getRproductcat($db){ 	
	 
     $strQry =" select * from ".tbl_rcategory." c inner join ".tbl_rproduct." p on  p.categoryid = c.categoryID and p.IsActive = 1 where c.IsActive=1 and c.parentid=0 group by c.categoryID order by c.sortorder"; 
	 $resulst=$db->get_rsltset($strQry);	
 	 return $resulst;
 }
 
 function getRproductcatprods($db){ 
	
     //$strQry =" SELECT p.* FROM ".tbl_rproduct." p INNER JOIN ".tbl_rcategory." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and p.IsActive = 1 order by p.mydate desc ";
	 $strQry =" SELECT p.* FROM ".tbl_rproduct." p INNER JOIN ".tbl_rcategory." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and p.IsActive = 1 order by p.sortorder asc ";
	//echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;
 	 return $resulst;
 }
 
 function getRproductcatname($db,$ctid){ 	
	 
     $strQry =" select * from ".tbl_rcategory." where IsActive=1 and categoryslug = '".$ctid."'"; 
	 //echo $strQry;		exit;
	 $resulst=$db->get_a_line($strQry);	
 	 return $resulst;
 }
  
 function getRproductcatprod($db,$ctid){ 
	//echo $ctid;		exit;
     //$strQry =" SELECT p.* FROM ".tbl_rproduct." p INNER JOIN ".tbl_rcategory." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and p.IsActive = 1 AND c.categoryslug = '".$ctid."' order by p.mydate desc";
	 $strQry =" SELECT p.* FROM ".tbl_rproduct." p INNER JOIN ".tbl_rcategory." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and p.IsActive = 1 AND c.categoryslug = '".$ctid."' order by p.sortorder asc";
	//echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;
 	 return $resulst;
 }
 
 function getRproductdetail($db,$ptid){ 	
 
	 $strQry =" select * from ".tbl_rproduct."  where IsActive=1 and productslug = '".$ptid."'"; 
	 $resulst=$db->get_a_line($strQry);
	 return $resulst;
 } 
  
 function getRproductdetailname($db,$ptid){ 	
 
	 $strQry =" select c.* from ".tbl_rproduct." p INNER JOIN ".tbl_rcategory." c where p.categoryid = c.categoryID and c.IsActive=1 and productslug ='".$ptid."'";
	 $resulst=$db->get_a_line($strQry);
	 return $resulst;
 }

 function getRproductdetailspec($db,$ptid){ 	
 
	 $strQry = "SELECT ps.*, p.* FROM ".tbl_rproduct_specification." ps INNER JOIN ".tbl_rproduct." p WHERE ps.IsActive = 1 AND p.IsActive = 1 and p.productID = ps.productID AND productslug = '".$ptid."' order by ps.sorting_order ";
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;
	 return $resulst;
 }
 
 function getRproductdetailgall($db,$ptid){ 	
 
	 $strQry = "SELECT pg.*, p.* FROM ".tbl_rproduct_gallery." pg INNER JOIN ".tbl_rproduct." p WHERE pg.IsActive = 1 AND p.IsActive = 1 and p.productID = pg.productID AND productslug = '".$ptid."' order by pg.sorting_order ";
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
 }
 
 function getRproductdetaildwld1($db,$ptid){ 	

	 $strQry = "SELECT pd.*, p.* FROM ".tbl_rproduct_downloads." pd INNER JOIN ".tbl_rproduct." p WHERE pd.manuals_id = '1' and pd.IsActive = 1 AND p.IsActive = 1 and p.productID = pd.productID AND productslug = '".$ptid."' order by pd.sorting_order";
	// echo $strQry; die();
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
 }
 
 function getRproductdetaildwld2($db,$ptid){ 	

	 $strQry = "SELECT pd.*, p.* FROM ".tbl_rproduct_downloads." pd INNER JOIN ".tbl_rproduct." p WHERE pd.manuals_id = '2' and pd.IsActive = 1 AND p.IsActive = 1 and p.productID = pd.productID AND productslug = '".$ptid."' order by pd.sorting_order";
	// echo $strQry; die();
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
 }
 
 function getEprodsubctcount($db,$ctid){ 	
	 $strQry ="SELECT count(*) as count FROM ".tbl_category." WHERE IsActive = 1 and cattype=1 and parentid = (select categoryID from ".tbl_category." where categoryslug = '".$ctid."')";
	 $resulst=$db->get_a_line($strQry);	
	 $resulst = $resulst['count'];
 	 return $resulst;
 }
 
 
 function getEprodsubcategory($db,$ctid){ 	
	 $strQry ="SELECT * FROM ".tbl_category." WHERE IsActive = 1 and cattype=1 and parentid = (select categoryID from ".tbl_category." where IsActive = 1 and categoryslug = '".$ctid."')";
	 //echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);	
 	 return $resulst;
 }
 
 function getRprodsubctcount($db,$ctid){ 	
	 $strQry ="SELECT count(*) as count FROM ".tbl_rcategory." WHERE IsActive = 1 and parentid = (select categoryID from ".tbl_rcategory." where categoryslug = '".$ctid."')";
	 
	 $resulst=$db->get_a_line($strQry);	
	 $resulst = $resulst['count'];
 	 return $resulst;
 }
 
 function getRprodsubcategory($db,$ctid){ 	
	 $strQry ="SELECT * FROM ".tbl_rcategory." WHERE IsActive = 1 and parentid = (select categoryID from ".tbl_rcategory." where IsActive = 1 and categoryslug = '".$ctid."')";
	
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;
 	 return $resulst;
 }

 function getRproductsubcat($db,$ctid){ 	
	 //echo "Slug : ".$ctid;	exit;
     //$strQry =" select * from ".tbl_category."  where IsActive=1 and categoryslug = '".$ctid."'";
	 //$strQry =" select * from ".tbl_rproduct." where IsActive=1 and subcategoryid = (select categoryID from ".tbl_rcategory." where categoryslug = '".$ctid."') ";
	// $strQry = "select * from ".tbl_rcategory." where IsActive=1 and categoryid = (select categoryID from ".tbl_rcategory." where categoryslug = '".$ctid."')";
	
	$strQry = "select * from ".tbl_rproduct." where IsActive=1 and (categoryid = (select categoryID from ".tbl_rcategory." where categoryslug = '".$ctid."') or subcategoryid = (select categoryID from ".tbl_rcategory." where categoryslug = '".$ctid."')) order by ".tbl_rproduct.".mydate desc";
	//echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;	
	 return $resulst;
 } 
 
 function getEproductdetaildesc($db,$ptid){ 	
 
	 $strQry = "SELECT ps.*, p.*, ps.description as proddesc FROM ".tbl_product_description." ps INNER JOIN ".tbl_product." p WHERE ps.IsActive = 1 AND p.IsActive = 1 and p.productID = ps.productID AND productslug = '".$ptid."' order by ps.sorting_order ";
	 //echo $strQry;	exit;
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;
	 return $resulst;
 }
 
 function getRproductdetaildesc($db,$ptid){ 	
 
	 $strQry = "SELECT ps.*, p.*, ps.description as proddesc FROM ".tbl_rproduct_description." ps INNER JOIN ".tbl_rproduct." p WHERE ps.IsActive = 1 AND p.IsActive = 1 and p.productID = ps.productID AND productslug = '".$ptid."' order by ps.sorting_order ";
	 //echo $strQry;	exit;
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;
	 return $resulst;
 }
 /*
 function getEproductgallerycount($db,$ptid){ 	
 
	 $strQry = "SELECT count(*) as count FROM ".tbl_product_gallery." where IsActive = 1 ";
	 echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
 }
 */
 
 // For Automation solutions Method 
  function getAproductcat($db){ 	
	 
     $strQry =" select c.* from ".tbl_category." c  inner join ".tbl_product." p  on c.categoryID=p. categoryid and p.IsActive=1 and  p.producttype=2 where c.IsActive=1  and  c.parentid=0 and c.cattype=2 group by c.categoryID order by c.sortorder"; 
	 //echo $strQry; exit;
	 $resulst=$db->get_rsltset($strQry);	
	 return $resulst;
 } 
 
 function getAproductcatprods($db){ 	
     //$strQry =" SELECT p.* FROM ".tbl_product." p INNER JOIN ".tbl_category." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and c.cattype=2 and p.IsActive = 1 and p.producttype=2  order by p.mydate desc";
	 $strQry =" SELECT p.* FROM ".tbl_product." p INNER JOIN ".tbl_category." c WHERE p.categoryid = c.categoryID and c.IsActive = 1 and c.cattype=2 and p.IsActive = 1 and p.producttype=2  order by p.sortorder asc";
	 //echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
 	 return $resulst;
    } 
 
 
 function getAprodsubcategory($db,$ctid){ 	
	 $strQry ="SELECT * FROM ".tbl_category." WHERE IsActive = 1 and cattype=2  and parentid = (select categoryID from ".tbl_category." where IsActive = 1 and categoryslug = '".$ctid."')";
	 //echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);	
 	 return $resulst;
 }
 
 function getAproductsubcat($db,$ctid){ 	
     
	 $strQry = "select * from ".tbl_product." where IsActive=1 and producttype=2 and (categoryid = (select categoryID from ".tbl_category." where categoryslug = '".$ctid."') or subcategoryid = (select categoryID from ".tbl_category." where categoryslug = '".$ctid."')) order by ".tbl_product.".sortorder asc";
	 //echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
 	 return $resulst;
 } 
 
 function getAprodsubctcount($db,$ctid){ 	
	 $strQry ="SELECT count(*) as count FROM ".tbl_category." WHERE IsActive = 1 and cattype=2 and parentid = (select categoryID from ".tbl_category." where categoryslug = '".$ctid."')";
	 $resulst=$db->get_a_line($strQry);	
	 $resulst = $resulst['count'];
 	 return $resulst;
 }
 
 function getAproductcatname($db,$ctid){ 
     $strQry =" select * from ".tbl_category."  where IsActive=1  and cattype=2 and categoryslug = '".$ctid."'"; 
	 $resulst=$db->get_a_line($strQry);	
	 //print_r($resulst);		exit;
 	 return $resulst;
 }
 
 function getAproductcatprod($db,$ctid){ 	
     $strQry =" SELECT p.* FROM ".tbl_product." p INNER JOIN ".tbl_category." c WHERE
    p.categoryid = c.categoryID and c.IsActive = 1 and c.cattype=2 and p.IsActive = 1 and p.producttype=2 AND c.categoryslug = '".$ctid."' order by p.mydate desc";
	//echo $strQry;		exit;
	 $resulst=$db->get_rsltset($strQry);
 	 return $resulst;
 } 
 
 //Automation Solution details function
 
    function getAproductdetailname($db,$ptid){ 	
 
		$strQry =" select c.* from ".tbl_product." p INNER JOIN ".tbl_category." c where p.categoryid = c.categoryID and c.IsActive=1 and c.cattype=2 and p.producttype=2 and productslug ='".$ptid."'";
		$resulst=$db->get_a_line($strQry);
		return $resulst;
    }
	
	
	
	function getAproductdetailspec($db,$ptid){ 	
 
	 $strQry = "SELECT ps.*, p.* FROM ".tbl_product_specification." ps INNER JOIN ".tbl_product." p WHERE ps.IsActive = 1 AND p.IsActive = 1 and p.producttype = 2 and p.productID = ps.productID AND productslug = '".$ptid."' order by ps.sorting_order ";
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
	}
	
	function getAproductdetailgall($db,$ptid){ 	
 
	 $strQry = "SELECT pg.*, p.* FROM ".tbl_product_gallery." pg INNER JOIN ".tbl_product." p WHERE pg.IsActive = 1 AND p.IsActive = 1 and p.producttype=2 and p.productID = pg.productID AND productslug = '".$ptid."' order by pg.sorting_order ";
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
    }
	
	function getAproductdetaildwld1($db,$ptid){ 	
 
	 $strQry = "SELECT pd.*, p.* FROM ".tbl_product_downloads." pd INNER JOIN ".tbl_product." p WHERE pd.manuals_id = '1' and pd.IsActive = 1 AND p.IsActive = 1 and p.producttype=2 and p.productID = pd.productID AND productslug = '".$ptid."' order by pd.sorting_order";
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
    }
	
	function getAproductdetaildwld2($db,$ptid){ 	
 
	 $strQry = "SELECT pd.*, p.* FROM ".tbl_product_downloads." pd INNER JOIN ".tbl_product." p WHERE pd.manuals_id = '2' and pd.IsActive = 1 AND p.IsActive = 1  and p.producttype=2 and p.productID = pd.productID AND productslug = '".$ptid."' order by pd.sorting_order";
	 $resulst=$db->get_rsltset($strQry);
	 return $resulst;
    }
	
	function getAproductdetaildesc($db,$ptid){ 	
 
	 $strQry = "SELECT ps.*, p.*, ps.description as proddesc FROM ".tbl_product_description." ps INNER JOIN ".tbl_product." p WHERE ps.IsActive = 1 AND p.IsActive = 1 and p.producttype=2 and p.productID = ps.productID AND productslug = '".$ptid."' order by ps.sorting_order ";
	 //echo $strQry;	exit;
	 $resulst=$db->get_rsltset($strQry);
	 //print_r($resulst);		exit;
	 return $resulst;
    }
 
 function getAproductdetail($db,$ptid){ 	
 
	 $strQry =" select * from ".tbl_product."  where IsActive=1 and producttype=2 and productslug = '".$ptid."'"; 
	 $resulst=$db->get_a_line($strQry);
	 //print_r[$resulst];		exit;
	 return $resulst;
    } 
	
//Services Functions

    function getjoblist($db){
    
	$strQry =" select j.*,l.location_name as location,p.position_name as position from ".tbl_jobcareer." j inner join ".tbl_location." l on l.location_id=j.location_id inner join ".tbl_position." p on p.position_id = j.position_id where j.isactive=1 and l.isactive=1 and p.isactive = 1 order by j.regdate desc"; 
	//echo $strQry; die();
	$resulst=$db->get_rsltset($strQry);	
 	return $resulst;
 
    }	
	
	function getjobdetail($db,$slugname){ 	
     //echo $slugname; exit;
	$strQry =" select j.*,l.location_name as location,p.position_name as position from ".tbl_jobcareer." j inner join ".tbl_location." l on l.location_id=j.location_id inner join ".tbl_position." p on p.position_id = j.position_id where j.isactive=1 and l.isactive=1 and p.isactive = 1 and j.tittlename_url = '".$slugname."'"; 
	 //echo $strQry; exit;
	 $resulst=$db->get_a_line($strQry);
	 //print_r[$resulst];		exit;
	 return $resulst;
    } 
	
	
	//career enquiry start
	  
	  function save_career($db,$filter){ 
	//  print_r($_FILES); die();
	//echo "ggdfgdf"; die();
	 $today = date("Y-m-d h:i:s");
	 if(isset($_FILES["upload_resume"])){
		 $extsn = pathinfo($_FILES["upload_resume"]["name"],PATHINFO_EXTENSION);
		
	 }
	 
	 if(($extsn=="doc")||($extsn=="docx")||($extsn=="pdf")) {
	 if(($filter['name']!="")&&($filter['email']!="")){
		// echo "fdgfdg"; die();
		 $today = date("Y-m-d h:i:s");
		 
		
			if(isset($_FILES["upload_resume"])){
			
				$newf=str_replace(' ','_',$_FILES["upload_resume"]["name"]);

				$newf=$gallname=time().rand(0,9).$newf;
											  
						
				move_uploaded_file($_FILES["upload_resume"]["tmp_name"],"uploads/careerresume/".$newf);
				
			}
		 
 $strQry ="INSERT INTO ".tbl_careers." ( name, email, phone, resumefile,message,designation, isactive, createddate ) VALUES ( '".trim(addslashes($filter['name']))."','".trim(addslashes($filter['email']))."',  '".trim(addslashes($filter['phone']))."','".addslashes($newf)."','".addslashes($filter['message'])."','".addslashes($filter['designation'])."', '1','".$today."')";
		 
//	echo $strQry;	exit;	 
	$rsltMenu=$db->insert($strQry);	
	
	if($rsltMenu==1){
		
			$to  = 'hrm@akasinfusions.com,amrith@akasinfusions.com';
			
			$subject = 'AKAS INFUSIONS :: Career Enquiry';
			
			$message = '<table width="500"  border="0" cellpadding="3" cellspacing="0" bordercolor="#000" bgcolor="#ffffff" style="border: solid 1px #4e3101">
  <tr>
    <td><table width="500" height="" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td height="24" colspan="3" valign="top" style="background:#fe0000 " ><font face="Arial, Helvetica, sans-serif" size="4" color="#FFFFFF"><strong>Career Enquiry</strong></font></td>
      </tr>';
	  
	 
 	if(isset($filter['name'])){
				
            $message.='<tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b> Name</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['name'].'</font>        </td>
      </tr>';
			}
			
			if(isset($filter['email'])){
				
            $message.='<tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b> Email</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['email'].'</font>        </td>
      </tr>';
			}
			
			
			if(isset($filter['phone'])){
				
            $message.='<tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b> Phone Number</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['phone'].'</font>        </td>
      </tr>';
			}
			
			if(isset($filter['location'])){
				
            $message.='<tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b> Location</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['location'].'</font>        </td>
      </tr>';
			}
			
			
			if(isset($filter['designation'])){
				
            $message.='<tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b> Designation</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['designation'].'</font>        </td>
      </tr>';
			}
			if(isset($filter['message'])){
				
            $message.='<tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b> Message</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['message'].'</font>        </td>
      </tr>';
			}
			

//echo
         $message.='<tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b> Download</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a"><a href="'.BASE_URL.'uploads/careerresume/'.$newf.'">Resume</a></font>        </td>
      </tr></table></td>
  </tr>
</table>';

//echo $message; die();

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: support@akasinfusions.com ' . "\r\n";
$headers .= 'Bcc: websupport@pixel-studios.com' . "\r\n";
//$headers .= 'From:"'.FROMEMAIL.'"'. "\r\n";
//$headers .= 'Bcc: "'.BCCEMAIL.'"' . "\r\n";


mail($to, $subject, $message, $headers);



		 echo json_encode(array("rslt"=>count($rsltMenu)));
		 
		
	
		 }
		else{
			
			echo json_encode(array("rslt"=>0));
			}
	
	
	 }
		else{
			//echo "cxvxv"; die();
			echo json_encode(array("rslt"=>0));
			}
	 }
	
		else{
			echo json_encode(array("rslt"=>2));
		}
}
	 //career enquiry end
	 
	
	// Pop up Enquiry Start
 
  function save_PopupEnquiry($db,$filter){
	  
       if(($filter['iname']!="")&&($filter['iemail']!="")&&($filter['imobile']!="")){
 
$today = date("Y-m-d h:i:s");
    $strQry ="INSERT INTO ".tbl_popup_enquiry." (`name`, `email`, `mobile`,`hospital_name`, `state`, `city`,`isactive`,`createdate`) VALUES ('".addslashes($filter['iname'])."','".$filter['iemail']."','".addslashes($filter['imobile'])."','".addslashes($filter['ihospital'])."','".addslashes($filter['state'])."','".addslashes($filter['icity'])."','1','".$today."')";
	
	$rsltMenu=$db->insert($strQry);	
	if($rsltMenu==1){
		
	$to  = 'sales@akasinfusions.com,amrith@akasinfusions.com,krishna@akasinfusions.com,nandini@akasinfusions.com';	
	
		$subject = 'AKAS INFUSIONS :: ENQUIRE NOW';

$message = '<table width="500"  border="0" cellpadding="3" cellspacing="0" bordercolor="#000" bgcolor="#ffffff" style="border: solid 1px #4e3101">
  <tr>
    <td><table width="500" height="" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td height="24" colspan="3" valign="top" style="background:#ed1c24 " ><font face="Arial, Helvetica, sans-serif" size="4" color="#FFFFFF"><strong>ENQUIRE NOW</strong></font></td>
      </tr>
	  
      <tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Name</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['iname'].'</font>        </td>
      </tr>
	  
   
	  
      <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Email</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['iemail'].'</font></td>
      </tr>
      <tr>
        <td height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Phone</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['imobile'].'</font></td>
      </tr>
	  
	   <tr>
        <td height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Hospital Name</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['ihospital'].'</font></td>
      </tr>
	
      <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>City</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font></td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['icity'].'</font></td>
      </tr>
	  
	   <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>State</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font></td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['state'].'</font></td>
      </tr>
        </table></td>
  </tr>
</table>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: support@akasinfusions.com ' . "\r\n";
$headers .= 'Bcc: websupport@pixel-studios.com' . "\r\n";
//$headers .= 'From:"'.FROMEMAIL.'"'. "\r\n";
//$headers .= 'Bcc: "'.BCCEMAIL.'"' . "\r\n";

mail($to, $subject, $message, $headers);


		 echo json_encode(array("rslt"=>count($rsltMenu)));
		 
		 
		}
		else{
			echo json_encode(array("rslt"=>0));
			}
			
			}
		else{
			echo json_encode(array("rslt"=>0));
			}

   
     
 } 
 
// Pop up Enquiry End	

// Platinum Membership Enquiry Start
 
  function save_PlatinumEnquiry($db,$filter){
	  
       if(($filter['iname']!="")&&($filter['iemail']!="")&&($filter['iphone']!="")){
 
$today = date("Y-m-d h:i:s");
    $strQry ="INSERT INTO ".tbl_platinum_enquiry." (`name`, `email`, `mobile`,`hname`, `cname`, `noofpumps`,`hospitalyear`,`isactive`,`createdate`) VALUES ('".addslashes($filter['iname'])."','".$filter['iemail']."','".addslashes($filter['iphone'])."','".addslashes($filter['hname'])."','".addslashes($filter['cname'])."','".addslashes($filter['noofpumps'])."','".addslashes($filter['hospitalyear'])."','1','".$today."')";
	
	$rsltMenu=$db->insert($strQry);	
	if($rsltMenu==1){
		
			$to  = 'sales@akasinfusions.com,amrith@akasinfusions.com,krishna@akasinfusions.com,nandini@akasinfusions.com';	
		$subject = 'AKAS INFUSIONS :: Platinum Membership Enquiry ';

$message = '<table width="500"  border="0" cellpadding="3" cellspacing="0" bordercolor="#000" bgcolor="#ffffff" style="border: solid 1px #4e3101">
  <tr>
    <td><table width="500" height="" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td height="24" colspan="3" valign="top" style="background:#ed1c24 " ><font face="Arial, Helvetica, sans-serif" size="4" color="#FFFFFF"><strong>Platinum Membership Enquiry </strong></font></td>
      </tr>
	  
      <tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Hospital Name</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['hname'].'</font>        </td>
      </tr>
	  
	   <tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Customer Since</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['cname'].'</font>        </td>
      </tr>
	  
	  <tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Name</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['iname'].'</font>        </td>
      </tr>
	  
   
	  
      <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Email</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['iemail'].'</font></td>
      </tr>
      <tr>
        <td height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Phone</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['iphone'].'</font></td>
      </tr>
	  
	   <tr>
        <td height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Total no.of Infusion Pumps</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['noofpumps'].'</font></td>
      </tr>
	
      <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Hospital Founder Year</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font></td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['hospitalyear'].'</font></td>
      </tr>
	  
	  
        </table></td>
  </tr>
</table>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: support@akasinfusions.com ' . "\r\n";
$headers .= 'Bcc: websupport@pixel-studios.com' . "\r\n";
//$headers .= 'From:"'.FROMEMAIL.'"'. "\r\n";
//$headers .= 'Bcc: "'.BCCEMAIL.'"' . "\r\n";


mail($to, $subject, $message, $headers);

		 echo json_encode(array("rslt"=>count($rsltMenu)));
		 
		 
		}
		else{
			echo json_encode(array("rslt"=>0));
			}
			
			}
		else{
			echo json_encode(array("rslt"=>0));
			}

   
     
 } 
 
// Platinum Membership Enquiry End	
	
	
	// Contact us mail
 
  function save_contact($db,$filter){ 
       if(($filter['name']!="")&&($filter['email']!="")&&($filter['mobile']!="")){
 
$today = date("Y-m-d h:i:s");
    $strQry ="INSERT INTO ".tbl_contact_us." (`name`, `email`, `mobile`, `company`, `nature_company`, `city`, `message`, `isactive`, `createdate`) VALUES ('".addslashes($filter['name'])."','".$filter['email']."','".addslashes($filter['mobile'])."','".addslashes($filter['company'])."','".addslashes($filter['nature_company'])."','".addslashes($filter['city'])."','".addslashes($filter['message'])."',1,'".$today."')";
	
	$rsltMenu=$db->insert($strQry);	
	if($rsltMenu==1){
		
			$to  = 'sales@akasinfusions.com,amrith@akasinfusions.com,krishna@akasinfusions.com,nandini@akasinfusions.com';	
		$subject = 'AKAS :: General Enquiry';

$message = '<table width="500"  border="0" cellpadding="3" cellspacing="0" bordercolor="#000" bgcolor="#ffffff" style="border: solid 1px #4e3101">
  <tr>
    <td><table width="500" height="" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td height="24" colspan="3" valign="top" style="background:#ed1c24 " ><font face="Arial, Helvetica, sans-serif" size="4" color="#FFFFFF"><strong>General Enquiry</strong></font></td>
      </tr>
	  
      <tr>
        <td width="40%" height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Name</b></font></td>
        <td width="10%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font>  </td>
        <td width="50%" valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['name'].'</font>        </td>
      </tr>
	  
   
	  
      <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Email</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['email'].'</font></td>
      </tr>
      <tr>
        <td height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Phone</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['mobile'].'</font></td>
      </tr>
	  
	   <tr>
        <td height="24" valign="top" bgcolor="#f4f4f4"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Location</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font> </td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['city'].'</font></td>
      </tr>
	
      <tr>
        <td height="24" valign="top" bgcolor="#f7f7f7"><font face="Arial, Helvetica, sans-serif" size="2" color="#2e2e2e"><b>Message</b></font></td>
        <td valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">:</font></td>
        <td valign="top" ><font face="Arial, Helvetica, sans-serif" size="2" color="#002a3a">'.$filter['message'].'</font></td>
      </tr>
        </table></td>
  </tr>
</table>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: support@akasinfusions.com ' . "\r\n";
$headers .= 'Bcc: websupport@pixel-studios.com' . "\r\n";
//$headers .= 'From:"'.FROMEMAIL.'"'. "\r\n";
//$headers .= 'Bcc: "'.BCCEMAIL.'"' . "\r\n";


mail($to, $subject, $message, $headers);

		 echo json_encode(array("rslt"=>count($rsltMenu)));
		 
		 
		}
		else{
			echo json_encode(array("rslt"=>0));
			}
			
			}
		else{
			echo json_encode(array("rslt"=>0));
			}

   
     
 } 
	
	
	
	
	
 
?>