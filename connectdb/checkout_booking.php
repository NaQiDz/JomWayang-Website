<?php
include 'dbconnection.php'; // Include your database connection
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userid'];
    $movieId = $_POST['movieid'];
    $slotId = $_POST['slotid'];
    $totalAmount = $_POST['totalamount'];

    // Get holder_id from holder_booking table (You might need to adjust this based on your specific requirement)
    $holderId = $slotId;

    // Insert into booking_ticket table
    $stmt = $conn->prepare("INSERT INTO booking_ticket (user_id, movie_id, holder_id, total_amount, booking_added) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiid", $userId, $movieId, $holderId, $totalAmount);

    if ($stmt->execute()) {
        // Get the last inserted ID (Order ID)
        $orderId = $stmt->insert_id;

        // Remove the booking from holder_booking
        $deleteStmt = $conn->prepare("UPDATE holder_booking SET checkout_status = 'Yes' WHERE id = ?");
        $deleteStmt->bind_param("i", $slotId);
        if (!$deleteStmt->execute()) {
            // Handle error deleting from holder_booking
            echo json_encode(['success' => false, 'message' => 'Error deleting from holder_booking: ' . $deleteStmt->error]);
            exit; // Stop execution
        }
        $deleteStmt->close();

        // Respond with success and order ID
        echo json_encode(['success' => true, 'orderId' => $orderId]);
    } else {
        // Handle database error
        echo json_encode(['success' => false, 'message' => 'Error inserting booking: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>