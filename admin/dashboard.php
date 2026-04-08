<?php
include 'connect.php';

// Query to count movies
$movie_query = "SELECT COUNT(*) AS total_movies FROM movies";
$movie_result = $conn->query($movie_query);
$movie_count = $movie_result->fetch_assoc()['total_movies'];

// Query to count staff
$staff_query = "SELECT COUNT(*) AS total_users FROM users WHERE role != 'customer'";
$staff_result = $conn->query($staff_query);
$staff_count = $staff_result->fetch_assoc()['total_users'];

// Query for today's sales (updated based on holder_booking)
$today_sales_query = "SELECT SUM(hb.seat_count) AS total_sales 
                    FROM holder_booking hb
                    WHERE DATE(hb.date_pick) = CURDATE() AND hb.checkout_status = 1";

$today_sales_result = $conn->query($today_sales_query);
$today_sales = $today_sales_result ? $today_sales_result->fetch_assoc()['total_sales'] : 0;

// Query for total tickets sold (updated based on holder_booking)
$total_tickets_query = "SELECT SUM(hb.seat_count) AS total_tickets_sold
                        FROM holder_booking hb
                        WHERE hb.checkout_status = 1";

$total_tickets_result = $conn->query($total_tickets_query);
$total_tickets_sold = $total_tickets_result ? $total_tickets_result->fetch_assoc()['total_tickets_sold'] : 0;

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Jom Wayang Booking System</title>
    <link rel="stylesheet" type="text/css" href="css/style4.css"> <!-- Your existing CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="css/bookingStyle.css"> -->

</head>
<body>
    <?php include 'sidebar.php'; ?>
    

    <div class="main-content">
        <div class="dashboard-header">Admin Dashboard</div>

            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Movies</h3>
                    <p><?php echo $movie_count; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Staff</h3>
                    <p><?php echo $staff_count; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Today's Sales</h3>
                    <p><?php echo $today_sales; ?></p> <!-- Display Today's Sales -->
                </div>
                <div class="stat-card">
                    <h3>Total Tickets Sold</h3>
                    <p><?php echo $total_tickets_sold; ?></p> <!-- Display Total Tickets Sold -->
                </div>
            </div>

        <!-- Rest of the content -->
    </div>
</body>
</html>