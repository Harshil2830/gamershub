<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Forums</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="bg-secondary text-white">

<span id="session_usr" style="display:none;"><?php if(isset($_SESSION["username"])) {echo $_SESSION["username"];} ?></span>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand">
      <img src="logo.jpg" alt="Logo" style="width:40px;" class="rounded">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link mx-1" href="index.php">CS:GO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1" href="game2.php">Apex Legends</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1" href="game3.php">Splitgate</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1" href="events.php" id="events" style="display:none;">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-light text-dark mx-1" href="forums.php" id="forums" style="display:none;">Forums</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-success text-light mx-1" href="#" id="login" style="display:block;" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-light text-dark mx-1" href="#" id="register" style="display:block;" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1" href="profile.php" id="profile" style="display:none;">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-danger text-light mx-1" href="logout.php" id="logout" style="display:none;">Logout</a>
        </li>  
      </ul>
  </div>
</div>
</nav>

<div class="container-fluid">

<h2 id="notSigned" style="display:block;">Sign in or register an account to see posts in the topic.</h2>

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
	$request['type'] = "topics_info";
	$request['id'] = $_GET['id'];
	$response = $client->send_request($request);
	if($response == 0)
	{
		echo 'This topic does not exist.';
		echo '<a href="create_topic.php" class="btn btn-info" role="button">CLICK HERE</a> to create a topic.';
	}
	else
	{
			echo '<table border="1">
			  <tr>
				<th>' . $response["id"] . '</th>
			  </tr>';

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
		foreach($result as $key => $value)
		{				
			echo '<tr>';
				echo '<td class="leftpart">';
					echo '<h3>' . $value[0] . '<br>' . date('m-d-Y h:i', strtotime($value[1])) . '</h3>';
				echo '</td>';
				echo '<td class="rightpart">';
					echo '<h3>' . $value[2] . '</h3>';
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
	
	echo '</table>';
    }
}//username
?>

	</div><!-- content -->
</div><!-- wrapper -->


</div>


<div class="modal" id="loginModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h3 class="modal-title">Login</h3>
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"></button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
  
  <form action="login.php" method="POST">
    <div class="mb-3 mt-3">
      <label for="uname" class="form-label"><b>Username</b></label>
      <input type="text" class="form-control" placeholder="Enter Username" name="uname" required>
    </div>
    <div class="mb-3">
      <label for="psw" class="form-label"><b>Password</b></label>
      <input type="password" class="form-control" placeholder="Enter Password" name="psw" required>
    </div>
      <button type="submit" class="btn btn-success" style="width:100%;">Login</button>
  </form>
  
      </div>
      
    </div>
  </div>
</div>

<div class="modal" id="registerModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h3 class="modal-title">Register</h3>
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"></button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
    
  <form action="register.php" method="POST">
    <div class="mb-3 mt-3">
      <label for="email" class="form-label"><b>Email</b></label>
      <input type="text" class="form-control" placeholder="Enter Email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="uname" class="form-label"><b>Username</b></label>
      <input type="text" class="form-control" placeholder="Enter Username" name="uname" required>
    </div>
    <div class="mb-3">
      <label for="psw" class="form-label"><b>Password</b></label>
      <input type="password" class="form-control" placeholder="Enter Password" name="psw" required>
    </div>
      <button type="submit" class="btn btn-success" style="width:100%;">Register</button>
    </div>
  </form>
  
      </div>
  
    </div>
  </div>
</div>

</body>
</html>
