<?php
error_reporting(0);
class common_model extends Model {
	################## Home Page ###############
	public function getAnnouncement(){
 		
		require_once('common_function.php');	
 		$result = getAnnouncement($this);	
		return $result;
	}
	
	public function getPressReleaseList($filter=null,$count=null){
 		
		require_once('common_function.php');	
 		$result = getPressReleaseList($this,$count,$filter);	
		return $result;
	}
	
	public function getTVCommercialsList($filter=null,$count=null){
 		
		require_once('common_function.php');	
 		$result = getTVCommercialsList($this,$count,$filter);	
		return $result;
	}
	
	public function getNewsList($filter=null,$count=null){
 		
		require_once('common_function.php');	
 		$result = getNewsList($this,$count,$filter);	
		return $result;
	}
	
	public function getCentersList($filter=null,$count=null){
 		
		require_once('common_function.php');	
 		$result = getCentersList($this,$count,$filter);	
		return $result;
	}
	
	
	public function getNewsDetails($projectstatus){
 		
		require_once('common_function.php');	
 		$result = getNewsDetails($this,$projectstatus);	
		return $result;
	}
	
	public function getNewsImagesDetails($projectstatus){
 		
		require_once('common_function.php');	
 		$result = getNewsImagesDetails($this,$projectstatus);	
		return $result;
	}
	
	public function getCategory($catid=null){
 		
		require_once('common_function.php');	
 		$result = getCategory($this,$catid);	
		return $result;
	}
	public function getState($catid=null,$contry=null){
 		
		require_once('common_function.php');	
 		$result = getState($this,$catid,$contry);	
		return $result;
	}
	public function getStatelist($filter){
 		
		require_once('common_function.php');	
 		$result = getStatelist($this,$filter);	
		return $result;
	}
	
	public function getCity($filter){
 		
		require_once('common_function.php');	
 		$result = getCity($this,$filter);	
		return $result;
	}
	
	
	public function getCurrentOpeningList($filter=null,$count=null){
 		
		require_once('common_function.php');	
 		$result = getCurrentOpeningList($this,$count,$filter);	
		return $result;
	}
	
	
	public function Save_carrier_Enquiry_Details(){	
		require_once('common_function.php');
		
	$rslt_data = save_carrier_enquiry_details_todb($this,$_REQUEST);		
		return $rslt_data;		
	}
	
	public function getEproductcat(){
		require_once('common_function.php');	
 		$result = getEproductcat($this);	
		return $result;
	}
	
	public function getEproductsubcat($ctid){
		require_once('common_function.php');	
 		$result = getEproductsubcat($this,$ctid);	
		return $result;
	}
	
	public function getEproductcatname($ctid){
		require_once('common_function.php');	
 		$result = getEproductcatname($this,$ctid);	
		return $result;
	}
	
	public function getEproductcatprod($ctid){
		require_once('common_function.php');	
 		$result = getEproductcatprod($this,$ctid);	
		return $result;
	}
	
	public function getEproductcatprods(){
		require_once('common_function.php');	
 		$result = getEproductcatprods($this);	
		return $result;
	}
	
	public function getAproductcatprods(){
		require_once('common_function.php');	
 		$result = getAproductcatprods($this);	
		return $result;
	}
	
	public function getEproductdetail($ptid){	
		require_once('common_function.php');	
 		$result = getEproductdetail($this,$ptid);	
		return $result;
	}
	
	public function getEproductdetailname($ptid){	
		require_once('common_function.php');	
 		$result = getEproductdetailname($this,$ptid);	
		return $result;
	}
	
	public function getEproductdetailspec($ptid){	
		require_once('common_function.php');	
 		$result = getEproductdetailspec($this,$ptid);	
		return $result;
	}
	
	public function getEproductdetailgall($ptid){	
		require_once('common_function.php');	
 		$result = getEproductdetailgall($this,$ptid);	
		return $result;
	}
	
	public function getEproductdetaildwld1($ptid){	
		require_once('common_function.php');	
 		$result = getEproductdetaildwld1($this,$ptid);	
		return $result;
	}
	
	public function getEproductdetaildwld2($ptid){	
		require_once('common_function.php');	
 		$result = getEproductdetaildwld2($this,$ptid);	
		return $result;
	}
	
	public function getRproductcat(){
		require_once('common_function.php');	
 		$result = getRproductcat($this);	
		return $result;
	}
	
	public function getRproductcatname($ctid){
		require_once('common_function.php');	
 		$result = getRproductcatname($this,$ctid);	
		return $result;
	}
	
	public function getRproductcatprod($ctid){
		require_once('common_function.php');	
 		$result = getRproductcatprod($this,$ctid);	
		return $result;
	}
	
	public function getRproductdetail($ptid){	
		require_once('common_function.php');	
 		$result = getRproductdetail($this,$ptid);	
		return $result;
	}
	
	
	public function getRproductcatprods(){	
		require_once('common_function.php');	
 		$result = getRproductcatprods($this);	
		return $result;
	}
	
	public function getRproductdetailname($ptid){	
		require_once('common_function.php');	
 		$result = getRproductdetailname($this,$ptid);	
		return $result;
	}
	
	public function getRproductdetailspec($ptid){	
		require_once('common_function.php');	
 		$result = getRproductdetailspec($this,$ptid);	
		return $result;
	}
	
	public function getRproductdetailgall($ptid){	
		require_once('common_function.php');	
 		$result = getRproductdetailgall($this,$ptid);	
		return $result;
	}
	
	public function getRproductdetaildwld1($ptid){	
		require_once('common_function.php');	
 		$result = getRproductdetaildwld1($this,$ptid);	
		return $result;
	}
	
