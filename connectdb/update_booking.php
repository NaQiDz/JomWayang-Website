<?php
include 'dbconnection.php';
session_start();

ini_set('display_errors', 1); // Enable error reporting (temporarily)
ini_set('display_startup_errors', 1); // Enable error reporting (temporarily)
error_reporting(E_ALL); // Enable error reporting (temporarily)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['slotgain']) && $_SESSION['slotgain'] == true) {
    $slotid = $_SESSION['slotid'];

    $selectedFoods = json_decode($_POST['selectedFoods'], true);
    //var_dump("Selected Foods:", $selectedFoods);

    $foodIds = []; // Store food IDs instead of names
    $foodQuantities = [];
    foreach ($selectedFoods as $food) {
        $foodIds[] = $food['id']; // Store the food ID
        $foodQuantities[] = $food['quantity'];
    }

    $foodIdsString = implode(',', $foodIds); // Comma-separated string of food IDs
    $foodQuantitiesString = implode(',', $foodQuantities); // Comma-separated string of quantities

    //var_dump("Food IDs String:", $foodIdsString);
    //var_dump("Food Quantities String:", $foodQuantitiesString);

    // Use prepared statements for security
    $sql = "UPDATE holder_booking SET foods = ?, food_quantiy = ?, record_date = NOW() WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    //var_dump("SQL Query:", $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $foodIdsString, $foodQuantitiesString, $slotid);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "Order updated successfully!";
        } else {
            http_response_code(500);
            echo "Error updating order: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
}
?>