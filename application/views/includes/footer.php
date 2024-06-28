<section class="section footer section-top-btm text-left">
<div class="container">
<div class="row"> 

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
<div class="ble-log">
<img src="<?php echo BASE_URL;?>static/images/logo-blue.png" alt="" />
</div>
</div>

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
<div class="address-log">
<h4>India Office</h4>
<strong>WayCool Foods & Products Pvt. Ltd,</strong>
<p>Marathahalli - Sarjapur Outer Ring Rd,
 Devarabisanahalli, Bellandur,
 Bengaluru, Karnataka, India 560103</p>
</div>
</div>

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
<div class="address-log">
<h4>Dubai Office</h4>
<p>C/o  M/s: Atlas Global Trading FZC, 
3410 HDS Tower, Cluster “F”, 
Jumeirah Lakes Tower, P.O. Box 103 527, Dubai, UAE.</p>
</div>
</div>

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
<div class="socila-links">
<h4>Social Media</h4>
<ul>
<li><a href="https://www.linkedin.com/company/waycoolfoods/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
</ul>
</div>
</div>

</div>
</div>
</section>

<section class="section copy-rte text-center">
<div class="container">
<div class="row"> 

<div class="col-12"> 

<p>Copyright @ <script language="javascript">
n=new Date();
se=n.getFullYear();
document.write(se);
</script>, WayCool Foods and Products Pvt. Ltd. | All rights Reserved. Design by <a href="https://www.pixel-studios.com/" target="_blank">Pixel Studios</a></p>

</div>


</div>
</div>
</section>


<div id="myModal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
  <div class="banner-form">
  
  <form onSubmit="return valid_chk1()" name="form1" method="post" action="<?php echo BASE_URL;?>thanks-enquiry"  id="form1">

<button class="xclose" type="button" data-dismiss="modal" aria-hidden="true">×</button>
<div class="tit-bn">
<h3>Quick Enquiry</h3>
</div>
<div class="form-group">
<input placeholder="Name" class="form-control" name="fname" id="fname" type="text">
 </div>  

<div class="form-group">
<input placeholder="Email ID*" class="form-control" name="femail" id="femail"   type="text">
 </div> 

<div class="form-group">
<input placeholder="Mobile Number*" class="form-control"  name="fmobile" id="fmobile"   type="tel" onKeyPress="return CheckNumericKeyInfo(event.keyCode, event.which);" maxlength="10" >
 </div> 

<div class="form-group">
<select class="form-control " id="seek" name="seek">
	<option value="">Select the Product</option>
    <option value="Fresheys">Freshey's</option>
    <option value="Kwik Kitchen">Kwik Kitchen</option>
    <option value="Freshloc">Freshloc</option>
    <option value="Fresh F&V">Fresh F & V</option>
</select>
 </div> 
 
 <div class="form-group">
<textarea name="msg" id="msg" placeholder="Message" class="form-control" ></textarea>
 </div> 

<div class="form-group filed-rgt">
<input value="Submit" name="submit" id="submit" type="submit">
</div>
</form>

<script language="JavaScript">
function valid_chk1()
{

if(document.form1.fname.value=="")
{
alert("Please enter your name")
document.form1.fname.focus()
return false;
}

if(document.form1.femail.value=="")
{
alert("Please enter your E-mail ID")
document.form1.femail.focus()
return false;
}

if (document.form1.femail.value.match(/^\s+[a-zA-Z0-9]+/)!=null || (document.form1.femail.value.match(/[a-zA-Z0-9]+/)==null || document.form1.femail.value.match(/[a-zA-Z0-9]+\@[a-zA-Z0-9\-]+(\.([a-zA-Z0-9]{2}|[a-zA-Z0-9]{3}))+$/)==null))
{
alert("Please enter your valid E-mail ID")
document.form1.femail.focus()
return false;
}

if(document.form1.fmobile.value=="")
{
alert("Please enter your Mobile number")
document.form1.fmobile.focus()
return false;
}	
	
if(document.form1.seek.value=="")
{
alert("Please Select the Product")
document.form1.seek.focus()
return false;
}

return true;
}

function CheckNumericKeyInfo($char, $mozChar) {
		if($mozChar != null) { // Look for a Mozilla-compatible browser
			if(($mozChar >= 48 && $mozChar <= 57) || $mozChar == 0 || $mozChar == 45 || $char ==
			8 || $mozChar == 13) $RetVal = true;
			else {
			$RetVal = false;
			//alert('Please enter a numeric value.');
			}
		}
		else { // Must be an IE-compatible Browser
			if(($char >= 48 && $char <= 57) || ($char == 13)|| ($char == 45)) $RetVal = true;
			else {
			$RetVal = false;
			//alert('Please enter a numeric value.');
				}
		}
		return $RetVal;
}
</script>

</div>
            </div>
        </div>
    </div>














