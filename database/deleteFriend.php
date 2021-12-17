<?php

require "databaseConfig.php";
$id = $_GET['id'];  // name from input label

$mysqli = new mysqli("127.0.0.1","root","Root666!","accounts");
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$sql = 'delete from friend_relation where id='.$id;
$result = $mysqli->query($sql);
if($result){
    
    $result_json['result'] = true;
    $result_json['info'] = "friend delete success";
}else{
    
    $result_json['result'] = false;
    $result_json['info'] = "friend delete fail";
}
echo json_encode($result_json) ;
?>  
