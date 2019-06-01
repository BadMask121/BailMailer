<?php
ob_start();
/**
	 * Main Engine For Bail Mailer
     * 
	 * @author BadAss121 <badass121@xabber.org>
	 * @version 1.1.0
	 * @category Mailer
	 * @copyright 2019 MIT
	 * @subpackage PHP 7.2 
	 * @subpackage PHPMailer 5.5
	 * 
	 * 
	 * 
	 * 	Features :
	 * 	Multi Threading
     *  Auto PunnyCode for Email Address
	 *  Multiple SMTP
	 * 	Random Dynamic Ip
	 * 	Random FromName
	 * 	Random FromMail
	 *	Random Subject 
	 * 	Random Content-Transfer-Encoding
	 * 	Random Charset
	 *	Random Dynamic UserAgent
	 *  Fully Undetectable
     * 	Auto Email Validation
	 * 	Auto Email Exist Checker
	 * 	Option for BCC and CC
	 *  Dynamic Letter Words Replacement
	 *  Support Random Attachment Name
	 * 	Support sending to (.pdf,.docx,.txt) etc.
	 */
    
    require 'class.phpmailer.php';
    require 'class.smtp.php';
    include_once 'class.verifyEmail.php';
//start class of BM121 mailer
class BM121 {




    // mail object used PHPMailer object
    private $mail ;

    private $ip;

    private $vmail = null;

    public $emailValid;


		

    //setting frommail to smtp email
    private $FromMail = null;
    
    //defining object ins __constructor
    function __construct(array $args){
        $this->mail = new PHPMailer;
   		$this->vmail = new verifyEmail();

        $this->mail->SMTPDebug = SMTP_DEBUG;
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = SMTP_AUTH;
        $this->mail->SMTPKeepAlive = true;
        $this->mail->Timeout = SMTP_CONNECTION_TIMEOUT;      
        $this->ip = Utility::randomIp();  

  		$this->vmail->setStreamTimeoutWait(SMTP_CONNECTION_TIMEOUT);
		$this->vmail->Debug= FALSE;
        $this->vmail->Debugoutput= 'html';

        foreach ($args as $key ) {
            $this->FromMail = $key[USERNAME];

            $this->mail->Host = $key[HOST];
            $this->mail->Username = $key[USERNAME];
            $this->mail->Password = $key[PASSWORD];
            $this->mail->Port = $key[PORT];
            $this->mail->SMTPSecure = $key[SMTP_SECURE];
        continue;
        }

    }

    //mail sending function
    public function sendMail($toAddress){
        /**
         *  @var body get file from settings  
         *  @var attachment get attachment file from settings
         *  @var fromMail get FromMail email from settings
         *  @var fromName getFromName from settings
         *  @var ip get Random Ip address using Utility @method randomIp()
        */
        
        $body  = Utility::SantizeMessage(SUBJECT_MESSAGE_FILE,
                 WORDS(),
                 REPLACEMENT($toAddress));

        $attachment = ATTACHMENT_FILE != "" ? ATTACHMENT_FILE : "" ;

        
        
        $fromMail = FROM_MAIL != "" ? FROM_MAIL : $this->FromMail ;

        ALLOW_RANDOM_MAIL ? $randFromMail = Utility::randomFromMail() : $randFromMail = $fromMail;



        $fromName = getFromName();
        

        /**
         * sender details
         * Assign Sender Email
         * Assign Sender Name
         *
         */
        $this->mail->From =$fromMail;
        $this->mail->Sender = $fromMail;
        $this->mail->setFrom ($fromMail, $fromName);

        //address to ReplyTO   
        REPLY_TO !="" ?
            $this->mail->addReplyTo(REPLY_TO) :
            $this->mail->addReplyTo($fromMail);

        
        //Recipent details
        $this->mail->addAddress ($toAddress);

        /**
         * 
         * Add attachment if specified
         */
        if(!is_null($attachment) and file_exists($attachment))
        {$this->mail->addAttachment($attachment,Utility::RandString1(10));}
        
        /*
        * Adding custon headers for sending
        * X-Priority
        * User-Agent
        * Content-Transfer-Encoding:
        * X-Sender-IP:
        */
        
        
        
        /**
        *   generate random @var charset encoding for sending
        */
        $this->mail->CharSet = Utility::randomEncoding();
        
        $this->mail->ReturnPath = $fromMail;
        $this->mail->XMailer = ' ';
        $this->mail->Priority = PRIORITY;
        $this->mail->Encoding = Utility::randomTransferEncoding();
        $this->mail->addCustomHeader('List-Unsubscribe:'  .'<mailto:'.$fromMail.'>,' .'<http://google.com/unsubscribe.php?u=6546dfdg1ddkhpo9876>');
        $this->mail->addCustomHeader('X-Sender-IP:' . $this->ip );
        ($useragent = Utility::randomUserAgent()) == null ? false : $this->mail->addCustomHeader('User-Agent: ' . $useragent);
        

        //Send HTML or Plain Text email        
        SENDING_HTML_MESSAGE ? $this->mail->isHTML(true) : $this->mail->isHTML(false);

        /**
         * 
         *  Set sending subject and mail message along with all the header
         *  needed
         *  
         *  Set Body text/html
         *  Set AltBody text/plain
         */
        SUBJECT != "" ? $this->mail->Subject = SUBJECT  : $this->mail->Subject = Utility::randomSubject(); 
        
        

        $this->mail->Body = $body;        
        $ClearText = preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($body))) );
        $this->mail->AltBody = $ClearText;



        /**
         * Bind randomIp to sending SMTPOptions
         * for better delivery 
         */
        // if(($this->ip) !=  null ){
        //     $this->mail->SMTPOptions = array(
        //         'timeout'=> SMTP_CONNECTION_TIMEOUT,
        //         'socket' => array(
        //         'bindto' => "$this->ip:0",
        //         ),
        //     );
        // }else{throw new Exception("Error Processing Request for randomIp", 1); return false;}
  
        
    
        /**
         * Send mail and doCleanup on all recipients else @return false
         */
        if(!$this->mail->send()){
            return false;
        }else{
            $this->mail->ClearAllRecipients();
            $this->mail->ClearAttachments();            
            return true;
        }

        /** 
         * 
         *End @method sendMail(@param $toAddress)
        */
        return false;
    }

    public function SendAsBcc(array $emails , $name = ''){
        foreach ($emails as $key => $value) {
            if($this->isValidEmail($value)){
                if(!$this->mail->addBCC($value,$name)){
                    echo "Error Happened \n";    
                }else{echo $value." bcc added \n";}
            }else{
                echo $email . " Bcc Email invalid \n";
            }
        }
    }
    
    public function SendAsCC(array $emails , $name = ''){
        foreach ($emails as $key => $value) {
            $this->mail->addCC($value,$name);
        }
    }

    public function isValidEmail($toAddress){
        $this->vmail->setEmailFrom($toAddress);
        
        if ($this->vmail->check($toAddress)) {
            return true;
		} elseif (verifyEmail::validate($toAddress)) {
            return false;
		} else {
            return false;
        }

        return false;
    }
    public function getBccAddresses(){
        return $this->mail->getBccAddresses();
    }

}
?>