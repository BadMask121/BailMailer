<?php 
    interface UtilityInt {
        public static function cmd($command);
        public static function getOs();
        public static function getIp();
        public static function getUserAgent();
        public static function getRandNumber($start, $offset);
        public static function randomIp();
        public static function randomUserAgent();
        public static function randomFromMail();
        public static function randomFromName();
        public static function randomSubject();
        public static function randomAttachmentName();
        public static function randomEncoding();
        public static function randomTransferEncoding();
        public static function createWritableFile($file);
        public static function SantizeMessage($msgfile,array $word =null, array $replacment = null);
        public static function Savedata($file,$data);
    }
?>