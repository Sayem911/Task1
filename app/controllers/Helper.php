<?php
 ?>
<?php
 class Helper { 
     public static function baseUrl() { 
         return sprintf( "%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME'], $_SERVER['PHP_SELF']=='/index.php' ? '/' : dirname($_SERVER['PHP_SELF']).'/' ); 
     } 
     
     public static function timeStamp($time = 'now', $offset = NULL, $inputTimezone = NULL, $outputTimezone = NULL) { 
         $offset = intval($offset); 
         $datetime = $inputTimezone ? new DateTime($time, new DateTimeZone($inputTimezone)) : new DateTime($time); 
         if ($offset>0) { 
             $datetime->add(new DateInterval('PT'.$offset.'S')); 
         } elseif ($offset<0) { 
             $datetime->sub(new DateInterval('PT'.abs($offset).'S')); 
         } 
         
         if ($outputTimezone) { 
             $outTz = new DateTimeZone($outputTimezone); 
             $datetime->setTimezone($outTz); 
             
         } 
         
         return $datetime->format('Y-m-d H:i:s'); 
     } 
     
     public static function localDateTime($time, $timezone, $format = 'H:i') { 
         $datetime = new DateTime($time, new DateTimeZone($timezone)); 
         $datetime->setTimezone(new DateTimeZone(date_default_timezone_get())); 
         
         return $datetime->format($format); 
     } 
     
     public static function isDateTimeBetween($fromDateTime, $toDateTime, $timeZone, $checkedDateTime = 'now') { 
         $tz = new DateTimeZone($timeZone); 
         $dtFrom = new DateTime($fromDateTime, $tz); 
         $dtTo = new DateTime($toDateTime, $tz); 
         $dtCurrent = new DateTime($checkedDateTime); 
         $tzCurrent = new DateTimeZone(date_default_timezone_get()); 
         $dtFrom->setTimezone($tzCurrent); 
         $dtTo->setTimezone($tzCurrent); 
         
         return $dtFrom<=$dtCurrent && $dtCurrent<=$dtTo ? TRUE : FALSE; 
     } 
     
     public static function isDatePeriodInThePast($startDateTime, $periodLength) { 
         $tz = new DateTimeZone(date_default_timezone_get()); 
         $dt = new DateTime($startDateTime, $tz); 
         $dt->modify('+'.$periodLength.' days'); 
         $dtCurrent = new DateTime('now', $tz); 
         
         return $dt < $dtCurrent; 
     } 
     
     public static function isDateTimeBetweenAndWorking($fromDateTime, $toDateTime, $timeZone, $checkedDateTime = 'now', $countryCode = NULL) { 
         return self::isDateTimeBetween($fromDateTime, $toDateTime, $timeZone, $checkedDateTime) && self::isWorkingDay($checkedDateTime, $timeZone, $countryCode); 
     } 
     
     public static function dateTimeFormat($dateTime, $format) { 
         $dt = new DateTime($dateTime); return $dt->format($format); 
     } 
     
     public static function isWorkingDay($dateTime = 'now', $timeZone = NULL, $countryCode = NULL) { 
         if (is_null($timeZone)) $timeZone = date_default_timezone_get(); 
         $tz = new DateTimeZone($timeZone); 
         $dt = new DateTime($dateTime, $tz); 
         
         return in_array(intval($dt->format('N')), $countryCode=='sa' ? [1,2,3,4,7] : [1,2,3,4,5]) ? TRUE : FALSE; 
     } 
     
    //  public static function formatNumber($input, $decimals = 0) {
    //      return !is_nan($input) ? number_format(floatval($input), $decimals) : $input; 
    //  } 

     public static function formatNumber($input, $decimals = 0) {
        $formatter= new \NumberFormatter('de-DE', \NumberFormatter::DECIMAL);
        $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $decimals);
        $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $decimals);
        return !is_nan($input) ? $formatter->format($input) : $input; 
     } 
    
    /*
    * $formatStyle should be one of the NumberFormatter predefined constants, 
    * such as NumberFormatter::CURRENCY, NumberFormatter::DECIMAL, etc.
    */
     public static function localizedFormatNumber($input, $decimals = 0, $currency = 'EUR', $formatStyle=\NumberFormatter::CURRENCY) {
        // $locale = (isset($_COOKIE['locale']) ) ? $_COOKIE['locale'] : $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $locale = 'de-DE';
        $formatter= new \NumberFormatter($locale, $formatStyle);
        return !is_nan($input) ? $formatter->formatCurrency($input, $currency) : $input; 
        // return !is_nan($input) ? number_format(floatval($input), $decimals) : $input; 
     }
     
     public static function splitDatesRange($startDate, $endDate, $interval = '1 Year', $format = 'Y-m-d') { 
         $result = array(); 
         $currentEndDate = $endDate; 
         
         while (strtotime('-'.$interval, $currentEndDate) > $startDate) { 
             $result[] = array('start'=>date($format, strtotime('-'.$interval, $currentEndDate)), 'end'=>date($format,$currentEndDate)); 
             $currentEndDate = strtotime('-'.$interval.' -1 Day', $currentEndDate); 
         } 
         
         $result[] = array('start'=>date($format, $startDate), 'end'=> date($format, $currentEndDate)); 
         return $result; 
     } 
     
     public static function p($msg) { 
         if (is_array($msg) || is_object($msg)) { 
             print '<pre>'.print_r($msg, TRUE).'</pre>'; 
         } else { 
             print $msg.'<br>'; 
         } 
     } 
     
     public static function getRemoteData($url) { 
         return @file_get_contents($url); 
     } 
     
     public static function getYahooRssLangDomain($userLanguage = NULL) { 
         if (!$userLanguage || in_array($userLanguage,['en','ru'])) { 
             return ''; 
         } elseif ($userLanguage=='pt') { 
             return 'br.'; 
         } else { 
             return sprintf('%s.', $userLanguage); 
         } 
     } 
     
     public static function sign($n) { 
         return ($n > 0) - ($n < 0); 
     } 
     
     public static function cleanString($string) { 
         return preg_replace('#[^a-z\s\t0-9-\$\(\)&\.\,\/\!\?\%\:\;]#i','',$string); 
     } 
     
     public static function randomNumber($length) { 
         return sprintf('%0'.$length.'d', mt_rand(0,pow(10,$length)-1)); 
     } 
     
     public static function implodeByKey(array $array, $key, $delimiter = ',') { 
         $result = []; 
         foreach ($array as $item) { 
             if (isset($item[$key])) { 
                 $result[] = $item[$key]; 
             } 
         } 
         
         return implode($delimiter, $result); 
     } 
     
     public static function getGoogleFinanceSymbol($exchange, $symbol) { 
         if (($dotPosition = strpos($symbol, '.')) && $dotPosition !== FALSE) { 
             $symbol = substr($symbol, 0, $dotPosition); 
         } 
         
         return str_replace( ['LSE','AMEX','BOVESPA','XETRA','SIX','TSX','HKEX'], ['LON','NYSEMKT','BVMF','ETR','VTX','TSE','HKG'], $exchange) . ':' . $symbol; 
     } 
 }