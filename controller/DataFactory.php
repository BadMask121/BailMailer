<?php
class DataFactory {

    public static function get($classname, array $args =null){
        switch ($classname) {
            case 'Main':
                return new Main();
                 break;
            case 'BM121':
                return new AsynSending($args[0],$args[1],SLEEP_TIME);               
                break;
            case 'BM121_CLASS':
                return new BM121($args) ;  
            case 'Install':
               return new Install();
                break;                
            default:
                return new $classname;
                break;
        }
    }
}


?>
