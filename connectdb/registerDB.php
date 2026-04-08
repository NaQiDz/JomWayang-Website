<?php
// Include database connection
include 'dbconnection.php';

if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()]);
    exit();
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

    // Validate passwords
    if ($password !== $password2) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO users (username, password, email, phone, address, role) 
            VALUES ('$username', '$hashed_password', '$email', '$phone', '$address', 'Customer')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode('Registration successful!');
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)]);
    }

    // Close the connection
    mysqli_close($conn);
} else {
    echo json_encode('Registration failed');
}
?>
