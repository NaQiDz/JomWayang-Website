<?php 
	include "connectdb/dbconnection.php";
	session_start();
	if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true) {
		$userlogin = true;
		$userid = $_SESSION['userid'];
		$userInfo = mysqli_query($conn, "SELECT * FROM users WHERE ID = '$userid'");
		$user = mysqli_fetch_assoc($userInfo);
	}
	else{
		$userlogin = false;
		$userid = 0;
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movie Website/Slideshow</title>
	<link rel="stylesheet" type="text/css" href="css/headerStyle.css">
</head>
<body>
	<header id="mainHeader">
		<a href="index.php" class="logo">JomWayang</a><small>MY</small>
		<ul class="nav">
			<li>
				<a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
			</li>
			<li>
				<a href="#">Adults</a>
			</li>
			<li>
				<a href="#">Kids</a>
			</li>
			<li>
				<a href="#">Trend</a>
			</li>
			<li>
				<a href="historypage.php">History</a>
			</li>
		</ul>

		<div class="search">
			<input type="text" placeholder="Search" />
			<i class="fa fa-search" aria-hidden="true"></i>
		</div>
		<div class="profile">
		<?php 
			if ($userlogin) {
		 ?>
			<img src="https://storage.googleapis.com/a1aa/image/i3ArbkWLmzLOGFV4qv6rhrntFakQbjkTCQn7dwtpKQq2RAeJA.jpg" alt="Profile picture of the user, a generic avatar image">
			<div class="dropdown">
		        <a class="signup">Welcome <?php echo ''.$user["username"].''; ?></a>
		        <a href="accountpage.php" class="signup">Account</a>
		        <a class="login" href="connectdb/logout.php">Logout</a>
		    </div>
		<?php
			}else{
		 ?>		
            <i class="fa fa-user-circle"></i>
             <div class="dropdown">
		        <a class="signup" href="register.php">Signup</a>
		        <a class="login" href="login.php">Login</a>
		    </div>
		<?php } ?>
            
        </div>
	</header>

<script type="text/javascript" src="javascript/headerScript.js"></script>
</body>

</html>