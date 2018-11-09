<?php
date_default_timezone_set('America/Sao_Paulo');
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
ini_set('display_errors', true); 
ini_set('log_errors', true);
ini_set('log_errors_max_len', 1024);
ini_set('allow_url_fopen', 1);
ini_set('allow_url_include', 1);
 
if(getenv('ENVIRONMENT') &&  getenv('ENVIRONMENT') != 'development'){
	ini_set('display_errors', false); 
}

define('CONTROLLERS_PATH', '../controllers/');
define('MIDDLEWARE_PATH', '../middleware/');
define('URL_RSS', 'http://www.valor.com.br/rss'); 