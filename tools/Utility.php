<?php
require_once dirname(__DIR__) . "/controller/interfaces/UtilityInt.php";
require_once dirname(__DIR__) . "/controller/interfaces/constants.php";

class Utility implements UtilityInt{

      public static $signature = "
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






      


    //store files data from url txt files 
    private $file = null;



    //parse and clean data from $file variable into $store
    private $store = array();

    








    public static function getOs($user_agent = null)
    {
        if(!isset($user_agent)) {
            $user_agent = self::getUserAgent();
        }

        // https://stackoverflow.com/questions/18070154/get-operating-system-info-with-php
        $os_array = [
            'windows_NT'                              =>  'Windows 10',
            'windows nt 6.3'                             =>  'Windows 8.1',
            'windows nt 6.2'                             =>  'Windows 8',
            'windows nt 6.1|windows nt 7.0'              =>  'Windows 7',
            'windows nt 6.0'                             =>  'Windows Vista',
            'windows nt 5.2'                             =>  'Windows Server 2003/XP x64',
            'windows nt 5.1'                             =>  'Windows XP',
            'windows xp'                                 =>  'Windows XP',
            'windows nt 5.0|windows nt5.1|windows 2000'  =>  'Windows 2000',
            'windows me'                                 =>  'Windows ME',
            'windows nt 4.0|winnt4.0'                    =>  'Windows NT',
            'windows ce'                                 =>  'Windows CE',
            'windows 98|win98'                           =>  'Windows 98',
            'windows 95|win95'                           =>  'Windows 95',
            'win16'                                      =>  'Windows 3.11',
            'mac os x 10.1[^0-9]'                        =>  'Mac OS X Puma',
            'macintosh|mac os x'                         =>  'Mac OS X',
            'mac_powerpc'                                =>  'Mac OS 9',
            'linux'                                      =>  'Linux',
            'ubuntu'                                     =>  'Linux - Ubuntu',
            'iphone'                                     =>  'iPhone',
            'ipod'                                       =>  'iPod',
            'ipad'                                       =>  'iPad',
            'android'                                    =>  'Android',
            'blackberry'                                 =>  'BlackBerry',
            'webos'                                      =>  'Mobile',

            '(media center pc).([0-9]{1,2}\.[0-9]{1,2})'=>'Windows Media Center',
            '(win)([0-9]{1,2}\.[0-9x]{1,2})'=>'Windows',
            '(win)([0-9]{2})'=>'Windows',
            '(windows)([0-9x]{2})'=>'Windows',

            // Doesn't seem like these are necessary...not totally sure though..
            //'(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'Windows NT',
            //'(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})'=>'Windows NT', // fix by bg

            'Win 9x 4.90'=>'Windows ME',
            '(windows)([0-9]{1,2}\.[0-9]{1,2})'=>'Windows',
            'win32'=>'Windows',
            '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})'=>'Java',
            '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}'=>'Solaris',
            'dos x86'=>'DOS',
            'Mac OS X'=>'Mac OS X',
            'Mac_PowerPC'=>'Macintosh PowerPC',
            '(mac|Macintosh)'=>'Mac OS',
            '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'SunOS',
            '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'BeOS',
            '(risc os)([0-9]{1,2}\.[0-9]{1,2})'=>'RISC OS',
            'unix'=>'Unix',
            'os/2'=>'OS/2',
            'freebsd'=>'FreeBSD',
            'openbsd'=>'OpenBSD',
            'netbsd'=>'NetBSD',
            'irix'=>'IRIX',
            'plan9'=>'Plan9',
            'osf'=>'OSF',
            'aix'=>'AIX',
            'GNU Hurd'=>'GNU Hurd',
            '(fedora)'=>'Fedora',
            '(kubuntu)'=>'Kubuntu',
            '(ubuntu)'=>'Ubuntu',
            '(debian)'=>'Debian',
            '(CentOS)'=>'CentOS',
            'fedora'=>'Fedora',
            'kubuntu'=>'Kubuntu',
            'ubuntu'=>'Ubuntu',
            'debian'=>'Debian',
            'CentOS'=>'CentOS',
            '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - Mandriva',
            '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - SUSE',
            '(Dropline)'=>'Linux - Slackware (Dropline GNOME)',
            '(ASPLinux)'=>'Linux - ASPLinux',
            '(Red Hat)'=>'Linux - Red Hat',
            // Loads of Linux machines will be detected as unix.
            // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
            //'X11'=>'Unix',
            '(linux)'=>'Linux',
            '(amigaos)([0-9]{1,2}\.[0-9]{1,2})'=>'AmigaOS',
            'amiga-aweb'=>'AmigaOS',
            'amiga'=>'Amiga',
            'AvantGo'=>'PalmOS',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})'=>'Linux',
            '([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3})'=>'Linux',
            '(webtv)/([0-9]{1,2}\.[0-9]{1,2})'=>'WebTV',
            'Dreamcast'=>'Dreamcast OS',
            'GetRight'=>'Windows',
            'go!zilla'=>'Windows',
            'gozilla'=>'Windows',
            'gulliver'=>'Windows',
            'ia archiver'=>'Windows',
            'NetPositive'=>'Windows',
            'mass downloader'=>'Windows',
            'microsoft'=>'Windows',
            'offline explorer'=>'Windows',
            'teleport'=>'Windows',
            'web downloader'=>'Windows',
            'webcapture'=>'Windows',
            'webcollage'=>'Windows',
            'webcopier'=>'Windows',
            'webstripper'=>'Windows',
            'webzip'=>'Windows',
            'wget'=>'Windows',
            'Java'=>'Unknown',
            'flashget'=>'Windows',

