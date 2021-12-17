<?php
//session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('event_logger.php');


$client = new rabbitMQClient("database.ini","testServer");


$request = array();
$request['type'] = "register";
$request['username'] = $_POST["uname"];
$request['password'] = $_POST["psw"];
$request['email'] = $_POST["email"];
$response = $client->send_request($request);

if($response == 1){
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Success: Registration successful using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	log_event($event);
	$usr = $_POST['uname'];
	$email = $_POST['email'];
	$output = shell_exec("python3 emailscript.py $usr $email");
	header("Location: https://www.gamecave.com/success.php");
	exit();
} else {
	$error = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Error: failed to register using Username = " . $_POST["uname"] . " and Password = " . $_POST["psw"] . "\n";
	log_event($error);
	//session_destroy();
	header("Location: https://www.gamecave.com/failed.php");
	exit();
}
header("Location: https://www.gamecave.com/failed.php");
exit();
}
?>
