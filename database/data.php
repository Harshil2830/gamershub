<?php

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
public function displaycategory()
{
	$statement = "select * from categories";
	$response = $this->datadb->query($statement);
	$result = array();
	if($response->num_rows > 0){
		while ($row = $response->fetch_assoc())
		{
			$result[$row['cat_id']] = $row['cat_name'];
	
		}
		return $result;
	}
	else {
		return 0; 
	}

	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not get data to display categories" . "\n";
	log_event($event);
	echo "error: could not get data to display categories:".$this->datadb->error.PHP_EOL;
	return 0;//error: could not get data to display categories
}

public function displaytopics($id)
{
    $cid = $this->datadb->real_escape_string($id);
	$statement = "select * from topics where topic_cat = $cid";
	$response = $this->datadb->query($statement);
	$result = array();
    $counter = 0;
	if($response->num_rows > 0){
		while ($row = $response->fetch_assoc())
		{
			$result[$counter] = array($row["topic_id"], $row["topic_subject"], $row["topic_date"]);
            $counter++;
		}
		return $result;
	}
	else {
		return 0; 
	}

	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not get data to display topic info" . "\n";
	log_event($event);
	echo "error: could not get data to display topic info:".$this->datadb->error.PHP_EOL;
	return 0;//error: could not get data to display topic info
}

public function displaytopic($id)
{
    $cid = $this->datadb->real_escape_string($id);
	$statement = "select topic_id, topic_subject from topics where topic_id = $cid";
	$response = $this->datadb->query($statement);
	$result = array();
	if($response->num_rows > 0){
		while ($row = $response->fetch_assoc())
		{
			$result["id"] = $row["topic_subject"];
		}
		return $result;
	}
	else {
		return 0; 
	}

	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not get data to display topic info" . "\n";
	log_event($event);
	echo "error: could not get data to display topic info:".$this->datadb->error.PHP_EOL;
	return 0;//error: could not get data to display topic info
}

public function displayposts($id)
{
    $cid = $this->datadb->real_escape_string($id);
	$statement = "select 
        posts.post_topic,
        posts.post_content,
        posts.post_date,
        posts.post_by,
        users.user_id,
        users.username
    FROM
        posts
    LEFT JOIN
        users
    ON
        posts.post_by = users.user_id
    WHERE
        posts.post_topic = $cid";
	$response = $this->datadb->query($statement);
	$result = array();
    $counter = 0;
    if(!$response){
    	echo"error: " . $this->datadb->error;
    }
	if($response->num_rows > 0){
		while ($row = $response->fetch_assoc())
		{
			$result[$counter] = array($row["username"], $row["post_date"], $row["post_content"]);
            $counter++;
		}
		return $result;
	}
	else {
		return 0; 
	}

	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not get data to display posts" . "\n";
	log_event($event);
	echo "error: could not get data to display posts:".$this->datadb->error.PHP_EOL;
	return 0;//error: could not get data to display posts
}

public function createtopic($topic_subject, $topic_cat, $post_content, $username)
{
    $tsub = $this->datadb->real_escape_string($topic_subject);
    $tcat = $this->datadb->real_escape_string($topic_cat);
    $pcon = $this->datadb->real_escape_string($post_content);
    $user = $this->datadb->real_escape_string($username);

    $statement = "INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by) VALUES('$tsub', NOW(), '$tcat', '$user')";
    $response = $this->datadb->query($statement);
    if(!$response){
        return 0;
    }
    else {
        $topicid = $this->datadb->insert_id;   
        $statement = "INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES('$pcon', NOW(), '$topicid', '$user')";
        $response = $this->datadb->query($statement);
        if(!$response){
            return 0;
        }
        else {
            $result = array();
            $result["topicid"] = $topicid;
            return $result;
        }
    }

    
    $event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not create topic" . "\n";
    log_event($event);
    echo "error: could not create topic:".$this->datadb->error.PHP_EOL;
    return 0;//error: could not create topic
}

public function reply($id, $reply_content, $username)
{
    $rid = $this->datadb->real_escape_string($id);
    $re_con = $this->datadb->real_escape_string($reply_content);
    $user = $this->datadb->real_escape_string($username);

	$statement = "INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES ('$re_con', NOW(), '$rid', '$user')";


	$response = $this->datadb->query($statement);
	if(!$response){
		return 0;
	}
	else {
        return 1;
	}

	
	$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DataBase --- " . "error: could not add reply" . "\n";
	log_event($event);
	echo "error: could not add reply:".$this->datadb->error.PHP_EOL;
	return 0;//error: could not add reply
}

public function searchUser($friend_name)
{
	$fn = $this->datadb->real_escape_string($friend_name);
	$sql = "select * from users where username = '$fn'";
	$result = $this->datadb->query($sql);
	$data = array();
	if($result->num_rows >0){
	    while($row = $result->fetch_assoc()){
		//$item = array();

		$data['user_id']=$row['user_id'];
		$data['username']=$row['username'];
	    }
	return $data;
	}
	return 0;
}

public function addfriend($user_id, $friend_id, $friend_name, $username)
{
	$uid = $this->datadb->real_escape_string($user_id);
	$fid = $this->datadb->real_escape_string($friend_id);
	$fn = $this->datadb->real_escape_string($friend_name);
	$un = $this->datadb->real_escape_string($username);
	$sql = "select count(*) as friend_count from request where user_id='$uid' and friend_id = '$fid'";
	$result = $this->datadb->query($sql);
	$row = $result->fetch_assoc();
	
	if($row['friend_count'] > 0){
	    return 0;
	}
	else{
       	 $insert_sql = "INSERT INTO friend_relation(user_id,friend_id,friend_name) VALUES ('$uid','$fid','$fn')";
	         $result = $this->datadb->query($insert_sql);
	    	 if(!$result){
			return 0;
			}
	    	else {
       		$insert_sql = "INSERT INTO friend_relation(user_id,friend_id,friend_name) VALUES ('$fid','$uid','$un')";
	         $result = $this->datadb->query($insert_sql);
	    	 if(!$result){
			return 0;
			}
	    	else {
       		return 1;
		}
		}
	    
	    
	}

}

public function deletefriend($user_id, $friend_id, $friend_name)
{
	$uid = $this->datadb->real_escape_string($user_id);
	$fid = $this->datadb->real_escape_string($friend_id);
	$fn = $this->datadb->real_escape_string($friend_name);
	
	    $delete_sql = "delete from friend_relation where user_id = '$uid' and friend_id = '$fid'";
	    $result = $this->datadb->query($delete_sql);
	    if(!$result){
		echo'error '.$this->datadb->error;
		return 0;
		}
	    else {
       	 return 1;
		}
}



public function displayfriends($user_id)
{
   	$uid = $this->datadb->real_escape_string($user_id);
	$statement = "select * from friend_relation where user_id = '$uid'";
	$response = $this->datadb->query($statement);
	$counter = 0;
	$result = array();
	if($response->num_rows > 0){
		while ($row = $response->fetch_assoc())
		{
			$result[$counter] = array($row["friend_name"], $row["friend_id"]);
            		$counter++;
		}
		return $result;
	}
	else {
		return 0; 
	}
}



}
?>
