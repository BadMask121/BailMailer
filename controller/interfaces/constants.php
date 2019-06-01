<?php 
 
 /**
  * These are core needed constants values that shouldnt be changed unless you know what you are doing 
  * enjoy :)
  * @author: BadAss121
  * 
  */














 
   const randomIp = 1;
 
 
   const randomUserAgent = 2;
 
 
   const randomName = 3;

      //setting path location to our useragent file
   const USER_AGENT_FILE = "useragent.txt";

        
	  //set up variable constant @HOST variable for smtp host key
	  const HOST = "host";
	  


	  //set up variable constant @USERNAME variable for smtp username key
	  const USERNAME = "username";
	 


	  //set up variable constant @PASSWORD variable for smtp password key
	  const PASSWORD = "password";
	  


	  //set up variable constant @PORT variable for smtp port key
	  const PORT = "port";
	  
      
      const SMTP_SECURE = 983;


      //setting constant value for all our needed urls
       const URL = array(
            randomIp => "http://spys.me/proxy.txt",
            randomUserAgent => "https://raw.githubusercontent.com/cvandeplas/pystemon/master/user-agents.txt",
            randomName =>  "names.txt"
      );
      
      const CHAR_SET = array(
            "us-ascii",
            "utf-8",
            "utf-7",
            "IBM437",
            "x-ebcdic-uk-euro",
            "windows-1252",
            "iso-8859-2",
            "iso-8859-1",
            "ASCII"
      );     

      const ENCODING = array(
          'base64',
          '7bit',
          '8bit',
          'quoted-printable'
        );


?>