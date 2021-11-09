#!/usr/bin/php
<?php
require_once('event_logger.php');
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('apidata.php');

function doLog($error){
	file_put_contents("log.txt", $error, FILE_APPEND);
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
  	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DMZ --- " . "ERROR: unsupported message type" . "\n";
    	log_event($event);
    	
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "getcsgo":
      return getcsgo($request['platform'],$request['gamertag']);
    case "getapex":
      return getapex($request['platform'],$request['gamertag']);
    case "getsplitgate":
      return getsplitgate($request['platform'],$request['gamertag']);
    case "event_log":
      doLog($request['error_message']);
    /*default:
      $event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DMZ --- " . "Server received request but request type does not match" . "\n";
      log_event($event);*/
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("dmz.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

