<?php
 ?>
<?php
 class Database { 
     private static $factory; 
     private $connection; 
     public static function getConnection() { 
         if (!self::$factory) { 
             self::$factory = new self(); 
             
         } 
         
         return self::$factory->connection; 
         
     } 
     
     private function __construct() { 
         $f3 = Base::instance(); 
         $this->connection = new DB\SQL( $f3->get('DB.DNS'), $f3->get('DB.USER'), $f3->get('DB.PASSWORD'), array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) ); 
     } 
     
     private function __clone() { }
 }