<?php
require_once('event_logger.php');

$path = '/usr/local/lib/system_libs';
    if (file_exists('local.ini'))
    {
        $parse = parse_ini_file('local.ini',true);
        if (isset($parse['paths']))
        {
            $path = $parse['paths']['libraries'];
        }
        else
        {
        	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "Error connecting to database: ".$this->logindb->connect_error.PHP_EOL . "\n";
    		log_event($event);
         	trigger_error("local.ini missing paths field\n",E_USER_NOTICE); 
        }
    }
    set_include_path(get_include_path().PATH_SEPARATOR.$path);
?>
