<?php
 ?>
<?php
 class MarketModel { 
     private $db; 
     public function __construct() { 
         $this->db = Database::getConnection(); 
         return $this; 
     }
     
     public function getList() { 
         $result = array(); 
         foreach ($this->db->exec('SELECT * FROM market WHERE id != 0') as $market) { 
             $result[$market['code']] = $market; 
             $result[$market['code']]['trading_start'] = Helper::dateTimeFormat($market['trading_start'], 'H:i'); 
             $result[$market['code']]['trading_end'] = Helper::dateTimeFormat($market['trading_end'], 'H:i'); 
             $result[$market['code']]['open'] = Helper::isDateTimeBetweenAndWorking($market['trading_start'], $market['trading_end'], $market['timezone'], 'now', $market['country_code']); 
         } 
         
         return $result; 
     } 
     
     public function isOpen($symbol) { 
/*         $market = $this->db->exec('SELECT m.trading_start, m.trading_end, m.timezone, m.country_code FROM asset a, market m WHERE a.market_id = m.id AND a.symbol = :symbol', array(':symbol' => $symbol)); 
         if (isset($market[0])) { 
             return Helper::isDateTimeBetweenAndWorking($market[0]['trading_start'], $market[0]['trading_end'], $market[0]['timezone'], 'now', $market[0]['country_code']); 
         } 
         return FALSE; */
         return TRUE;
     } 
 }