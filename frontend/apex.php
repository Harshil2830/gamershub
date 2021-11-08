<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('event_logger.php');

$client = new rabbitMQClient("database.ini","testServer");


$request = array();
$request['type'] = "apex_id";
$request['username'] = $_SESSION["username"];
$request['platform'] = $_POST["platform"];
$request['gamertag'] = $_POST["gamertag"];
$response = $client->send_request($request);


if($response == 1){
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Success: Apex gamertag added Username = " . $_SESSION["username"] . ", Platform = " . $_POST["platform"] . ", Gamer Tag = " . $_POST["gamertag"] . "\n";
	log_event($event);
} else {
	$error = date("Y-m-d") . "  " . date("h:i:sa") . "  --- Frontend --- " . "Error: Apex failed to add to account using Username = " . $_SESSION["username"] . ", Platform = " . $_POST["platform"] . ", Gamer Tag = " . $_POST["gamertag"] . "\n";
	log_event($error);
}

session_destroy();
header("Location: game2.php");
die();		
}

?>
