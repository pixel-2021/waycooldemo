<?php 
$docrooter=$_SERVER['DOCUMENT_ROOT'].'/ER/';
$docroot=$_SERVER['DOCUMENT_ROOT'].'/ER/eradmin/';
include_once($docroot."common/config_db.php");
include_once($docroot."common/common.class.php");
require_once $docroot.'bulkmail/PHPMailerAutoload.php';

 $str_all="select a.*,date_format(a.ModifiedDate,'%d %M %Y %H:%i') as created from er_sendmail a  where a.IsActive=1 and a.flag=0 and NOW() > a.ModifiedDate " ;	
	$resstr = $db->get_rsltset($str_all); 

	foreach($resstr as $list){
	
 	$str_all="select a.*,date_format(a.ModifiedDate,'%d %M %Y %H:%i') as created, b.template_name,c.emailids as emailids, u.user_firstname from er_sendmail a left join er_templates b on b.templateID=a.templateid inner join er_sendmaillist c on c.sendmailid=a.sendmailID and c.flag=0 inner join er_users u on u.user_email=c.emailids where a.IsActive=1 and a.flag=0 and c.sendmailid='".$list['sendmailID']."' and NOW() > a.ModifiedDate " ;	
	$res = $db->get_rsltset($str_all); 

		foreach($res as $listqry){
		
					$to=	$listqry['emailids'];
					$subject =$listqry['subject'];
					$message=$listqry['mailcontent'];
					$name=$listqry['user_firstname'];
					
					$body='<table style="width: 600px; margin-left: 400px; padding: 5px;">
<tr>
<td height="3">'.$message.'</td>
</tr>
</table>';


$mail = new PHPMailer(true);
$mail->CharSet = 'utf-8';
ini_set('default_charset', 'UTF-8');

/*$mail->isSMTP();
$mail->SMTPDebug  = 2;
$mail->Host       = "gw-eur1.smtp.philips.com";
$mail->Port       = "25";
$mail->SMTPAuth   = false;
*///justin.devakumar@philips.com
//$mail->addReplyTo($frm_mail, $frm_name);

$mail->isSMTP();
$mail->SMTPDebug  = 2;
$mail->Host       = "smtp.rediffmailpro.com";
$mail->Port       = "587";
$mail->SMTPSecure = "none";
$mail->SMTPAuth   = true;
$mail->Username   = "kannan.pandian@pixel-studios.com";
$mail->Password   = "kannan@321";
$mail->setFrom("kannan.pandian@pixel-studios.com", "Mail Blaster Test");

/*foreach ($get_email as $list){
$mail->addAddress($list->email, $list->fname);
}
*/
$mail->addAddress($to, $name);
//$mail->addCC("kannan.pandian@pixel-studios.com");
$mail->Subject  = $subject;

$mail->msgHTML($body, dirname(__FILE__), true); //Create message bodies and embed images

 $imglist =$db->get_results("select * from ".tbl_mailfile." where  sendmailid = '".$list['sendmailID']."' order by CreatedDate desc ");	
	
																																						
	foreach($imglist as $iList){
									$imgpath=$docrooter.'uploads/mailattchments/'.$list['sendmailID'].'/'.$iList->pathname;	

									$name=$iList->name;
		       $mail->addAttachment($imgpath, $name); // optional name

	}
	
								$mail->smtpConnect([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    ]
]);

//send the message, check for errors
if (!$mail->send()) {
				$return = 0;
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {

$str_alludt="update er_sendmaillist  set flag=1 where IsActive=1 and flag=0 and sendmailid='".$list['sendmailID']."' and emailids='".$to."' " ;	
	$resudt = $db->insert($str_alludt); 
sleep(2);
    echo "Mailer Sent";
}


		
}
$str_allupt="update er_sendmail set flag=1 where sendmailID='".$list['sendmailID']."' and IsActive=1 and flag=0 and NOW() > ModifiedDate " ;	
	$resupt = $db->insert($str_allupt); 

	}
	


?>