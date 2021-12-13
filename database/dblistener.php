#!/usr/bin/php
<?php
require_once('event_logger.php');
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');
require_once('register.php.inc');
require_once('data.php');


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
function docsgo($platform,$gamertag)
{
    $login = new dataDB();
    return $login->validatecsgo($platform,$gamertag);
}
function doapex($platform,$gamertag)
{
    $login = new dataDB();
    return $login->validateapex($platform,$gamertag);
}
function dosplitgate($platform,$gamertag)
{
    $login = new dataDB();
    return $login->validatesplitgate($platform,$gamertag);
}
function addcsgo($username,$platform,$gamertag)
{
    $login = new dataDB();
    return $login->addidcsgo($username,$platform,$gamertag);
}
function addapex($username,$platform,$gamertag)
{
    $login = new dataDB();
    return $login->addidapex($username,$platform,$gamertag);
}
function addsplitgate($username,$platform,$gamertag)
{
    $login = new dataDB();
    return $login->addidsplitgate($username,$platform,$gamertag);
}

function category()
{
    $login = new dataDB();
    return $login->displaycategory();
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
    case "register":
      return doRegister($request['username'],$request['password'],$request['email']);
    case "event_log":
      doLog($request['error_message']);
      break;
    case "csgo":
      return docsgo($request['platform'],$request['gamertag']);
    case "apex":
      return doapex($request['platform'],$request['gamertag']);
    case "splitgate":
      return dosplitgate($request['platform'],$request['gamertag']);
    case "csgo_id":
      return addcsgo($request['username'],$request['platform'],$request['gamertag']);
    case "apex_id":
      return addapex($request['username'],$request['platform'],$request['gamertag']);
    case "splitgate_id":
      return addsplitgate($request['username'],$request['platform'],$request['gamertag']);
    case "forums":
    	return category();
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

