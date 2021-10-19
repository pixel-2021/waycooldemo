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

<div class="col-lg-12">
<div class="clnts-ster">

<div class="">
<div class="comnn-title text-center wow fadeInUp" data-wow-duration="1s">
<h3><span> Success </span> Thank You For spending <br> your valuable time.  </h3>
<br>
</div>
</div>  

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">

<div class="conta-details infra text-center"> 
<h5>We will reach you soon ...</h5>

<div class="text-center">
<a class="cmn-knw" href="<?php echo BASE_URL;?>">Go To Home</a>
</div>

</div> 


<?php

$aname = $_POST['aname'];
$aemail = $_POST['aemail'];
$aphone = $_POST['aphone'];
$amessage = $_POST['amessage'];

	
if (($aname != '')&&($aemail != '')) {	


$to  = 'support@waycool.in';

	$subject = 'Contact Enquiry';

$message = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #f5f8fa;">
<tbody>
  <tr>
    <td style="padding: 30px;"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #fff;">
      <tbody>
        <tr>
          <td align="center" style="background: #02466f; padding: 15px; " ><img src="https://www.waycool.in/static/images/logo.png" width="192" height="54"/></td>
        </tr>
        <tr>
          <td align="center" style="padding:20px; color: #8e8e8e; font-family:Helvetica, Arial; font-size:22px;">New submission on<br><b>WayCool  </b><br>
            &quot;Website Online Enquiry&quot;</td>
        </tr>
        <tr>
          <td style="padding: 20px; "><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td height="30" style="font-size: 16px; font-family:Helvetica, Arial; color: #929292; " >Name</td>
                </tr>
              <tr>
                <td height="30" style="font-size: 16px; font-family:Helvetica, Arial; color: #454545; " >'.$aname.'</td>
                </tr>
              <tr>
                <td height="20" style="font-size: 16px; font-family:Helvetica, Arial; color: #454545; " >&nbsp;</td>
                </tr>
               
              <tr>
                <td height="30" style="font-size: 16px; font-family:Helvetica, Arial; color: #929292; " >Email</td>
                </tr>
              <tr>
                <td height="30" style="font-size: 16px; font-family:Helvetica, Arial; color: #454545; " >'.$aemail.'</td>
                </tr>
              <tr>
                <td height="20" style="font-size: 16px; font-family:Helvetica, Arial; color: #454545; " >&nbsp;</td>
                </tr>
              <tr>
                <td height="30" style="font-size: 16px; font-family:Helvetica, Arial; color: #929292; " >Phone</td>
                </tr>
              <tr>
                <td height="30" style="font-size: 16px; font-family:Helvetica, Arial; color: #454545; " >'.$aphone.'</td>
                </tr>
              <tr>
                <td height="20" style="font-size: 16px; font-family:Helvetica, Arial; color: #454545; " >&nbsp;</td>
                </tr>
               
              <tr>
                <td height="30" style="font-size: 16px; font-family:Helvetica, Arial; color: #929292; " >Message</td>
                </tr>
              <tr>
                <td height="30" style="font-size: 16px; font-family:Helvetica, Arial; color: #454545; " >'.$amessage.'</td>
                </tr>
              <tr>
                <td height="20" style="font-size: 16px; font-family:Helvetica, Arial; color: #454545; " >&nbsp;</td>
                </tr>
               
              </tbody>
            </table></td>
        </tr>
        </tbody>
    </table></td>
  </tr>
</tbody>
</table>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From:'.$aemail. "\r\n";
//$headers .= 'From: manu020286@gmail.com'. "\r\n";
//$headers .= 'From: support@waycool.in'. "\r\n";
$headers .= 'Bcc: websupport@pixel-studios.com, behin.pixel@gmail.com' . "\r\n";

if(mail($to, $subject, $message, $headers)){

        // the echo goes back to the ajax, so the user can know if everything is ok
       // echo "success";
    } else {
      // echo "error";
    }

//mail($to, $subject, $message, $headers);
}
?>



</div>

</div>
</div>



</div>
</div>
</section>  

<?php include ('includes/footer.php') ?>
<?php include ('includes/script.php') ?> 















