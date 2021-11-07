<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('event_logger.php');

$client = new rabbitMQClient("database.ini","testServer");


$request = array();
$request['type'] = "login";
$request['username'] = $_POST["uname"];
$request['password'] = $_POST["psw"];
$response = $client->send_request($request);
//$response = $client->publish($request);

if($response == 1){
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Success: login successful using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	log_event($event);
	$_SESSION["username"] = $_POST["uname"];
	header("Location: success.html");
	die();
} else {
	$error = date("Y-m-d") . "  " . date("h:i:sa") . "  --- Frontend --- " . "Error: failed to login using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	log_event($error);
	session_unset();
	session_destroy();
	header("Location: failed.html");
	die();
}
	
}

?>
