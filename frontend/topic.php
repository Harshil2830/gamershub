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
	//user is signed in
	//display category data
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	require_once('event_logger.php');

	$client = new rabbitMQClient("database.ini","testServer");

	$request = array();
	$request['type'] = "topic_info";
	$request['id'] = $_GET['id'];
	$result = $client->send_request($request);
	if($result == 0)
	{
		echo 'This topic does not exist.';
	}
	else
	{
		echo '<table border="1">
			  <tr>
				<th>' . $result['topic_subject'] . '</th>
			  </tr>';
	}

	$client = new rabbitMQClient("database.ini","testServer");

	$request = array();
	$request['type'] = "posts_display";
	$request['id'] = $_GET['id'];
	$result = $client->send_request($request);
		
	if($result == 0)
	{
		echo 'There are no posts in this topic yet.';
	}
	else
	{	
		while($row = mysql_fetch_assoc($result))
		{				
			echo '<tr>';
				echo '<td class="leftpart">';
					echo '<h3>' . $row['user_name'] . '/n' . date('m-d-Y h:i', strtotime($row['post_date'])) . '</h3>';
				echo '</td>';
				echo '<td class="rightpart">';
					echo '<h3>' . $row['post_content'] . '</h3>';
				echo '</td>';
			echo '</tr>';
		}
		
		//reply form
		echo '<tr>';
			echo '<td>';
				echo '<form method="post" action="reply.php?id=' . $_GET['id'] . '">
					<label> Reply: </label>
    					<textarea name="reply-content"></textarea>
    					<input type="submit" value="Submit reply" />
				      </form>';
			echo '</td>';
		echo '</tr>';
	}
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
