<?php
 ?>
<?php
 class Logger { private static $logger; private static $file = 'logs/trace.log'; public static function log($message) { $f3 = Base::instance(); if ($f3->get('DEBUG')>0) { if (!(self::$logger instanceof Log)) { self::$logger = new Log(self::$file); } self::$logger->write(sprintf('[uid %d] %s', $f3->get('SESSION.user.id'), is_string($message) ? $message : print_r($message, TRUE))); } } }