	public function getRproductdetaildwld2($ptid){	
		require_once('common_function.php');	
 		$result = getRproductdetaildwld2($this,$ptid);	
		return $result;
	}
	
	public function getEprodsubctcount($ctid){
		require_once('common_function.php');	
 		$result = getEprodsubctcount($this,$ctid);
		return $result;
	}
	
	public function getEprodsubcategory($ctid){
		require_once('common_function.php');	
 		$result = getEprodsubcategory($this,$ctid);
		return $result;
	}
	
	public function getRprodsubctcount($ctid){
		require_once('common_function.php');	
 		$result = getRprodsubctcount($this,$ctid);
		return $result;
	}

	public function getRprodsubcategory($ctid){
		require_once('common_function.php');	
 		$result = getRprodsubcategory($this,$ctid);
		return $result;
	}
	
	public function getRproductsubcat($ctid){
		//echo $ctid;		exit;
		require_once('common_function.php');	
 		$result = getRproductsubcat($this,$ctid);	
		return $result;
	}
	
	public function getEproductdetaildesc($ptid){	
		require_once('common_function.php');	
 		$result = getEproductdetaildesc($this,$ptid);	
		return $result;
	}
	
	public function getRproductdetaildesc($ptid){	
		require_once('common_function.php');	
 		$result = getRproductdetaildesc($this,$ptid);	
		return $result;
	}
	
	/*
	public function getEproductgallerycount($ptid){	
		require_once('common_function.php');	
 		$result = getEproductgallerycount($this,$ptid);	
		return $result;
	}
	*/

//Automation Solutions	
	public function getAproductcat(){
		require_once('common_function.php');	
 		$result = getAproductcat($this);	
		return $result;
	}
	
	public function getAprodsubcategory($ctid){
		require_once('common_function.php');	
 		$result = getAprodsubcategory($this,$ctid);
		return $result;
	}
	
	
	public function getAproductsubcat($ctid){
		require_once('common_function.php');	
 		$result = getAproductsubcat($this,$ctid);	
		return $result;
	}
	
	public function getAproductcatname($ctid){
		require_once('common_function.php');	
 		$result = getAproductcatname($this,$ctid);	
		return $result;
	}
	
	public function getAprodsubctcount($ctid){
		require_once('common_function.php');	
 		$result = getAprodsubctcount($this,$ctid);
		return $result;
	}
	
	public function getAproductcatprod($ctid){
		require_once('common_function.php');	
 		$result = getAproductcatprod($this,$ctid);	
		return $result;
	}
	
//Automation Details page function 
   
    public function getAproductdetailname($ptid){	
		require_once('common_function.php');	
 		$result = getAproductdetailname($this,$ptid);	
		return $result;
	}

    public function getAproductdetailspec($ptid){	
		require_once('common_function.php');	
 		$result = getAproductdetailspec($this,$ptid);	
		return $result;
	}
	public function getAproductdetailgall($ptid){	
		require_once('common_function.php');	
 		$result = getAproductdetailgall($this,$ptid);	
		return $result;
	}
	
	public function getAproductdetaildwld1($ptid){	
		require_once('common_function.php');	
 		$result = getAproductdetaildwld1($this,$ptid);	
		return $result;
	}
	
	public function getAproductdetaildwld2($ptid){	
		require_once('common_function.php');	
 		$result = getAproductdetaildwld2($this,$ptid);	
		return $result;
	}
	
	public function getAproductdetaildesc($ptid){	
		require_once('common_function.php');	
 		$result = getAproductdetaildesc($this,$ptid);	
		return $result;
	}
	public function getAproductdetail($ptid){	
		require_once('common_function.php');	
 		$result = getAproductdetail($this,$ptid);	
		return $result;
	}
	
//getjoblist Page Functions
   
	public function getjoblist(){
		require_once('common_function.php');	
 		$result = getjoblist($this);	
		return $result;
	}
	
	public function getjobdetail($slugname){
		//echo $slugname; exit;
		require_once('common_function.php');	
 		$result = getjobdetail($this,$slugname);	
		return $result;
		
	}
	
	//career enquiry start
	 public function save_career($filters){
		//echo "Save"; exit;
		require_once('common_function.php');	
		$result = save_career($this,$filters);	
		return $result;
	}
	
	//career enquiry end
	
	//Popup Enquiry start
	 public function save_PopupEnquiry($filters){
		//echo "Save"; exit;
		require_once('common_function.php');	
		$result = save_PopupEnquiry($this,$filters);	
		return $result;
	}
	
	//Popup Enquiry end
	
	//Platinum Membership Enquiry start
	
	 public function save_PlatinumEnquiry($filters){
		//echo "Save"; exit;
		require_once('common_function.php');	
		$result = save_PlatinumEnquiry($this,$filters);	
		return $result;
	}
	
	//Platinum Membership Enquiry end
	
		//contact Enquiry start
	
	public function save_contact(){	
		require_once('common_function.php');
		
	$rslt_data = save_contact($this,$_REQUEST);		
		return $rslt_data;		
	}
	
	//contact Enquiry end
	
	//Nurse Training Enquiry start
	
	 public function save_NurseTrainingEnquiry($filters){
		//echo "Save"; exit;
		require_once('common_function.php');	
		$result = save_NurseTrainingEnquiry($this,$filters);	
		return $result;
	}
	
	//Nurse Training Enquiry end
	
	//R & D Committee Enquiry start
	
	 public function save_RndCommitteeEnquiry($filters){
		//echo "Save"; exit;
		require_once('common_function.php');	
		$result = save_RndCommitteeEnquiry($this,$filters);	
		return $result;
	}
	
	//R & D Committee Enquiry end
	
	
} 
?>