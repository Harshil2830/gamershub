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
<span id="session_usr" ><?php if(isset($_SESSION["username"])) {echo $_SESSION["username"];} ?></span>
<!--<span id="session_usr"><?php if(isset($_SESSION["username"])) {echo $_SESSION["csgogamertag"];} ?></span>-->
<div class="topnav" id="myTopnav">
  <a href="index.php" class="active">CSGO</a>
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

<h1> CS:GO </h1>

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
		if(isset($_SESSION["csgogamertag"]) && isset($_SESSION["csgoplatform"])){
			require_once('path.inc');
			require_once('get_host_info.inc');
			require_once('rabbitMQLib.inc');

			$client = new rabbitMQClient("database.ini","testServer");

			$request = array();
			$request['type'] = "csgo";
			$request['platform'] = $_SESSION["csgoplatform"];
			$request['gamertag'] = $_SESSION["csgogamertag"];
			$response = $client->send_request($request);
		 
			if(isset($response["kills"])) {
				echo "<h2>Kills: " . $response['kills'] . "</h2>";
				echo "<h2>Deaths: " . $response['deaths'] . "</h2>";
				echo "<h2>K/D: " . $response['kd'] . "</h2>";
				echo "<h2>Headshots: " . $response['headshots'] . "</h2>";
				echo "<h2>Wins: " . $response['wins'] . "</h2>";
			} else {
				echo "<h2>" . $response . "</h2>";
			}
		} else {
			echo " <form class='modal-content animate' action='csgo.php' method='POST'>
    					<div class='container'>
      					  <label for='platform'><b>Platform you play CSGO on:</b></label><br>
      					  <select style='margin: 5px 0px;' name='platform' id='platform' required>
  						<option value='steam'>Steam</option>
					  </select>
					<br>
      					  <label for='gamertag'><b>Gamer ID:</b></label>
      					  <input type='text' placeholder='Enter Gamer ID' name='gamertag' required>
        
      					  <button type='submit' style='font-size:15px;'>Submit</button>
    					</div>
  				</form>";
		}
	}
?>

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
