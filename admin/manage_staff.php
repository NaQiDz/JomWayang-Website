<?php
require 'connect.php';

// Handle Add Staff
if (isset($_POST['add_staff'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $role = $conn->real_escape_string($_POST['role']);
    $password = $conn->real_escape_string($_POST['password']); // Added password

    $sql = "INSERT INTO `users`(`username`, `password`, `email`, `phone`, `address`, `role`) 
            VALUES ('$username', '$password', '$email', '$phone', '$address', '$role')";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage_staff.php?message=Staff added successfully");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Update Staff
if (isset($_POST['update_staff'])) {
    $id = $_POST['id'];
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "UPDATE `users` SET `username`='$username', `email`='$email', `phone`='$phone', 
            `address`='$address', `role`='$role' WHERE `ID`='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage_staff.php?message=Staff updated successfully");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Delete Staff
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM `users` WHERE `ID`='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage_staff.php?message=Staff deleted successfully");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff - Jomayang Booking System</title>
    <link rel="stylesheet" type="text/css" href="css/style3.css">
    <script>
        // Password Validation Function
        function validatePassword(password) {
            const lengthCheck = password.length >= 10; 
            const uppercaseCheck = /[A-Z]/.test(password); 
            const lowercaseCheck = /[a-z]/.test(password); 
            const numberCheck = /\d/.test(password); 
            const specialCheck = /[!@#$%^&*(),.?":{}|<>]/.test(password); 
            const middleCheck = /(?<=.{3})([A-Z].*\d.*[!@#$%^&*(),.?":{}|<>])|(?<=.{3})([0-9].*[A-Z].*[!@#$%^&*(),.?":{}|<>])/.test(password); 

            if (!lengthCheck) {
                return "Password must be at least 10 characters long.";
            }
            if (!uppercaseCheck || !lowercaseCheck || !numberCheck || !specialCheck) {
                return "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
            }
            if (!middleCheck) {
                return "Password must have at least one uppercase, numeric, and special character in the middle.";
            }
            return "Password is strong.";
        }

        // Email Validation Function
        function validateEmail(email) {
            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return emailRegex.test(email);
        }

        // Form Validation Function
        function validateForm() {
            const password = document.getElementById('staff-password').value;
            const email = document.getElementById('staff-email').value;
            
            const passwordMessage = validatePassword(password);
            const emailMessage = validateEmail(email) ? "Email is valid." : "Invalid email format.";
            
            // Show the validation results
            document.getElementById('password-result').innerText = passwordMessage;
            document.getElementById('email-result').innerText = emailMessage;
            
            if (passwordMessage === "Password is strong." && emailMessage === "Email is valid.") {
                return true; // Form is valid, submit it
            } else {
                return false; // Form is not valid, prevent submission
            }
        }
    </script>
</head>
<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h2>Manage Staff</h2>
        <br>
        <!-- Add Staff Form -->
        <div class="staff-form">
            <form method="POST" action="manage_staff.php" onsubmit="return validateForm()">
                <div class="form-group">
                    <h3>Add New Staff</h3>
                    <label for="staff-name">Staff Name</label>
                    <input type="text" id="staff-name" name="username" placeholder="Enter staff name" required>
                </div>
                <div class="form-group">
                    <label for="staff-role">Role</label>
                    <input type="text" id="staff-role" name="role" placeholder="Enter role (e.g., Manager, Cashier)" required>
                </div>
                <div class="form-group">
                    <label for="staff-email">Email</label>
                    <input type="email" id="staff-email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="staff-phone">Phone Number</label>
                    <input type="tel" id="staff-phone" name="phone" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label for="staff-address">Address</label>
                    <input type="text" id="staff-address" name="address" placeholder="Enter address" required>
                </div>
                <div class="form-group">
                    <label for="staff-password">Password</label>
                    <input type="password" id="staff-password" name="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="add_staff">Add Staff</button>
                </div>
            </form>
            <p id="email-result"></p>
            <p id="password-result"></p>
        </div>

        <!-- Display Staff Table -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM `users` WHERE role != 'customer'");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['role']}</td>
                        <td>
                            <a href='?edit={$row['ID']}'>Edit</a> |
                            <a href='?delete={$row['ID']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Populate the form for editing
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $result = $conn->query("SELECT * FROM `users` WHERE `ID`='$id'");
            if ($row = $result->fetch_assoc()) {
                echo "
                <script>
                    document.getElementById('username').value = '{$row['username']}';
                    document.getElementById('email').value = '{$row['email']}';
                    document.getElementById('phone').value = '{$row['phone']}';
                    document.getElementById('address').value = '{$row['address']}';
                    document.getElementById('role').value = '{$row['role']}';
                    document.getElementsByName('password')[0].required = false; 
                    document.getElementsByName('add_staff')[0].name = 'update_staff';
                    document.getElementsByName('add_staff')[0].innerText = 'Update Staff';
                </script>";
            }
        }
        ?>
    </div>
</body>
</html>
