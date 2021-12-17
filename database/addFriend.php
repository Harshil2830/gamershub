<?php

require "databaseConfig.php";
$user_id = $_GET['user_id'];
$friend_id = $_GET['friend_id']; 
$friend_name = $_GET['friend_name']; 

$mysqli = new mysqli("127.0.0.1","root","Root666!","accounts");
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$sql = 'select count(*) as friend_count from friend_relation where user_id='.$user_id." and friend_id = " . $friend_id;
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

if($row['friend_count'] > 0){
    $result_json['result'] = false;
    $result_json['info'] = "friend exist your friend list";
}else{
    $insert_sql = "INSERT INTO friend_relation(user_id,friend_id,friend_name) VALUES (".$user_id."," .$friend_id.",'" . $friend_name . "')";
    $result = $mysqli->query($insert_sql);
    $result_json['result'] = true;
    $result_json['info'] = "friend add success";
}
echo json_encode($result_json) ;
?>  
