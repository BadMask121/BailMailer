<?php 
    require dirname(__DIR__) . "/tools/Utility.php";
    class Install {

        function __construct(){
            Utility::print_f_A("\n\n\n\t\t\tWelcome To BailMailer",2,200,100);
            Utility::print_f_A("\t\t\t".Utility::$signature,2,210,100);
            $this->init();
        }

        public static function run(){
                switch (Utility::getOs()) {
                    
                    case 'Ubuntu':
                       return self::installUbuntu();
                        break;
                    case 'Centos':    
                        return self::installCentOS();
                        break;
                    default:
                        # code...
                        break;
                }
                return false;
        }
        
        private function init(){
            echo "
                \n Initiating installation protocols on your system ".Utility::getOs()." ...
            \n";
        }
        private function installUbuntu(){
            self::dispatcher(array(
                'chmod +x ./install.sh',
                'sudo ./install.sh'
            ));
        }


        private function installCentOS(){
           self::dispatcher(array(
                'chmod +x ./install.sh',
                'sudo ./install.sh'
            ));
        }

        private function dispatcher(array $commands){
            $commander = $commands;
            foreach ($commander as $value) {
                echo Utility::cmd($value);
                sleep(2);
            }
        }

        
    }