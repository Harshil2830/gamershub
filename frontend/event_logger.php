<?php	
    	//Error logging
    	error_reporting(E_ALL);    
    	ini_set('display_errors', 'On');
    	ini_set('log_errors', 'On');
    	
    function log_event($event_string){
    	//append error to log file
    	file_put_contents("log.txt", $event_string, FILE_APPEND);
    	
    	//making error message request
    	$request = array();
    	$request['type'] = "event_log";
    	$request['error_message'] = $event_string;
    	
    	
    	//send error to database server
    	$db = new rabbitMQClient("database.ini","testServer");
    	$response = $db->publish($request);
    	
    	//send error to dmz server
    	$dmz = new rabbitMQClient("dmz.ini","testServer");
    	$response = $dmz->publish($request);
    	
    	//send error to RabbitMQ server
    	$rbmq = new rabbitMQClient("rabbitMQ.ini","testServer");
    	$response = $rbmq->publish($request);
    	
    }
?>
