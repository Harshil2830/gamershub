<?php
    	//need to include these
    	//require_once('path.inc');
    	//require_once('get_host_info.inc');
    	//require_once('rabbitMQLib.inc');
    	
    	//Error logging
    	error_reporting(E_ALL);    
    	ini_set('display_errors', 'On');
    	ini_set('log_errors', 'On');
    	
    function log_event($event_string){
    	//append error to log file
	
    	file_put_contents("log.txt", $event_string, FILE_APPEND);
    	
    	/*
    	//send error to other servers
    	$db = new rabbitMQClient("testRabbitMQ.ini","testServer");
    	//$dmz = new rabbitMQClient("testRabbitMQ.ini","testServer");
    	$request = array();
    	$request['type'] = "event_log";
    	$request['error_message'] = $event_string;
    	
    	$response = $db->publish($request);
    	//$response = $dmz->publish($request);
    	*/
    }
?>
