<?php
require 'connect.php'; // Include your database connection

// Handle Add or Update Movie Slot
if (isset($_POST['save_slot'])) {
    $movie_id = $_POST['movie_id'];
    $screen_id = $_POST['screen_id'];
    $show_date = $_POST['show_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Check if a slot with the same screen_id and show_date already exists
    $checkSql = "SELECT id FROM movie_screenings WHERE movie_id=? AND screen_id=? AND show_date=? AND id != ?";
    $slot_id = isset($_POST['slot_id']) ? $_POST['slot_id'] : 0;
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param('iisi', $screen_id, $movie_id, $show_date, $slot_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Slot with same date exists, set error message
        $_SESSION['error_message'] = "A slot with this screen and date already exists.";
        header('Location: manageslottime.php');
        exit;
    }

    // Proceed with insert or update
    if (!empty($slot_id)) {
        // Update existing slot
        $sql = "UPDATE movie_screenings SET movie_id=?, screen_id=?, show_date=?, start_time=?, end_time=?, updated_at=NOW() WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisssi', $movie_id, $screen_id, $show_date, $start_time, $end_time, $slot_id);
    } else {
        // Add new slot
        $sql = "INSERT INTO movie_screenings (movie_id, screen_id, show_date, start_time, end_time, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisss', $movie_id, $screen_id, $show_date, $start_time, $end_time);
    }

    if ($stmt->execute()) {
        header('Location: manageslottime.php?message=Slot saved successfully');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Delete Slot
if (isset($_GET['delete'])) {
    $slot_id = $_GET['delete'];
    $sql = "DELETE FROM movie_screenings WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $slot_id);

    if ($stmt->execute()) {
        header('Location: manageslottime.php?message=Slot deleted successfully');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch Movies and Slots for Display
$movies = $conn->query("SELECT id, title FROM movies ORDER BY title")->fetch_all(MYSQLI_ASSOC);
$screens = $conn->query("SELECT id, name FROM screens ORDER BY name")->fetch_all(MYSQLI_ASSOC);
$slots = $conn->query("SELECT ms.id, m.title AS movie_title, s.name AS screen_name, ms.show_date, ms.start_time, ms.end_time 
                       FROM movie_screenings ms
                       JOIN movies m ON ms.movie_id = m.id
                       JOIN screens s ON ms.screen_id = s.id
                       ORDER BY ms.show_date, ms.start_time")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movie Slots</title>
    <link rel="stylesheet" type="text/css" href="css/style3.css">
</head>
<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Display error message if exists -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <script>
            alert("<?= $_SESSION['error_message'] ?>");
        </script>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Main content and table displaying slots... -->

    <!-- Main Content -->
    <div class="main-content">
        <h2>Manage Movie Slots</h2>
        <br>

        <!-- Add/Edit Slot Form -->
        <div class="form-container">
            <form method="POST" action="manageslottime.php">
                <h3>Add / Edit Movie Slot</h3>
                <input type="hidden" name="slot_id" id="slot_id">
                <div class="form-group">
                    <label for="movie_id">Movie</label>
                    <select name="movie_id" id="movie_id" required>
                        <option value="">Select Movie</option>
                        <?php foreach ($movies as $movie): ?>
                            <option value="<?= $movie['id'] ?>"><?= $movie['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="screen_id">Screen</label>
                    <select name="screen_id" id="screen_id" required>
                        <option value="">Select Screen</option>
                        <?php foreach ($screens as $screen): ?>
                            <option value="<?= $screen['id'] ?>"><?= $screen['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="show_date">Show Date</label>
                    <input type="date" name="show_date" id="show_date" required>
                </div>
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" name="start_time" id="start_time" required>
                </div>
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" name="end_time" id="end_time" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="save_slot">Save Slot</button>
                </div>
            </form>
        </div>

        <!-- Display Slots Table -->
        <table>
            <thead>
                <tr>
                    <th>Movie</th>
                    <th>Screen</th>
                    <th>Show Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slots as $slot): ?>
                    <tr>
                        <td><?= $slot['movie_title'] ?></td>
                        <td><?= $slot['screen_name'] ?></td>
                        <td><?= $slot['show_date'] ?></td>
                        <td><?= $slot['start_time'] ?></td>
                        <td><?= $slot['end_time'] ?></td>
                        <td>
                            <a href="#" onclick="editSlot(<?= htmlspecialchars(json_encode($slot)) ?>)">Edit</a> |
                            <a href="?delete=<?= $slot['id'] ?>" onclick="return confirm('Are you sure you want to delete this slot?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editSlot(slot) {
            document.getElementById('slot_id').value = slot.id;
            document.getElementById('movie_id').value = slot.movie_id;
            document.getElementById('screen_id').value = slot.screen_id;
            document.getElementById('show_date').value = slot.show_date;
            document.getElementById('start_time').value = slot.start_time;
            document.getElementById('end_time').value = slot.end_time;
        }
    </script>
</body>
</html>