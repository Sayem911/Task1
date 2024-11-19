<?php
/**
 * Virtual Stock Exchange
 * Version 1.7.0
 * Copyright (c) Financial Plugins <info@financialplugins.com>. All rights reserved.
 * http://financialplugins.com/products/virtual-stock-exchange/
 */
?>
<?php

require 'vendor/autoload.php';
// Kickstart the framework
$f3=require('vendor/bcosca/fatfree-core/base.php');

if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('config/framework.ini');
$f3->config('config/routes.ini');

// String translations
$f3->set('LOCALES', 'app/dictionaries/');
$f3->set('LANGUAGE', $f3->get('SITE.LANGUAGE'));
$f3->set('FALLBACK', 'en');
$f3->set('ONERROR','ErrorController->renderErrorPage');

date_default_timezone_set($f3->get('SITE.TIMEZONE'));

$f3->run();

?> 