            // delete next line if the script show not the right OS
            //'(PHP)/([0-9]{1,2}.[0-9]{1,2})'=>'PHP',
            'MS FrontPage'=>'Windows',
            '(msproxy)/([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
            '(msie)([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
            'libwww-perl'=>'Unix',
            'UP.Browser'=>'Windows CE',
            'NetAnts'=>'Windows',
        ];

        // https://github.com/ahmad-sa3d/php-useragent/blob/master/core/user_agent.php
        $arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
        $arch = preg_match($arch_regex, $user_agent) ? '64' : '32';

        foreach ($os_array as $regex => $value) {
            if (preg_match('{\b('.$regex.')\b}i', $user_agent)) {
                return $value;
            }
        }

        return 'Unknown';
    }



    public static function cmd($command){
        return shell_exec($command);
    }


    public static function getIp(){}


    public static function getUserAgent(){
        $user_agent = null;
        if(is_null($user_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        }else if(is_null($user_agent) && isset($_SERVER['OS'])){
            $user_agent = $_SERVER['OS'];
        }else if(is_null($user_agent)){
            $user_agent = $_SERVER['DESKTOP_SESSION'];
        }
        return $user_agent;
    }




    public static function getRandNumber($start,$offset){
        return mt_rand($start,$offset);
    }

    public static function RandString1($randstr){ $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $str = ''; 
        for ($i = 0; 
        $i < $randstr; 
        $i++ ) 
        { 
            $pos = mt_rand(0, strlen($char)-1); 
            $str .= $char{$pos}; 
        } 
        return $str; 
    }

    public static function randomIp(){
            $data = file_get_contents( URL[randomIp], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if($data !== false){
                //for port add :[0-9]{1,5} at regex ending
                $ip = preg_match_all("/\b[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\b/",$data,$ips);
                $newip = array();
                
                for($i=1;$i < mt_rand(2,100); $i++){
                    unset($ips[0][$i]);
                    array_push($newip,$ips[0][$i+1]);   
                }

               $randIp = array_slice($newip,-2,1);
    
               return $randIp[0];
            }
            return null;
    }





    public static function randomUserAgent(){
        $dump = __DIR__.'/list/donottouch/'.USER_AGENT_FILE;
        $store = array();
        $url_fetched = false;
        
        if(file_exists($dump)){
            is_readable($dump) ? $file = self::readFileA($dump) : $file=null;
            $handle = fopen($dump,'a');
        }else{
            if(self::createWritableFile($dump)){
                $file = self::readFileA( URL[randomUserAgent]);
                $url_fetched = true;
            }
        }
        for ($i=0; $i < (sizeof($file) > 1000 ? 1000  : sizeof($file)); $i++) {
            if($url_fetched){
                $handle = fopen($dump,'a');
                fwrite($handle,$file[$i] ."\n");
            }
            array_push($store,$file[$i]);
        }
        for ($i=0; $i < mt_rand(1,sizeof($store)) ; $i++) { 
            unset($store[$i]);
        }
            $store = array_slice($store, 2,1);
            fclose($handle);

        return implode('',$store);
    }


    public static function createWritableFile($file){
       
    // Check if conf file exist.
    if (file_exists($file)) {
        // check if conf file is writable.
        return is_writable($file);
    }

    // Check if conf folder exist and try to create conf file.
    if(($handle = fopen($file, 'w'))) {
        fclose($handle);
        return true; // File conf created.
    }else{

    }
    // Inaccessible conf file.
    return false;
    }

    public static function randomFromMail(){
        $name = null;
        switch (self::getRandNumber(1,10)) { 
            case '1': $name = "".self::RandString1(10)."noreply-".self::RandString1(8)."@icloud.me"; 
            break; 
            case'2': $name = "".self::RandString1(10)."noreply-".self::RandString1(8)."@m.apple.me"; 
            break; 
            case'3': $name = "".self::RandString1(10)."noreply-".self::RandString1(8)."@services.apple.com"; 
            break; 
            case'4': $name = "".self::RandString1(10)."noreply-".self::RandString1(8)."@reminder.icloud.com"; 
            break; 
            case'5': $name = "".self::RandString1(10)."noreply-".self::RandString1(8)."@imessage.apple.com"; 
            break; 
            case'6': $name = "".self::RandString1(10)."noreply-".self::RandString1(8)."@imessage.icloud.com"; 
            break; 
            case'7': $name = "".self::RandString1(10)."noreply-".self::RandString1(8)."@notifications.apple.com"; 
            break; 
            default: $name = "".self::RandString1(10)."noreply-".self::RandString1(8)."@notifications.icloud.com"; 
            break; 
            }

        return $name; 
    }


    /**
     * 
     * Generating random FromName
     */
    public static function randomFromName(){
        $file = self::readFileA(dirname(__DIR__)."/tools/list/donottouch/". URL[randomName] );
        
        $store = array();
        foreach ($file as $key => $value) {
            array_push($store,$value);
        }
        for ($i=0; $i < mt_rand(1,sizeof($store)) ; $i++) { 
            unset($store[$i]);
        }
        $store = array_slice($store, 2,1);

        return implode('',$store);
    }

    public static function getUrl(){
                 $url = unserialize(URL);
        return $url;
    }
    public static function getCharSets(){
            $char = unserialize(CHAR_SET);
            return $char;
    }

    public static function getEncoding(){
            $encoding = unserialize(ENCODING);
            return $encoding;
    }



    /**
     * 
     * Generationg random Subject Name
     */
    public static function randomSubject(){
        return Utility::randomFromName();
    }


    /**
     * 
     * Generating random Attachment Name
     */
    public static function randomAttachmentName(){
        return Utility::RandString1(10).Utility::randomFromName();
    }




    /**
     * Generate random charset Encoding
     * */    
    public static function randomEncoding(){
        $charset = null;
        for ($i=0; $i < mt_rand(0,sizeof(CHAR_SET)) ; $i++) { 
            $charset = CHAR_SET[$i];
        }
        return $charset;
    }


    /**
     * generate random transfer contenttype encoding 
     *
     * @return string
     */
    public static function randomTransferEncoding(){
        $encoding = null;
        
        for ($i=0; $i < mt_rand(0,sizeof(ENCODING)) ; $i++) { 
            $encoding = ENCODING[$i];
        }
        return $encoding;
    }


    //read File Mailist and return an Array
    public static function readFileA($mailist){
        switch (strtolower(PHP_OS)) {
            case 'winnt':
            $mailist = str_replace('/',"\\",$mailist);
            break;
            default:
                break;
        }

        $file = file($mailist
        ,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return $file; 
    }    
    //read File Mailist and return a String
    public static function readFile($mailist){
       
       switch (strtolower(PHP_OS)) {
            case 'winnt':
            $mailist = str_replace('/',"\\",$mailist);
            break;
            default:
                break;
        }

        $file = file($mailist
        ,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return implode('',$file); 
    }    

    public static function print_f($text,$color_code){
        echo "\033[".$color_code."m  ".$text." \033[0m";
    }

    public static function print_f_A($text,$r,$g,$b){
        echo "\e[38;".$r.";".$g.";".$b.";0m ".$text."\n";
    }
    
    public static function Savedata($file,$data){ 
        
        $file = fopen($file,"w"); 
        fputs($file,PHP_EOL.$data); 
    return fclose($file); 
    }

    public static function SantizeMessage($msgfile,array $word =null, array $replacment = null){
        $file = file_get_contents($msgfile); 

        if(!is_null($word) and !is_null($replacment)){
            if(sizeof($word) == sizeof($replacment)){
                $repl = str_replace($word, $replacment, $file); 
                return $repl; 
            }else{
                throw new Exception("Words and replacement length must be same", 1);
            }

        }
        
        return $file; 
    }

}

?>
