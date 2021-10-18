<?php
error_reporting(0);
class ajax extends Controller {	
	
	function index(){}
	
	//contact Enquiry Start
	
	public	function save_contact()
	{
		//echo "Save"; exit;
		$common = $this->loadModel('common_model'); 
		
		$data=$common->save_contact($_REQUEST);
	}
	//contact Enquiry End
	
	//Career Enquiry Start
	
	public	function save_career()
	{
		//echo "Save"; exit;
		$common = $this->loadModel('common_model'); 
		
		$data=$common->save_career($_REQUEST);
	}
	//Career Enquiry End
	
	//Popup Enquiry Start
	
	public	function save_PopupEnquiry()
	{
		//echo "Save"; exit;
		$common = $this->loadModel('common_model'); 
		
		$data=$common->save_PopupEnquiry($_REQUEST);
	}
	//Popup Enquiry End
	
	//Platinum Membership Enquiry Start
	
	public	function save_PlatinumEnquiry()
	{
		//echo "Save"; exit;
		$common = $this->loadModel('common_model'); 
		
		$data=$common->save_PlatinumEnquiry($_REQUEST);
	}
	//Platinum Membership Enquiry End
	
	//Nurse Training Enquiry Start
	
	public	function save_NurseTrainingEnquiry()
	{
		//echo "Save"; exit;
		$common = $this->loadModel('common_model'); 
		
		$data=$common->save_NurseTrainingEnquiry($_REQUEST);
	}
	//Nurse Training Enquiry End


	//R & D Committee Enquiry Start
	
	public	function save_RndCommitteeEnquiry()
	{
		//echo "Save"; exit;
		$common = $this->loadModel('common_model'); 
		
		$data=$common->save_RndCommitteeEnquiry($_REQUEST);
	}
	//R & D Committee Enquiry End
	
	
	
	
	
	
}
	?>