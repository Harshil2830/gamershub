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


if($response == 0){
	$error = date("Y-m-d") . "  " . date("h:i:sa") . "  --- Frontend --- " . "Error: failed to login using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	log_event($error);
} else {
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Success: login successful using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	log_event($event);
	$_SESSION["username"] = $_POST["uname"];
	$_SESSION["user_id"] = $response["user_id"];
	if(isset($response["csgogamertag"])){
		$_SESSION["csgogamertag"] = $response["csgogamertag"];
	}
	if(isset($response["csgoplatform"])){
		$_SESSION["csgoplatform"] = $response["csgoplatform"];
	}
	if(isset($response["apexplatform"])){
		$_SESSION["apexplatform"] = $response["apexplatform"];
	}
	if(isset($response["apexgamertag"])){
		$_SESSION["apexgamertag"] = $response["apexgamertag"];
	}
	if(isset($response["splitgateplatform"])){
		$_SESSION["splitgateplatform"] = $response["splitgateplatform"];
	}
	if(isset($response["splitgategamertag"])){
		$_SESSION["splitgategamertag"] = $response["splitgategamertag"];
	}
}

header("Location: https://www.gamecave.com/forums.php");
exit();		
}

?>
