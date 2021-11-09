<?php
//require_once('event_logger.php');

class loginDB
{
private $logindb;

public function __construct()
{
	$this->logindb = new mysqli("127.0.0.1","root","Root666!","accounts");

	if ($this->logindb->connect_errno != 0)
	{
		$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "Error connecting to database: ".$this->logindb->connect_error.PHP_EOL . "\n";
    		//log_event($event);
		echo "Error connecting to database: ".$this->logindb->connect_error.PHP_EOL;
		exit(1);
	}
	echo "correctly connected to database".PHP_EOL;
}

public function validateLogin($username,$password)
{
	$un = $this->logindb->real_escape_string($username);
	$pw = $this->logindb->real_escape_string($password);
	$statement = "select * from users where username='$un'";
	$response = $this->logindb->query($statement);
	if($response->num_rows > 0){
	while ($row = $response->fetch_assoc())
	{
		echo "checking password for $username".PHP_EOL;
		if ($row["password"] == $pw)
		{
			echo "passwords match for $username".PHP_EOL;
			$gamer = array();
			
			$statement = "select * from csgo where username='$un'";
			$csgoresponse = $this->logindb->query($statement);
			if($csgoresponse->num_rows > 0){
				while ($row = $csgoresponse->fetch_assoc()){
					$gamer["csgoplatform"] = $row["platform"];
					$gamer["csgogamertag"] = $row["gamertag"];
				}
			} 
			
			$statement = "select * from apex where username='$un'";
			$apexresponse = $this->logindb->query($statement);
			if($apexresponse->num_rows > 0){
				while ($row = $apexresponse->fetch_assoc()){
					$gamer["apexplatform"] = $row["platform"];
					$gamer["apexgamertag"] = $row["gamertag"];
				}
			}
			
			$statement = "select * from splitgate where username='$un'";
			$splitgateresponse = $this->logindb->query($statement);
			if($splitgateresponse->num_rows > 0){
				while ($row = $splitgateresponse->fetch_assoc()){
					$gamer["splitgateplatform"] = $row["platform"];
					$gamer["splitgategamertag"] = $row["gamertag"];
				}
			}
			
			return $gamer;// password match
		}
		$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "passwords did not match for $username" . "\n";
		//log_event($event);
		echo "passwords did not match for $username".PHP_EOL;
	}}
	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "no users matched username" . "\n";
	//log_event($event);
	echo "no users matched username".PHP_EOL;
	return 0;//no users matched username
}
}
?>
