<?php
$name = $_GET['name'];  // name from input label

require "databaseConfig.php";
$mysqli = new mysqli(HOST, 'root', PASS, DBNAME);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
$sql = 'select * from user where username like "%'.$name.'%"';
$result = $mysqli->query($sql);
$data = array();
if($result->num_rows >0){
    while($row = $result->fetch_assoc()){
        $item = array();

        $data[]=$row;
    }
}

echo json_encode($data) ;
?>