#!/usr/bin/php
<?php
require_once('event_logger.php');
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function doLog($error){
	file_put_contents("/var/www/gamehub/log.txt", $error, FILE_APPEND);
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    $event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "ERROR: unsupported message type" . "\n";
    //log_event($event);
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "event_log":
      doLog($request['error_message']);
    /*default:
      $event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Server received request but request type does not match" . "\n";
      log_event($event);*/
  }
  
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("frontend.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>
