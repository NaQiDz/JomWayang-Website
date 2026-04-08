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

// Fetch reservation information along with movie and food details
$reservations_sql = "SELECT hb.*, m.title, m.image, m.duration, f.food_name, f.food_price
                    FROM `holder_booking` hb
                    INNER JOIN `movies` m ON hb.movie_id = m.id
                    LEFT JOIN `food` f ON FIND_IN_SET(f.id, hb.foods) > 0
                    WHERE hb.user_id = $user_id AND hb.checkout_status = 'Yes'"; // Assuming checkout_status = 1 means a completed booking
$reservations_result = $conn->query($reservations_sql);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movie Website/Slideshow</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/footerStyle.css">
    <link rel="stylesheet" type="text/css" href="css/historyStyle.css">
</head>
<body>
	<?php
        include 'header.php';
    ?>

    <div class="banner">
		<div class="overlay">

        </div>
    </div>

    <div class="container">
        <div class="booking-container" id="bookingContainer">
            <div class="booking-text" id="bookingText">Your Booking</div>
            <div class="status-icon" id="statusIcon">
                <i class="fas fa-check"></i>
            </div>
            <div class="arrow-icon"></div>
        </div>
    </div>

    <!--Ticket-->
    <?php
    if ($reservations_result->num_rows > 0) {
        while($row = $reservations_result->fetch_assoc()) {
            // Format seat numbers (if multiple seats are booked)
            $seats = explode(",", $row['seat_no']);
            $formatted_seats = implode(",", $seats); 

            // Get the food items and quantities
            $food_items = array();
            if (!empty($row['foods']) && !empty($row['food_quantiy'])) {
                $food_ids = explode(",", $row['foods']);
                $food_quantities = explode(",", $row['food_quantiy']);
                
                // Ensure arrays are the same length for safe iteration
                $count = min(count($food_ids), count($food_quantities));

                for ($i = 0; $i < $count; $i++) {
                    $food_id = $food_ids[$i];
                    $food_quantity = $food_quantities[$i];

                    // Fetch food name using the food ID (assuming you have a 'food' table)
                    $food_sql = "SELECT `food_name` FROM `food` WHERE `id` = $food_id";
                    $food_result = $conn->query($food_sql);
                    if ($food_result->num_rows > 0) {
                        $food_data = $food_result->fetch_assoc();
                        $food_items[] = $food_data['food_name'] . " x " . $food_quantity;
                    }
                }
            }
            $formatted_food = implode("<br>", $food_items);

            ?>
            <div class="containerv2">
                <div class="ticket">
                    <!-- Movie Poster -->
                    <img 
                        src="uploads/poster/<?php echo $row['image']; ?>" 
                        alt="Movie poster of <?php echo $row['title']; ?>" 
                        width="200" 
                        height="300"
                    />
                
                    <!-- Ticket Details -->                            
                    <div class="ticket-details">
                        <h1><?php echo $row['title']; ?></h1>
                        <p><strong>Time</strong><br/><?php echo date("D d M, g:i A", strtotime($row['date_pick'] . " " . $row['time_pick'])); ?></p>
                        <p><strong>Ticket(s) : </strong><?php echo $row['seat_count'] ?> Seats</p>
                        <div class="slot-place">
                            <p><strong>Hall</strong><br/><span class="highlight"><?php echo $row['hall']; ?></span></p>
                            <p><strong>Seat(s)</strong><br/><span class="highlight"><?php echo $formatted_seats; ?></span></p> 
                        </div>
                        <div class="slot-place">                
                            <p><strong>Combo</strong><br/><span class="highlight"><?php echo (empty($formatted_food) ? "N/A" : $formatted_food); ?></span></p>
                            <p><strong>Add-On</strong><br/><span class="highlight">N/A</span></p> <!-- Assuming you don't have add-ons in your data -->
                        </div>
                    </div>
                
                    <!-- QR Code Section -->
                    <div class="qr-code">
                        <img 
                            src="img\pngimg.com - qr_code_PNG10.png"
                            alt="QR code for ticket" 
                            width="150" 
                            height="150"
                        />
                        <div class="print-code">
                            <p>Print your ticket here:</p>
                            <button class="print-button">PRINT</button>
                        </div>
                        
                    </div>
                </div>    
            </div>
            <br>
            <br>
            <?php
        }
    } else {
        echo "<p>No booking history found.</p>";
    }
    ?>
    <!--Ticket-->

    <?php
        include 'footer.php';
        $conn->close();
    ?>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript" src="javascript/headerScript.js"></script>
<script>
   $(document).ready(function() {
    $('#bookingContainer').click(function() {
        var bookingText = $('#bookingText');
        var statusIcon = $('#statusIcon i');

        if (bookingText.text() === 'Your Booking') {
            bookingText.text('Cancel').css('color', 'red');
            statusIcon.removeClass('fa-check').addClass('fa-times').css('color', 'red');
        } else {
            bookingText.text('Your Booking').css('color', 'green');
            statusIcon.removeClass('fa-times').addClass('fa-check').css('color', 'green');
        }
    });
});

</script>
</body>

</html>