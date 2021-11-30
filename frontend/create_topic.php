<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">

</head>
<body>
<span id="session_usr" style="display:none;"><?php if(isset($_SESSION["username"])) {echo $_SESSION["username"];} ?></span>
<div class="topnav" id="myTopnav">
  <a href="index.php">CSGO</a>
  <a href="game2.php">Apex Legends</a>
  <a href="game3.php">Splitgate</a>
  <a id="events" href="events.php" style="display:none;">Events</a>
  <a id="forums" href="forums.php" style="display:none;">Forums</a>
  <a id="login" style="display:block;" onclick="document.getElementById('id01').style.display='block'">Login</a>
  <a id="register" style="display:block;" onclick="document.getElementById('id02').style.display='block'">Register</a>
  <a id="profile" href="profile.php" style="display:none;">Profile</a>
  <a id="logout" href="logout.php" style="display:none;">Logout</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<h1> Create a topic </h1>

<h2 id="notSigned" style="display:block;">Sign in or register an account to create a topic.</h2>

<script>
if (document.getElementById('session_usr').innerHTML != ""){
	document.getElementById('login').style.display='none';
	document.getElementById('register').style.display='none';
	document.getElementById('notSigned').style.display='none';
	document.getElementById('profile').style.display='block';
	document.getElementById('logout').style.display='block';
	document.getElementById('events').style.display='block';
	document.getElementById('forums').style.display='block';
}
</script>


<div id="wrapper">
	<div id="content">
<?php

if(isset($_SESSION["username"])){
	//the user is signed in
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{	
		//displaying the form
		echo '<form method="post" action="">
			Subject: <input type="text" name="topic_subject">
			Category:'; 
		
		echo '<select name="topic_cat">';
			while($row = mysql_fetch_assoc($result))
			{
				echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
			}
		echo '</select>';	
			
		echo 'Message: <textarea name="post_content"></textarea>
			<input type="submit" value="Create topic">
		     </form>';
	}
	else
	{
		require_once('path.inc');
		require_once('get_host_info.inc');
		require_once('rabbitMQLib.inc');
		require_once('event_logger.php');

		$client = new rabbitMQClient("database.ini","testServer");

		$request = array();
		$request['type'] = "create_topic";
		$request['topic_subject'] = $_POST["topic_subject"];
		$request['topic_cat'] = $_POST["topic_cat"];
		$request['post_content'] = $_POST["post_content"];
		$response = $client->send_request($request);
		
		if($response == 0){
			echo "<h1> Error: Failed to create new topic. </h1>";
			$error = date("Y-m-d") . "  " . date("h:i:sa") . "  --- Frontend --- " . "Error: Failed to create topic" . "\n";
			log_event($error);
	
		} else {
			echo "<h1> Success: New topic created. </h1>";
			$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- Frontend --- " . "Success: New topic created." . "\n";
			log_event($event);
		}
	}//post
}//username
?>

	</div><!-- content -->
</div><!-- wrapper -->


<div id="id01" class="modal">
  
  <form class="modal-content animate" action="login.php" method="POST">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
        
      <button type="submit" style="font-size:15px;">Login</button>
    </div>
  </form>
</div>

<div id="id02" class="modal">
  
  <form class="modal-content animate" action="register.php" method="POST">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
    
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>
      
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
        
      <button type="submit" style="font-size:15px;">Register</button>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');
var modal2 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
}
</script>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

</body>
</html>
