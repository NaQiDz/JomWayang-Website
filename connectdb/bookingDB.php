<?php
// Start session
session_start();

// Include database connection
include 'dbconnection.php';

header('Content-Type: application/json'); // Ensure proper JSON response

if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()]);
    exit();
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seat = mysqli_real_escape_string($conn, $_POST['seat_no']);
    $count = mysqli_real_escape_string($conn, $_POST['seat_count']);
    $date = mysqli_real_escape_string($conn, $_POST['date_pick']);
    $time = mysqli_real_escape_string($conn, $_POST['time_pick']);
    $hall = mysqli_real_escape_string($conn, $_POST['hall']);
    $user = mysqli_real_escape_string($conn, $_POST['user_id']);
    $movie = mysqli_real_escape_string($conn, $_POST['movie_id']);

    // Insert data into the database
    $sql = "INSERT INTO `holder_booking`(`seat_no`, `seat_count`, `date_pick`, `time_pick`, `hall`, `user_id`, `movie_id` , `checkout_status` , `record_date`) 
            VALUES ('$seat', '$count', '$date', '$time', '$hall', '$user', '$movie', 'No', Now())";

    if (mysqli_query($conn, $sql)) {
        $slotId = mysqli_insert_id($conn); // Get the last inserted ID
        if ($slotId > 0) {
            // Store data in session
            $_SESSION['slotgain'] = true;
            $_SESSION['slotid'] = $slotId;
            // Return success response
            echo json_encode(['status' => 'success', 'message' => 'Booking successful!', 'slotId' => $slotId]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to retrieve last inserted ID.']);
        }
    } else {
        // Return error response if the query fails
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)]);
    }

    // Close the connection
    mysqli_close($conn);
} else {
    // Return fallback error for invalid requests
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>