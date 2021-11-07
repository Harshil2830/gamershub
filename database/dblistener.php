#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');
require_once('register.php.inc');
require_once('event_logger.php');

function doLog($error){
	file_put_contents("hublog.txt", $error, FILE_APPEND);
}


function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    $login = new loginDB();
    return $login->validateLogin($username,$password);
    //return false if not valid
}


function doregister($username,$password,$email)
{
    $login = new registerDB();
    return $login->validateregister($username,$password,$email);
}
function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "ERROR: unsupported message type" . "\n";
    log_event($event);
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "register":
      return doRegister($request['username'],$request['password'],$request['email']);
    case "event_log":
      doLog($request['error_message']);
    /* default:
      $event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Database --- " . "Server received request but request type does not match" . "\n";
      log_event($event);
      */
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("database.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

