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
  <a href="index.php" class="active">Home</a>
  <a id="login" style="display:block;" onclick="document.getElementById('id01').style.display='block'">Login</a>
  <a id="register" style="display:block;" onclick="document.getElementById('id02').style.display='block'">Register</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<h1>Home page</h1>

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

<script>
if (document.getElementById('session_usr').innerHTML != ""){
	document.getElementById('login').style.display='none';
	document.getElementById('register').style.display='none';
}
</script>
</body>
</html>
