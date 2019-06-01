<?php
ob_start();

//require our neccessary Class Store house
require 'vendor/bailMailer/autoload.php';

//start class of BM121 mailer
class Main {

    //defining our construtor
    function __construct(){

            if (php_sapi_name() == 'cli') {
            $args = $_SERVER['argv'];
        } else {
            parse_str($_SERVER['QUERY_STRING'], $args);
        }

            if(($args[1] == "cli")){
                
            $check_pthread = class_exists('Thread');
            $check_phpCompatibilty = PHP_ZTS;

            if($check_pthread == $check_phpCompatibilty){                
                    $key = DataFactory::get('BM121',array( smtpHost(),new stdClass()));
                    $key->start() && $key->join();
            }else{
                DataFactory::get('Install')::run();
            }

        }else{
            echo "Please pass a \"cli\" as argument ";
        }
    }
}
return new Main;