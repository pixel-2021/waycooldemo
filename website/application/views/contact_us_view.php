<?php include ('includes/style.php') ?>

<body>

<?php include ('includes/header.php') ?>


<div id="video-carousel" class="carousel slide carousel-fade" data-ride="carousel">
 
        <div class="carousel-inner products" role="listbox">
		
            <div class="carousel-item active">
				<div class="banner-layers">
				<img class="ban-img" src="<?php echo BASE_URL;?>static/images/inner-1.jpg" alt="" /> 
                </div>
            </div>  
 
 
        </div>
 
</div>

<section class="section clients-testis cnt-estis section-top-btm text-left">
<div class="container">
<div class="row">

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<div class="clnts-ster">

<div class="">
<div class="comnn-title text-left wow fadeInUp" data-wow-duration="1s">
<h3><span> Contact Us </span> Waycool is  <br> Listening </h3>
<br>
</div>
</div>  

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">

<div class="conta-details infra"> 

<div class="tots-cnt">

<p class="addr">
<img src="<?php echo BASE_URL;?>static/images/loc.png" alt="Waycool" /><span> India Corporate Office </span> 
<b>Waycool Foods and Products Pvt. Ltd,</b><br>
Aurbis Business Park, Survey No. 58, 7, Outer Ring Rd,<br> 
Devarabisanahalli, Bellandur, Bengaluru, Karnataka, India 560103.</p> 

<p class="callr"> <img src="<?php echo BASE_URL;?>static/images/call.png" alt="Waycool" /> <strong> Call us </strong> <br> +91 95001 68299 </p>
 <br>
 <p class="smsr br-tm"> <img src="<?php echo BASE_URL;?>static/images/sms.png" alt="Waycool" /> <strong> E-mail </strong> <br> <a href="mailto: support@waycool.in" target="_blank"> support@waycool.in </a>  </p> 
<p class="addr">
<img src="<?php echo BASE_URL;?>static/images/loc.png" alt="Waycool" /><span> Dubai Office </span> 
<b>Waycool Foods,</b><br>
C/O  M/S: Atlas Global Trading FZC,<br>
3410 HDS Tower, Cluster “F” , <br>
Jumeirah Lakes Tower, P.O. Box 103 527, Dubai, UAE.</p> 
 
<p class="callr"> <img src="<?php echo BASE_URL;?>static/images/call.png" alt="Waycool" /> <strong> Call us </strong> <br>+91 9715653 33635 </p>
 <br>
 <p class="smsr"> <img src="<?php echo BASE_URL;?>static/images/sms.png" alt="Waycool" /> <strong> E-mail </strong> <br> <a href="mailto: international.business@waycool.in" target="_blank"> international.business@waycool.in </a>  </p> 
 
</div>
</div> 

</div>

</div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<div class="cnts-ster">

<div class="contes">

<div class="">
<div class="comnn-title text-left wow fadeInUp" data-wow-duration="1s">
<h3><span> Reach Us </span> We Would Love <br> To Help You </h3><br>
<div class="undr-hdng text-left wow fadeInUp" data-wow-duration="1.5s">
Please email your questions/feedback to us and we shall get back<br>
to you as soon as possible. You can also contact us at our office address.
 
</div> <br>
</div>
</div> 
	
<div class="req-form">
	
<form onSubmit="return valid_chk()" name="form" method="post" action=""  id="form">

<div class="frm-fields row clearfix">
    
<div class="col-lg-12 col-md-12 col-sm-12">
	
<div class="form-data">
<input class="input100" type="text" name="aname" id="aname">
<span class="focus-input100" data-placeholder="Name"></span>
</div>
 
<div class="form-data">
<input class="input100" type="text" name="aphone" id="aphone" onkeypress="return CheckNumericKeyInfo(event.keyCode, event.which)";  maxlength="10"> 
<span class="focus-input100" data-placeholder="Mobile Number"></span>
</div>  
 
<div class="form-data">
<input class="input100" type="text" name="aemail" id="aemail">
<span class="focus-input100" data-placeholder="Email Address"></span>	
</div>
 
<div class="form-data">
<input class="input100" type="text" name="amessage" id="amessage">
<span class="focus-input100" data-placeholder="Message"></span>
</div> 
	
<div class="form-data sbm">
<input type="submit" name="submit" value="Send Now">
</div>
	
</div>
   
</div>	

</form>

<script language="JavaScript">
function valid_chk()
{


if(document.form.aname.value=="")
{
alert("Please enter your name")
document.form.aname.focus()
return false;
}

if(document.form.aphone.value=="")
{
alert("Please enter your Mobile number")
document.form.aphone.focus()
return false;
}

if(document.form.aemail.value=="")
{
alert("Please enter your E-mail ID")
document.form.aemail.focus()
return false;
}

if (document.form.aemail.value.match(/^\s+[a-zA-Z0-9]+/)!=null || (document.form.aemail.value.match(/[a-zA-Z0-9]+/)==null || document.form.aemail.value.match(/[a-zA-Z0-9]+\@[a-zA-Z0-9\-]+(\.([a-zA-Z0-9]{2}|[a-zA-Z0-9]{3}))+$/)==null))
{
alert("Please enter your valid E-mail ID")
document.form.aemail.focus()
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

</div>
</div>
</section>  

<?php include ('includes/footer.php') ?>
<?php include ('includes/script.php') ?> 















