#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('apidata.php')


function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "csgodata":
      return getcsgo($request['platform'],$request['gamertag']);
    case "apexdata":
      return getapex($request['platform'],$request['gamertag']);
    case "splitgatedata":
      return getsplitgate($request['platform'],$request['gamertag']);
    case "event_log":
      return getcsgo($request['platform'],$request['gamertag']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("dmz.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

