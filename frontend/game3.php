<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Splitgate Stats</title>
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
          <a class="nav-link active bg-info text-dark mx-1" href="game3.php">Splitgate</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1" href="events.php" id="events" style="display:none;">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1" href="forums.php" id="forums" style="display:none;">Forums</a>
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

<h1> Splitgate </h1>

<h2 id="notSigned" style="display:block;">Sign in or register an account to see your game stats.</h2>

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

<?php
	if(isset($_SESSION["username"])){
		if(isset($_SESSION["splitgategamertag"]) && isset($_SESSION["splitgateplatform"])){
			require_once('path.inc');
			require_once('get_host_info.inc');
			require_once('rabbitMQLib.inc');

			$client = new rabbitMQClient("database.ini","testServer");

			$request = array();
			$request['type'] = "splitgate";
			$request['platform'] = $_SESSION["splitgateplatform"];
			$request['gamertag'] = $_SESSION["splitgategamertag"];
			$response = $client->send_request($request);
			
			if(isset($response["kills"])) {
				echo "<h2>Kills: " . $response['kills'] . "</h2>";
				echo "<h2>Deaths: " . $response['deaths'] . "</h2>";
				echo "<h2>K/D: " . $response['kd'] . "</h2>";
				echo "<h2>Wins: " . $response['wins'] . "</h2>";
				echo "<h2>Losses: " . $response['losses'] . "</h2>";
			} else {
				echo "<h2>" . $response . "</h2>";
			}
		} else {
			echo " <form class='bg-dark' action='splitgate.php' method='POST'>
    					<div class='mb-3 mt-3'>
      					  <label for='platform'><b>Platform you play splitgate on:</b></label><br>
      					  <select name='platform' id='platform' required>
  						<option value='steam'>Steam</option>
  						<option value='xbl'>X-Box</option>
  						<option value='psn'>Playstation</option>
					  </select>
					</div>
					<div class='mb-3'>
      					  <label for='gamertag'><b>Gamer ID:</b></label>
      					  <input type='text' placeholder='Enter Gamer ID' name='gamertag' required>
        				</div>
      					  <button type='submit' class='btn btn-success'>Submit</button>
    					
  				</form>";
		}
	}
?>

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
  </form>
  
      </div>
  
    </div>
  </div>
</div>


<script type="text/javascript" src="/arrowchat/external.php?type=djs" charset="utf-8"></script>
<script type="text/javascript" src="/arrowchat/external.php?type=js" charset="utf-8"></script>


</body>
</html>
