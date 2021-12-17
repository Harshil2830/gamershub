<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('event_logger.php');


$client = new rabbitMQClient("database.ini","testServer");


$request = array();
$request['type'] = "csgo_id";
$request['username'] = $_SESSION["username"];
$request['platform'] = $_POST["platform"];
$request['gamertag'] = $_POST["gamertag"];
$response = $client->send_request($request);


if($response == 1){
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Success: CSGO gamertag added Username = " . $_SESSION["username"] . ", Platform = " . $_POST["platform"] . ", Gamer Tag = " . $_POST["gamertag"] . "\n";
	//log_event($event);
	$_SESSION["csgoplatform"] = $_POST["platform"];
	$_SESSION["csgogamertag"] = $_POST["gamertag"];
} else {
	$error = date("Y-m-d") . "  " . date("h:i:sa") . "  --- Frontend --- " . "Error: CSGO failed to add to account using Username = " . $_SESSION["username"] . ", Platform = " . $_POST["platform"] . ", Gamer Tag = " . $_POST["gamertag"] . "\n";
	//log_event($error);
}

header("Location: https://www.gamecave.com/index.php");
die();		
}
?>
