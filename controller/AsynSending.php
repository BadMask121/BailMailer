    <?php
    require dirname(__DIR__).'/vendor/bailMailer/autoload.php';
    class AsynSending extends Thread{

        //declare and init threadid and sleepTime 
        private $sleepTime      = 0;
        private $mail_list      = MAIL_LIST;
        private $sender         = null;
        private $std;
        private $incrementor    = 0;
        private $mail           = null;
        private $sent = 0 ;
    


        function __construct($sender,$std,$sleepTime){
            $this->sleepTime = $sleepTime;
            $this->sender = $sender;
            $this->std = $std;
            $selectedSMTP = $this->sender[$this->incrementor];
            $this->mail = new BM121(array($selectedSMTP));              
        }
        
        public function run(){
            $this->synchronized(function($thread){
                
                Utility::print_f_A("\n\n\n\t\t\tWelcome To BailMailer",2,200,100);
                Utility::print_f_A("\t\t\t".Utility::$signature,2,210,100);

                $file = file(dirname(__DIR__) . $this->mail_list, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $file = filter_var_array($file, FILTER_VALIDATE_EMAIL);



                
                /**
                 * precedented variables for loops
                 */
                $totalsize         = sizeof($file);
                $delimiter_default = 500;
                $delimiter         = 500;
                $selectedSMTP      = null;
                $tryed             = 1;
                $bcc_incre         = 0;
                $cc_incre          = 0;
                $length     = count($this->sender) - 1;


                  Utility::print_f("Sending Mail to ".$totalsize." Emails \n",42);                
                  for ($j=0; $j < $totalsize ; ++$j) {

                    $selectedSMTP = $this->sender[$this->incrementor];
                      // assigning string value of email list to email variable
                      $email = $file[$j]; 
                      
                                Utility::print_f("\n--------------------Bail Mailer-----------------------",42);
                                            echo "\nSending email to : " .$email . " using Thread Id : " .$this->getCurrentThreadId() ." \n";
                                            echo "using smtp: ". $selectedSMTP[HOST] ."\n";      
                                try{
                                            echo "\nFrom: " .$selectedSMTP[USERNAME] ."\n";
                                            
                                            /**
                                             *  Add Blind Carbon Copy sending if set
                                             */
                                            if(SEND_AS_BCC){
                                                $bccArray = array_slice($file,$bcc_incre, BCC_LIMIT );
                                                $bcc_incre += BCC_LIMIT;
                                                $j += $bcc_incre + 1;

                                                $this->mail->SendAsBcc($bccArray);
                                                if($bcc_incre >= $totalsize - 1){exit;}
                                            }

                                            /**
                                             *  Add Carbon Copy sending if set
                                             */

                                            if(SEND_AS_CC){
                                                $ccArray = array_slice($file,$cc_incre, CC_LIMIT );
                                                $cc_incre += CC_LIMIT;
                                                $j += $cc_incre + 1;

                                                $this->mail->SendAsCC($ccArray);
                                                if($cc_incre >= $totalsize - 1){exit;}
                                            }

                                        
                                        if(!$this->mail->isValidEmail(trim(strtolower($email)))){
                                            echo "Mail not sent : invalid email or email doesnt exist\n";
                                        }else
                                                if( $this->mail->sendMail(trim(strtolower($email)))){
                                                    $this->sent += 1;
                                                    echo "Email Sent to: " .$email ."\n";
                                                    echo "Total Number Sent: " . $this->sent ."\n";
                                    Utility::print_f("----------------------Bail Mailer------------------------\n",44);
                                        }else{
                                            /**
                                             * 
                                             * Logic here
                                             * if mail not sent is caused by invalid or non existing mail
                                             *  
                                             * if @var $this->mail->emailValid == false 
                                             * do Absolutely nothing
                                             * else if == true
                                             * @var take our email to previous valid email  {$j -= 1} and retry the connection
                                             */
                                            {
                                            echo "Mail not sent due to smtp connection\n";
                                                $j -= 1;
                                                if($tryed <= SMTP_RETRY ){
                                                    echo "Reconnecting SMTP " .$tryed;
                                                    $tryed       += 1;
                                                }else{ 
                                                    $tryed        = 1;
                                                    $this->incrementor += 1;
                                                    $this->switchConnection();
                                                }
                                                
                                                if($length + 1 == $this->incrementor){
                                                    echo "Error Sending Message : Please Check Smtp Config";
                                                    exit;
                                                }

                                            }
                                        }


                                        if($j == $delimiter ){
                                            $delimiter      += $delimiter_default;
                                            $this->incrementor    += 1;
                                            
                                            if($length + 1 == $this->incrementor){
                                                $this->incrementor = 0;
                                            }

                                            $this->switchConnection();
                                            echo "SWITCHING SMTP SERVER !!";
                                        }

                                        sleep($this->sleepTime);
                                        if(($j >= $totalsize -1) && ($delimiter >= $totalsize - 1) ){exit;}

                                }catch( \Exception $e){
                                            echo $e->getMessage();
                                }


                            }
                    Utility::print_f("\nSent Mail to ".$this->sent." Emails \n",42);                
                
            
            },$this->std);

        }

        public function switchConnection(){
                $selectedSMTP = $this->sender[$this->incrementor];
                $this->mail = new BM121(array($selectedSMTP));
        }

        

    }
    
    