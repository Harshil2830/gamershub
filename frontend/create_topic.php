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
