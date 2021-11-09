<?php
//require_once('event_logger.php');

class dataDB
{
private $datadb;

public function __construct()
{
	$this->datadb = new mysqli("127.0.0.1","root","Root666!","accounts");

	if ($this->datadb->connect_errno != 0)
	{
		$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "Error connecting to database: ".$this->datadb->connect_error.PHP_EOL . "\n";
    		log_event($event);
		echo "Error connecting to database: ".$this->datadb->connect_error.PHP_EOL;
		exit(1);
	}
	echo "correctly connected to database".PHP_EOL;
}

public function validatecsgo($platform,$gamertag)
{

	$pf = $this->datadb->real_escape_string($platform);
	$gt = $this->datadb->real_escape_string($gamertag);
	
	    	//getting data
    	$request = array();
    	$request['type'] = "getcsgo";
    	$request['platform'] = $pf;
    	$request['gamertag'] = $gt;
    	
    	//send error to database server
    	$dmz = new rabbitMQClient("dmz.ini","testServer");
    	$data = $dmz->send_request($request);
    	if(!isset($data["kills"])){
    		return $data;
    	}
    	print_r($data);
    	$kills = $data["kills"];
    	$deaths = $data["deaths"];
    	$kd = $data["kd"];
    	$headshots = $data["headshots"];
    	$wins = $data["wins"];
    	
    	
	$statement = "select * from csgodata where gamertag = '$gt'";
	$response = $this->datadb->query($statement);
	if($response->num_rows > 0){
		$statement = "UPDATE csgodata SET kills='$kills', death='$deaths', kd='$kd', headshots='$headshots', wins='$wins' WHERE gamertag = '$gt'";
		$response = $this->datadb->query($statement);
		if($response == TRUE)
		{
			return $data;
		}	
	}
	else {
		$statement = "INSERT INTO csgodata (gamertag,kills,death,kd,headshots,wins)
	VALUES('$gt','$kills','$deaths','$kd','$headshots','$wins')";
		$response = $this->datadb->query($statement);
		if($response == TRUE)
		{
			return $data;
		}	
	}

	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not get data from csgo" . "\n";
	log_event($event);
	echo "error: could not get data from csgo:".$this->datadb->error.PHP_EOL;
	return 0;//error: could not get data from csgo
}

public function validateapex($platform,$gamertag)
{

	$pf = $this->datadb->real_escape_string($platform);
	$gt = $this->datadb->real_escape_string($gamertag);
	
	    	//getting data
    	$request = array();
    	$request['type'] = "getapex";
    	$request['platform'] = $pf;
    	$request['gamertag'] = $gt;
    	
    	//send error to database server
    	$dmz = new rabbitMQClient("dmz.ini","testServer");
    	$data = $dmz->send_request($request);
    	if(!isset($data["kills"])){
    		return $data;
    	}
    	print_r($data);
    	$level = $data["level"];
    	$kills = $data["kills"];
    	$finishers = $data["finishers"];
    	$headshots = $data["headshots"];
    	$damage = $data["damage"];
    	
	$statement = "select * from apexdata where gamertag = '$gt'";
	$response = $this->datadb->query($statement);
	if($response->num_rows > 0){
		$statement = "UPDATE apexdata SET level='$level',kills='$kills',finishers='$finishers',headshots='$headshots',damage='$damage' WHERE gamertag = '$gt'";
		$response = $this->datadb->query($statement);
		if($response == TRUE)
		{
			return $data;
		}	
	}
	else {
		$statement = "INSERT INTO apexdata (gamertag,level,kills,finishers,headshots,damage)
	VALUES('$gt','$level','$kills','$finishers','$headshots','$damage')";
		$response = $this->datadb->query($statement);
		if($response == TRUE)
		{
			return $data;
		}	
	}

	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not get data for apex" . "\n";
	log_event($event);
	echo "error: could not get data for apex".PHP_EOL;
	return 0;//error: could not get data for apex
}

public function validatesplitgate($platform,$gamertag)
{
	$pf = $this->datadb->real_escape_string($platform);
	$gt = $this->datadb->real_escape_string($gamertag);
	
	    	//getting data
    	$request = array();
    	$request['type'] = "getsplitgate";
    	$request['platform'] = $pf;
    	$request['gamertag'] = $gt;
    	
    	//send error to database server
    	$dmz = new rabbitMQClient("dmz.ini","testServer");
    	$data = $dmz->send_request($request);
    	if(!isset($data["kills"])){
    		return $data;
    	}
    	print_r($data);
    	$kills = $data["kills"];
    	$deaths = $data["deaths"];
    	$kd = $data["kd"];
    	$wins = $data["wins"];
    	$losses = $data["losses"];
    	
	$statement = "select * from splitgatedata where gamertag = '$gt'";
	$response = $this->datadb->query($statement);
	if($response->num_rows > 0){
		$statement = "UPDATE splitgatedata SET kills='$kills', deaths='$deaths',kd='$kd',wins='$wins',losses='$losses' WHERE gamertag = '$gt'";
		$response = $this->datadb->query($statement);
		if($response == TRUE)
		{
			return $data;
		}	
	}
	else {
		$statement = "INSERT INTO splitgatedata (gamertag,kills,deaths,kd,wins,losses)
	VALUES('$gt','$kills','$deaths','$kd','$wins','$losses')";
		$response = $this->datadb->query($statement);
		if($response == TRUE)
		{
			return $data;
		}	
	}

	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not get data from splitgate" . "\n";
	log_event($event);
	echo "error: could not get data from splitgate".PHP_EOL;
	return 0;//error: could not get data from splitgate
}

public function addidcsgo($username,$platform,$gamertag)
{
	$un = $this->datadb->real_escape_string($username);
	$pf = $this->datadb->real_escape_string($platform);
	$gt = $this->datadb->real_escape_string($gamertag);
	$statement = "INSERT INTO csgo(username, platform, gamertag)
	VALUES('$un','$pf','$gt')";

	$response = $this->datadb->query($statement);
	if($response == TRUE)
	{
		echo "added to data base"; 
		return 1;
	}	


	return 0;
}

public function addidapex($username,$platform,$gamertag)
{
	$un = $this->datadb->real_escape_string($username);
	$pf = $this->datadb->real_escape_string($platform);
	$gt = $this->datadb->real_escape_string($gamertag);
	$statement = "INSERT INTO apex(username, platform, gamertag)
	VALUES('$un','$pf','$gt')";

	$response = $this->datadb->query($statement);
	if($response == TRUE)
	{
		echo "added to data base"; 
		return 1;
	}	


	return 0;
}

public function addidsplitgate($username,$platform,$gamertag)
{
	$un = $this->datadb->real_escape_string($username);
	$pf = $this->datadb->real_escape_string($platform);
	$gt = $this->datadb->real_escape_string($gamertag);
	$statement = "INSERT INTO splitgate(username, platform, gamertag)
	VALUES('$un','$pf','$gt')";

	$response = $this->datadb->query($statement);
	if($response == TRUE)
	{
		echo "added to data base"; 
		return 1;
	}	


	return 0;
}

}
?>
