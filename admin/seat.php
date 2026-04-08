<?php
$servername = "localhost";
$username = "root";   // Change this to your MySQL username
$password = "";       // Change this to your MySQL password
$dbname = "cinema_reservation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get reserved seats from the database
$reservedSeats = [];
$sql = "SELECT seat_number FROM reservations WHERE reserved = TRUE";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservedSeats[] = $row['seat_number'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cinema Seat Reservation</title>
    <style>
        .seat {
            width: 30px;
            height: 30px;
            margin: 5px;
            text-align: center;
            cursor: pointer;
            background-color: lightgray;
        }
        .reserved {
            background-color: red;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h1>Cinema Seat Reservation</h1>

    <form action="reserve.php" method="POST">
        <?php
            $rows = 10;  // Number of rows
            $seatsPerRow = 10;  // Number of seats per row

            // Loop through each row and seat
            for ($i = 1; $i <= $rows; $i++) {
                echo "<div style='display:flex;'>";
                for ($j = 1; $j <= $seatsPerRow; $j++) {
                    $seatNumber = "R$i-S$j";  // Unique seat identifier
                    $isReserved = in_array($seatNumber, $reservedSeats);
                    
                    echo "<label class='seat " . ($isReserved ? "reserved" : "") . "'>";
                    if ($isReserved) {
                        echo "<input type='checkbox' disabled>";
                    } else {
                        echo "<input type='checkbox' name='seats[]' value='$seatNumber'>";
                    }
                    echo "$seatNumber";
                    echo "</label>";
                }
                echo "</div>";
            }
        ?>
        <br>
        <button type="submit">Reserve Selected Seats</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
