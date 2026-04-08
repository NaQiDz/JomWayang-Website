<?php
include 'dbconnection.php'; 

header('Content-Type: application/json');

$movie_id = $_GET['movie_id'];
$date = $_GET['date'];
$time = $_GET['time'];

// Fetch booked seats for the selected movie, date, and time
$sql = "SELECT `seat_no` FROM `holder_booking` WHERE `movie_id` = '$movie_id' AND `date_pick` = '$date' AND `time_pick` = '$time' AND `checkout_status` = 'Yes'";
$result = mysqli_query($conn, $sql);

$bookedSeats = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Assuming seat_no is a comma-separated string like "A1,A2,A3"
    $seats = explode(',', $row['seat_no']);
    $bookedSeats = array_merge($bookedSeats, $seats);
}

// Trim whitespace from each seat number
$bookedSeats = array_map('trim', $bookedSeats);

echo json_encode($bookedSeats);

mysqli_close($conn);
?>