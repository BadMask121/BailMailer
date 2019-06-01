<?php


	/**
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
	 *  Multiple SMTP
	 *  Auto PunnyCode for Email Address
	 * 	Random Dynamic Ip
	 * 	Random FromName
	 * 	Random FromMail
	 *	Random Subject 
	 * 	Random Content-Transfer-Encoding
	 * 	Random Charset
	 *	Random Dynamic UserAgent
	 *  Fully Undetectable
	 *  Dynamic Letter Words Replacement
	 *  Auto Email Validation
	 * 	Auto Email Exist Checker
	 * 	Option for BCC and CC
	 *  Support Random Attachment Name
	 * 	Support sending to (.pdf,.docx,.txt) etc.
	 */
	
	require_once dirname(__DIR__) . "/tools/Utility.php";
		
    //login signature
    $signature = "                                                                    
			BBBBBBBBBBBBBBBBB   MMMMMMMM               MMMMMMMM  1111111    222222222222222      1111111   
			B::::::::::::::::B  M:::::::M             M:::::::M 1::::::1   2:::::::::::::::22   1::::::1   
			B::::::BBBBBB:::::B M::::::::M           M::::::::M1:::::::1   2::::::222222:::::2 1:::::::1   
			BB:::::B     B:::::BM:::::::::M         M:::::::::M111:::::1   2222222     2:::::2 111:::::1   
				B::::B     B:::::BM::::::::::M       M::::::::::M   1::::1               2:::::2    1::::1   
				B::::B     B:::::BM:::::::::::M     M:::::::::::M   1::::1               2:::::2    1::::1   
				B::::BBBBBB:::::B M:::::::M::::M   M::::M:::::::M   1::::1            2222::::2     1::::1   
				B:::::::::::::BB  M::::::M M::::M M::::M M::::::M   1::::l       22222::::::22      1::::l   
				B::::BBBBBB:::::B M::::::M  M::::M::::M  M::::::M   1::::l     22::::::::222        1::::l   
				B::::B     B:::::BM::::::M   M:::::::M   M::::::M   1::::l    2:::::22222           1::::l   
				B::::B     B:::::BM::::::M    M:::::M    M::::::M   1::::l   2:::::2                1::::l   
				B::::B     B:::::BM::::::M     MMMMM     M::::::M   1::::l   2:::::2                1::::l   
			BB:::::BBBBBB::::::BM::::::M               M::::::M111::::::1112:::::2       222222111::::::111
			B:::::::::::::::::B M::::::M               M::::::M1::::::::::12::::::2222222:::::21::::::::::1
			B::::::::::::::::B  M::::::M               M::::::M1::::::::::12::::::::::::::::::21::::::::::1
			BBBBBBBBBBBBBBBBB   MMMMMMMM               MMMMMMMM11111111111122222222222222222222111111111111  
	  ";
		
		
		const VERSION = "BM121 1.1.2"; 
	  
		/**
		 *setting up smtp debug protocols int only
     * SMTP class debug output mode.
     * Debug output level.
     * Options:
     * * `0` No output
     * * `1` Commands
     * * `2` Data and commands
     * * `3` As 2 plus connection status
     * * `4` Low-level data output.
     *
     * @see SMTP::$do_debug
     *
     * @var int
     */ 
	  const SMTP_DEBUG = 1;

	
		//set the amount of times the smtp should try reconnection if failed
		const SMTP_RETRY = 4 ;


		const SENDING_HTML_MESSAGE = true;
		/**
		 * 
		 * setting connetion timeout for smtp connections
		 * @var SMTP_CONNECTION_TIMEOUT int  
		 */
		const SMTP_CONNECTION_TIMEOUT = 30;


		/**
		 * @var  ALLOW_RANDOM_MAIL @boolean 
		 * set
		 * 
		 * false = if you want to allow fromMail to be random 
		 */
	  const ALLOW_RANDOM_MAIL = false;
	  

		//set if allowing SMTP AUTHENTICATION
		const SMTP_AUTH = true;

	  //sleeptime for sending mail and multithreading sleeptime by default it is placed at 3 sec
	  const SLEEP_TIME = 5;

		// set default subject
		const SUBJECT = "Re: Loan Agreement";


	  //setting mail sending priority should be between 0-4  
	  const PRIORITY = 1;


		/**
		 * this @var SEND_AS_BCC set to true will allow emails to be set 
		 * with blindCarbonCopy sending
		 */
		//setting bcc
		const SEND_AS_BCC = false;

		//set limit bcc can send
		const BCC_LIMIT = 3;


		/**
		 * this @var SEND_AS_CC set to true will allow emails to be set 
		 * with blindCarbonCopy sending
		 */
		//setting bcc
		const SEND_AS_CC = false;

		//set limit bcc can send
		const CC_LIMIT = 10;




	  const FROM_NAME = "Abu Dhabi Capital Group";



	  const FROM_MAIL = "";


	  //specific the directory to your mail list in directory /tools/list/{MAIL_LIST_FILE}
	  const MAIL_LIST = "/tools/list/isrealleads.txt";


	  // Setting a reply to default email
	  const REPLY_TO = "loan@abudhabicapitalgroup.info";


	 /*
		 specify the directory to your letter in directory /tools/list/{LETTER_FILE}
		  Letter file for Html Message Body 
	 */
	 const SUBJECT_MESSAGE_FILE = "tools/letter/abuletter.html";


	 /**
		* add attachment location 
		*/
		const ATTACHMENT_FILE = "";


		/**
		 * 
		 * @var const WORDS match words in your letter and replace 
		 * them with @method  REPLACEMENT()
		 * list values of @var const WORDS must have the same lenght of @method REPLACEMENT()
		 * 
		 */
		// const WORDS = array();

		function WORDS(){

			return [
				'##fromname##','##to##','##url##','##message##','##accesscode##','\n'
			];
		}
		function REPLACEMENT($toAddress =""){

			return [
				''.getFromName().'',
				''.$toAddress.'',
				'https://bit.ly/2IEZWEx',
				'Please Review and Sign : doc' .Utility::RandString1(10).'.pdf',
				''.strtoupper(Utility::RandString1(35)).'',
				'<br/>'
			];
		}

		/**
		 * End
		 */

	  // smtpHost setting up for multiple smtp host sending
	  if(!function_exists('smtpHost')){

					function smtpHost(){
					

					/* returning array key must be incrementally places for diffrent smtp relays
						adding multiple smtp server you need to place a constant key and assign to
						the value example:
							HOST  	 => "mail.trustedmail.xyz",
							USERNAME => "abuse@mail.trustedmail.xyz",
							PASSWORD => "wondery2k",
							PORT 	 => 587
							SMTP_SECURE => 'tls'
							*/
							return [
							

										0 => array(
											HOST  	 	=> "smtp.zoho.com",
											USERNAME 	=> "no-reply-secure@trustedmail.xyz",
											PASSWORD 	=> "Wondery@2k",
											PORT 	 	=> 587,
											SMTP_SECURE => 'tls'
										),
										1 => array(
											HOST  	 	=> "smtp.zoho.eu",
											USERNAME 	=> "loan@abudhabicapitalgroup.info",
										 	PASSWORD 	=> "Wondery@2k",
										 	PORT 	 	=> 587,
											SMTP_SECURE => 'tls'
									 ),
										 2 => array(
											HOST  	 	=> "smtp.zoho.eu",
											USERNAME 	=> "investment@abudhabicapitalgroup.info",
											PASSWORD 	=> "Wondery@2k",
									
	PORT 	 	=> 587,
										 	SMTP_SECURE => 'tls'
										 ),
										3 => array(
												HOST  	 	=> "smtp.zoho.com",
											USERNAME 	=> "client-mail@trustedmail.xyz",
											PASSWORD 	=> "Wondery@2k",
											PORT 	 	=> 587,
											SMTP_SECURE => 'tls'
										),
										4 => array(
											HOST  	 	=> "smtp.zoho.com",
											USERNAME 	=> "bnywvfttlovnzyvzdhdh@trustedmail.xyz",
											PASSWORD 	=> "Wondery@2k",
											PORT 	 	=> 587,
											SMTP_SECURE => 'tls'										
										),
										5 => array(
											HOST  	 	=> "smtp.zoho.com",
											USERNAME 	=> "private-concern@trustedmail.xyz",
											PASSWORD 	=> "Wondery@2k",
											PORT 	 	=> 587,
											SMTP_SECURE => 'tls'										
										),
										6 => array(
											HOST  	 	=> "smtp.zoho.com",
											USERNAME 	=> "noreply.security@trustedmail.xyz",
											PASSWORD 	=> "Wondery@2k",
											PORT 	 	=> 587,
											SMTP_SECURE => 'tls'										
										),
										7 => array(
											HOST  	 	=> "smtp.zoho.eu",
											USERNAME 	=> "sx57jvb4ih1eqlr@abudhabicapitalgroup.info",
											PASSWORD 	=> "Wondery@2k",
											PORT 	 	=> 587,
											SMTP_SECURE => 'tls'										
										),
										8 => array(
											HOST  	 	=> "smtp.zoho.eu",
											USERNAME 	=> "chief.finance@abudhabicapitalgroup.info",
											PASSWORD 	=> "Wondery@2k",
											PORT 	 	=> 587,
											SMTP_SECURE => 'tls'										
										)									];
											}
										}  
										
			 /*
		 Although we will be generating our fromName and fromMail randomly we need first to define
		 a default value for them
	 */

	 //default value for fromName
		function getFromName(){ return (FROM_NAME != "") ? FROM_NAME : Utility::randomFromName(); }

		
?>
