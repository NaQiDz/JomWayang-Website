<?php
// Database connection details (replace with your actual credentials)
$host = "localhost";
$username = "root";
$password = "";
$database = "projectweb";
// Create connection
$conn = mysqli_connect($host, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
// Assuming a user is logged in and you have their ID stored in a session variable
$user_id = $_SESSION['userid']; // Replace with your actual session variable

// Fetch user information
$user_sql = "SELECT `ID`, `username`, `email`, `phone`, `address`, `role` FROM `users` WHERE `ID` = $user_id";
$user_result = $conn->query($user_sql);
$user_data = $user_result->fetch_assoc();

// Fetch reservation information
$reservations_sql = "SELECT hb.*, m.title, m.image 
                    FROM `holder_booking` hb
                    INNER JOIN `movies` m ON hb.movie_id = m.id
                    WHERE hb.user_id = $user_id
                    AND hb.checkout_status = 'Yes'";
$reservations_result = $conn->query($reservations_sql);
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Account Page - Movie Ticket Reservation
  </title>
  <link rel="stylesheet" href="css/AccountStyle.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>

 </head>
 <body>
  <?php 
    include 'header.php';
  ?>
  <div class="container main-content">
   <!-- Profile Section -->
   <div class="account">
    <div class="flex items-center space-x-4">
        <center>     
            <img alt="Profile picture of the user" class="w-24 h-24" height="100px" src="https://storage.googleapis.com/a1aa/image/i3ArbkWLmzLOGFV4qv6rhrntFakQbjkTCQn7dwtpKQq2RAeJA.jpg"/> <!-- You might want to store user profile pictures and fetch the URL from the database -->
        </center>
     <div>
        <center>
             <h2>
                <?php echo $user_data['username']; ?>
                </h2>
                <p>
                <?php echo $user_data['email']; ?>
                </p>
        </center>     
     </div>
    </div>
    <br>
    <br>
    <div class="mt-6">
     <h3>
      Account Details
     </h3>
     <p class="mt-2">
      <strong>
       Phone:
      </strong>
      <?php echo $user_data['phone']; ?>
     </p>
     <p class="mt-2">
      <strong>
       Address:
      </strong>
      <?php echo $user_data['address']; ?>
     </p>
    </div>
   </div>
   <!-- Reservations Section -->
   <div class="reservations">
    <h3>
     My Reservations
    </h3>
    <?php
    if ($reservations_result->num_rows > 0) {
        while($row = $reservations_result->fetch_assoc()) {
            ?>
            <div class="reservation-item">
             <img alt="Poster of the movie '<?php echo $row['title']; ?>'" class="w-24 h-36" height="150px" src="uploads\poster\<?php echo $row['image']; ?>"/>
             <div>
              <h4>
               <?php echo $row['title']; ?>
              </h4>
              <p>
               Date: <?php echo date("Y-m-d", strtotime($row['date_pick'])); ?>
              </p>
              <p>
               Time: <?php echo date("g:i A", strtotime($row['time_pick'])); ?>
              </p>
              <p>
               Seats: <?php echo $row['seat_no']; ?> 
              </p>
             </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No reservations found.</p>";
    }
    ?>
   </div>
  </div>
  <?php 
    include 'footer.php';
    $conn->close();
  ?>
 </body>
</html>