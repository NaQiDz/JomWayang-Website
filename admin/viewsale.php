<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sales - Jom Wayang Admin</title>
    <link rel="stylesheet" type="text/css" href="css/style5.css">
    <script src="js/viewsale.js.js" defer></script>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="container">
        <h1>View Sales</h1>
        <form class="filter-form" id="filterForm" method="get" action="viewsale.php">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate">

            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate">

            <label for="movie">Movie:</label>
            <select id="movie" name="movie">
                <option value="">All</option>
                <?php
                $conn = new mysqli('localhost', 'root', '', 'projectweb');
                if ($conn->connect_error) {
                    die("<option value=''>Database Error</option>");
                }
                $movies = $conn->query("SELECT DISTINCT m.title AS movie_title FROM movies m");
                while ($movie = $movies->fetch_assoc()) {
                    echo "<option value='" . $movie['movie_title'] . "'>" . $movie['movie_title'] . "</option>";
                }
                $conn->close();
                ?>
            </select>

            <button type="submit">Filter</button>
        </form>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Booking ID</th>
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Movie Title</th>
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Date</th>
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Time</th>
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Hall</th>
                    <th style="padding: 10px; text-align: right; border: 1px solid #ddd;">Tickets Sold</th>
                    <th style="padding: 10px; text-align: right; border: 1px solid #ddd;">Total Amount</th>
                </tr>
            </thead>
            <tbody id="salesTableBody">
                <?php
                $conn = new mysqli('localhost', 'root', '', 'projectweb'); 
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                $startDate = $_GET['startDate'] ?? null;
                $endDate = $_GET['endDate'] ?? null;
                $movie = $_GET['movie'] ?? null;

                // SQL Query to get sales data from holder_booking and booking_ticket
                $query = "SELECT 
                            hb.id AS booking_id,
                            m.title AS movie_title,
                            hb.date_pick AS date,
                            hb.time_pick AS time,
                            hb.hall AS hall,
                            hb.seat_count AS tickets_sold,
                            bt.total_amount AS total_amount
                        FROM holder_booking hb
                        JOIN movies m ON hb.movie_id = m.id
                        LEFT JOIN booking_ticket bt ON hb.id = bt.holder_id
                        WHERE hb.checkout_status = 1";

                // Check if a specific movie is provided
                if ($movie) {
                    $query .= " AND m.title = '$movie'";
                }

                // Check if startDate and endDate are provided
                if ($startDate && $endDate) {
                    $query .= " AND DATE(hb.date_pick) BETWEEN '$startDate' AND '$endDate'";
                } elseif ($startDate) {
                    $query .= " AND DATE(hb.date_pick) >= '$startDate'";
                } elseif ($endDate) {
                    $query .= " AND DATE(hb.date_pick) <= '$endDate'";
                }
               

                $query .= " ORDER BY hb.date_pick DESC, hb.time_pick ASC";

                // Execute the query
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    // Display results
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td style='padding: 8px; text-align: left; border: 1px solid #ddd;'>" . $row['booking_id'] . "</td>
                            <td style='padding: 8px; text-align: left; border: 1px solid #ddd;'>" . $row['movie_title'] . "</td>
                            <td style='padding: 8px; text-align: left; border: 1px solid #ddd;'>" . $row['date'] . "</td>
                            <td style='padding: 8px; text-align: left; border: 1px solid #ddd;'>" . $row['time'] . "</td>
                            <td style='padding: 8px; text-align: left; border: 1px solid #ddd;'>" . $row['hall'] . "</td>
                            <td style='padding: 8px; text-align: right; border: 1px solid #ddd;'>" . $row['tickets_sold'] . "</td>
                            <td style='padding: 8px; text-align: right; border: 1px solid #ddd;'>RM " . number_format($row['total_amount'], 2) . "</td>
                        </tr>";
                    }
                } else {
                    // Show message if no results
                    echo "<tr><td colspan='7' style='padding: 8px; text-align: center; border: 1px solid #ddd;'>No sales found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="script.js"></script>
</body>
</html>