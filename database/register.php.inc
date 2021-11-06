<?php

class registerDB
{
private $registerdb;

public function __construct()
{
	$this->registerdb = new mysqli("127.0.0.1","root","Root666!","accounts");

	if ($this->registerdb->connect_errno != 0)
	{
		echo "Error connecting to database: ".$this->registerdb->connect_error.PHP_EOL;
		exit(1);
	}
	echo "correctly connected to database".PHP_EOL;
}

public function validateregister($username,$password,$email)
{
	$un = $this->registerdb->real_escape_string($username);
	$pw = $this->registerdb->real_escape_string($password);
	$em = $this->registerdb->real_escape_string($email);
	$statement = "INSERT INTO users(username, password, email)
	VALUES('$un','$pw','$em')";

	$response = $this->registerdb->query($statement);
	if($response == TRUE)
	{
		echo "added to data base"; 
		return 1;
	}	


	return 0;
}
}
?>
