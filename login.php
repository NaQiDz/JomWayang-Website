<?php 
    include 'connectdb/dbconnection.php';
 ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/loginStyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    </head>
<body>
    <div class="left-side">
       <div class="container">
            <form id="form" class="form">
            <a href="index.php" style="
                  text-decoration: none;
                  color: white;
                  padding: 10px 15px;
                  border-radius: 5px;
                  display: inline-block;
                  transition: background-color 0.3s ease, transform 0.3s ease;
                ">
                  <i class="fas fa-home" style="
                    color: white;
                    font-size: 20px;
                    vertical-align: middle;
                  "></i>
                </a>
                <h2>Login</h2>
                <div class="form-control">
                  <label for="username">Username</label>
                  <input type="text" id="username" placeholder="Enter username" />
                  <small>Error Message</small>
                </div>
                <div class="form-control">
                  <label for="password">Password</label>
                  <input type="password" id="password" placeholder="Enter password" />
                  <small>Error Message</small>
                </div>
                <button>Submit</button>
                <div class="gothru">
                   <label>Doesn't has an Account <a href="register.php">Register</a> Now!</label> 
                </div>                
              </form>
            </div>

            <div id="popup" class="popup hidden">
              <div class="popup-content">
                <span class="close-btn" onclick="closePopup()">&times;</span>
                <p id="popup-message"></p>
              </div>
            </div>
    </div>
    <div class="right-side">
        <div class="overlay"></div>
        <img src="img\background2.jpg" alt="Person sitting in a cinema">
    </div>
    <script type="text/javascript" src="javascript/loginScript.js"></script>
</body>
</html>
