<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   /**
     * Send_mail class is initiating phpmailer
     */
class Send_mail{
    function __construct() {
		 require './application/libraries/phpmailer/class.phpmailer.php';
    }
	
   /**
     * This function is used to send mail
     * @return true
     * @Param : $sub - Subject of mail
     * @Param : $body - mail body contant
     * @Param : $email - To email address
     * @Param : $smtp - smtp setting array
     */
	function email($sub, $body, $email, $smtp){
        $SMTP_EMAIL = isset($smtp['SMTP_EMAIL'])?$smtp['SMTP_EMAIL']:'';
        $HOST = isset($smtp['HOST']) ? $smtp['HOST'] : '';
        $PORT = isset($smtp['PORT']) ? $smtp['PORT'] : '';
        $SMTP_SECURE = isset($smtp['SMTP_SECURE']) ? $smtp['SMTP_SECURE'] :'';
        $SMTP_PASSWORD = isset($smtp['SMTP_PASSWORD']) ? $smtp['SMTP_PASSWORD'] :''; 
        $EmailFromName = isset($smtp['company_name']) ? $smtp['company_name'] :''; 
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 1;
        $mail->Debugoutput = 'text';
        //$mail->Host = $HOST;
        //$mail->Port = $PORT;
        //$mail->SMTPSecure = $SMTP_SECURE;
        //$mail->SMTPAuth = true;
        //$mail->Username = $SMTP_EMAIL;
        //$mail->Password = $SMTP_PASSWORD;
        //$mail->setFrom($SMTP_EMAIL, $EmailFromName);
        $mail->setFrom('pigeonsportsclock@gmail.com','Admin');

        $mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "pigeonsportsclock@gmail.com";  // GMAIL username
$mail->Password   = "SmartWork@123";            // GMAIL password


        //$mail->addReplyTo($SMTP_EMAIL, '');
        $mail->addReplyTo('pigeonsportsclock@gmail.com', '');
        $mail->addAddress("$email");
        $mail->Subject = $sub;
        $mail->msgHTML($body);
        $mail->AltBody = 'This is a confirmation message ';
        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {                
            return true;
        }
    }   
}
?>