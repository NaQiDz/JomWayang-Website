<?php
include 'connectdb/dbconnection.php';
session_start();

if (isset($_SESSION['slotgain']) && $_SESSION['slotgain'] == true) {
    $slotid = $_SESSION['slotid'];
    $userId = $_SESSION['user_id'];

    // Fetch the specific booking using $slotid
    $sql = "SELECT * FROM holder_booking WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $slotid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $booking = mysqli_fetch_assoc($result); // Fetch the booking details

            // Fetch movie details
            $movieSql = "SELECT * FROM movies WHERE id = ?";
            $movieStmt = mysqli_prepare($conn, $movieSql);
            mysqli_stmt_bind_param($movieStmt, "i", $booking['movie_id']);
            mysqli_stmt_execute($movieStmt);
            $movieResult = mysqli_stmt_get_result($movieStmt);
            $movie = mysqli_fetch_assoc($movieResult);
            mysqli_stmt_close($movieStmt);

            // Date/Time Formatting
            $datepick = DateTime::createFromFormat('Y-m-d', $booking['date_pick'])->format('M d');
            function getDayOfWeek($datepick) {
              $dateObj = DateTime::createFromFormat('Y-m-d', $datepick);
              return $dateObj->format('l');
            }
            $day = getDayOfWeek($booking['date_pick']);

            // Assuming you have these functions defined elsewhere (e.g., in header.php)
            function convertTo12HourFormat($timepick) {
                $dateObj = DateTime::createFromFormat('H:i:s', $timepick);                      
                if ($dateObj === false) {
                    return 'Invalid time format';
                }
                return $dateObj->format('g:i');
            }

            function getAMPM($timepick) {
                $dateObj = DateTime::createFromFormat('H:i:s', $timepick);                      
                if ($dateObj === false) {
                    return 'Invalid time format';
                }
                return $dateObj->format('A');
            }

            $formattedTime = convertTo12HourFormat($booking['time_pick']);
            $amPm = getAMPM($booking['time_pick']);

            // Explode food and quantity strings into arrays
            $foodIds = explode(',', $booking['foods']);
            $foodQuantities = explode(',', $booking['food_quantiy']);
            $foodItems = array_combine($foodIds, $foodQuantities);
            $totalFoodPrice = 0;

            $foodDetails = [];
            foreach ($foodItems as $foodId => $quantity) {
                $foodSql = "SELECT food_name, food_price FROM food WHERE id = ?";
                $foodStmt = mysqli_prepare($conn, $foodSql);
                mysqli_stmt_bind_param($foodStmt, "i", $foodId);
                mysqli_stmt_execute($foodStmt);
                $foodResult = mysqli_stmt_get_result($foodStmt);
                $foodRow = mysqli_fetch_assoc($foodResult);
                if ($foodRow) {
                    $foodDetails[] = $foodRow['food_name'] . " x " . $quantity;
                    $totalFoodPrice += $quantity * $foodRow['food_price'];
                }
                mysqli_stmt_close($foodStmt);
            }
            $foodList = implode(', ', $foodDetails);
        } else {
            echo "<p>Booking not found.</p>";
            $booking = null; // Or handle the error as appropriate for your application
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error retrieving booking.";
        $booking = null;
    }
} else {
    echo "<p>Please select a booking to view.</p>";
    $booking = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movie Ticket Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="css/receiptStyle.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="banner" style="background-image: url('img/background3.jpg');">
        <div class="overlay">
            <div class="container">
                <div class="ticket-container">

                    <?php if ($booking): ?>
                        <div class="ticket">
                            <img src="uploads/poster/<?= htmlspecialchars($movie['image']) ?>" alt="Movie poster" />
                            <div class="ticket-details">
                                <h1><?= htmlspecialchars($movie['title']) ?></h1>
                                <p><?= htmlspecialchars($movie['type']) ?> | <?= htmlspecialchars($movie['language']) ?> | <?= floor($movie['duration'] / 60) ?> h <?= $movie['duration'] % 60 ?> m | 2D</p>
                                <p><strong>Time</strong><br /><?= $day ?> <?= $datepick ?>, <?= $formattedTime ?> <?= $amPm ?></p>
                                <p><strong>Ticket(s)</strong><br />Adult x <?= htmlspecialchars($booking['seat_count']) ?></p>
                                <div class="slot-place">
                                    <p><strong>Hall</strong><br /><span class="highlight"><?= htmlspecialchars($booking['hall']) ?></span></p>
                                    <p><strong>Seat(s)</strong><br /><span class="highlight"><?= htmlspecialchars($booking['seat_no']) ?></span></p>
                                </div>
                                <div class="slot-place">
                                    <p><strong>Combo</strong><br /><span class="highlight"><?= $foodList ?: 'N/A' ?></span></p>
                                    <p><strong>Add-On</strong><br /><span class="highlight">N/A</span></p>
                                </div>
                                <div class="total">
                                    <?php
                                        $totalPrice = ($movie['price'] * $booking['seat_count']) + $totalFoodPrice; // Calculate total price
                                    ?>
                                    <span>Total</span>
                                    <span>RM <?= number_format($totalPrice, 2) ?></span>
                                </div>
                                <div class="checkout-button">
                                <form action="connectdb/checkout_booking.php" method="POST" onsubmit="return handleCheckout(event)">
                                    <input type="hidden" name="userid" value="<?php echo $booking['user_id']; ?>">
                                    <input type="hidden" name="movieid" value="<?php echo $booking['movie_id']; ?>">
                                    <input type="hidden" name="slotid" value="<?php echo $booking['id']; ?>">
                                    <input type="hidden" name="totalamount" value="<?php echo $totalPrice;?>">
                                    <button type="submit" id="startButton">Checkout</button>
                                  </form>
                                    
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>No booking details to display.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php
    
    ?>

    <!-- Popup (if needed) -->
    <div class="popup-container">
    <div class="popup-overlay" id="popup">
        <div class="popup-content">
            <img src="img/popcorn.png" alt="Ticket Image">
            <h2>Thank you for your purchase!</h2>
            <p>Your ticket has been successfully purchased.</p>
            <p class="ticket-id">Order ID: <span></span></p>
            <p>We hope you enjoy the movie!</p>
            <p id="redirectMessage" style="display: none;">You will be redirected shortly... <span id="countdown">6</span> seconds</p>
            <?php unset($_SESSION['slotid']); ?>
        </div>
    </div>
</div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script type="text/javascript" src="javascript/receiptScript.js"></script>
</body>
</html>