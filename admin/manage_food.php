<?php
// Include database connection file
require 'connect.php';

// Add or update food in the database
if (isset($_POST['add_food'])) {
    // Sanitize input
    $food_name = $conn->real_escape_string($_POST['food_name']);
    $food_category = $conn->real_escape_string($_POST['food_category']);
    $food_quantity = $_POST['food_quantity'];
    $food_price = $_POST['food_price'];
    $food_rating = $_POST['food_rating'];

    // Function to upload images
    function uploadImage($file, $upload_dir, $filename_prefix)
    {
        $image_name = $file['name'];
        $image_tmp = $file['tmp_name'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

        // Accept all image formats
        $allowed_extensions = ['png', 'jpg', 'jpeg', 'gif'];
        if (in_array(strtolower($image_ext), $allowed_extensions)) {
            $image_filename = $filename_prefix . '.' . $image_ext;  // Only store the filename
            $image_path = $upload_dir . $image_filename;
            if (move_uploaded_file($image_tmp, $image_path)) {
                return $image_filename;  // Return only the filename
            } else {
                echo "<script>alert('Error uploading image.');</script>";
            }
        } else {
            echo "<script>alert('Invalid image format. Allowed formats are: PNG, JPG, JPEG, GIF.');</script>";
        }
        return null;
    }

    $upload_dir_food = '../uploads/food/';
    $food_name_formatted = strtolower(str_replace(' ', '-', $food_name));

    $food_image = null;

    if (isset($_FILES['food_image']) && $_FILES['food_image']['error'] == 0) {
        $food_image = uploadImage($_FILES['food_image'], $upload_dir_food, $food_name_formatted);
    }

    $food_created = date("Y-m-d H:i:s");
    $food_update = date("Y-m-d H:i:s");

    if (!isset($_POST['food_id'])) {
        // Add food if there's no food ID
        $sql = "INSERT INTO food(food_name, food_category, food_quantity, food_price, food_rating, food_image, food_created, food_update) 
                VALUES ('$food_name', '$food_category', '$food_quantity', '$food_price', '$food_rating', '$food_image', '$food_created', '$food_update')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Food added successfully!'); window.location.href = 'manage_food.php';</script>";
        } else {
            echo "<script>alert('Error: {$conn->error}');</script>";
        }
    } else {
        // Update food if there's a food ID
        $food_id = $conn->real_escape_string($_POST['food_id']);
        if ($food_image) {
            $sql = "UPDATE `food` SET 
                    `food_name` = '$food_name', 
                    `food_category` = '$food_category', 
                    `food_quantity` = '$food_quantity', 
                    `food_price` = '$food_price', 
                    `food_rating` = '$food_rating',
                    `food_image` = '$food_image',
                    `food_update` = '$food_update'
                    WHERE `id` = '$food_id'";
        } else {
            $sql = "UPDATE `food` SET 
                    `food_name` = '$food_name', 
                    `food_category` = '$food_category', 
                    `food_quantity` = '$food_quantity', 
                    `food_price` = '$food_price', 
                    `food_rating` = '$food_rating',
                    `food_update` = '$food_update'
                    WHERE `id` = '$food_id'";
        }

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Food updated successfully!'); window.location.href = 'manage_food.php';</script>";
        } else {
            echo "<script>alert('Error: {$conn->error}');</script>";
        }
    }
}

// Fetch food for editing if an id is provided
$food_to_edit = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $conn->real_escape_string($_GET['edit_id']);
    $result = $conn->query("SELECT * FROM food WHERE id = '$edit_id'");
    if ($result->num_rows > 0) {
        $food_to_edit = $result->fetch_assoc();
    }
}

// Handle food deletion
if (isset($_POST['delete_food'])) {
    $delete_id = $conn->real_escape_string($_POST['delete_id']);
    $result = $conn->query("SELECT `food_image` FROM `food` WHERE `id` = '$delete_id'");
    if ($result->num_rows > 0) {
        $food = $result->fetch_assoc();
        if (file_exists("../uploads/food/" . $food['food_image'])) {
            unlink("../uploads/food/" . $food['food_image']);
        }
    }
    $conn->query("DELETE FROM `food` WHERE `id` = '$delete_id'");
    echo "<script>alert('Food deleted successfully!'); window.location.href = 'manage_food.php';</script>";
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food - Jomayang Booking System</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <script src="js/managefood.js" defer></script>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="header"><?php echo $food_to_edit ? 'Edit Food' : 'Add New Food'; ?></div>
        <div class="food-form">
            <form method="POST" action="" enctype="multipart/form-data">
                <?php if ($food_to_edit) { ?>
                    <input type="hidden" name="food_id" value="<?php echo $food_to_edit['id']; ?>">
                <?php } ?>
                <div class="form-group">
                    <label for="food_name">Food Name</label>
                    <input type="text" id="food_name" name="food_name" required value="<?php echo $food_to_edit['food_name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="food_category">Food Category</label>
                    <select id="food_category" name="food_category" required>
                        <option hidden value="">Select category</option>
                        <?php
                        $categories = ['Ala Carte', 'Drink', 'Snack', 'Other'];
                        foreach ($categories as $category) {
                            $selected = ($food_to_edit['food_category'] ?? '') === $category ? 'selected' : '';
                            echo "<option value='$category' $selected>$category</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="food_quantity">Quantity</label>
                    <input type="number" id="food_quantity" name="food_quantity" min="1" required value="<?php echo $food_to_edit['food_quantity'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="food_price">Price (RM)</label>
                    <input type="text" id="food_price" name="food_price" pattern="^\d+(\.\d{1,2})?$" required value="<?php echo isset($food_to_edit['food_price']) ? number_format((float)$food_to_edit['food_price'], 2, '.', '') : ''; ?>">
                    <small>Enter a valid price (e.g., 0.00).</small>
                </div>


                <div class="form-group">
                    <label for="food_rating">Rating</label>
                    <input type="number" id="food_rating" name="food_rating" min="1" max="5" required value="<?php echo $food_to_edit['food_rating'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="food_image">Food Image</label>
                    <input type="file" id="food_image" name="food_image" <?php echo !$food_to_edit ? 'required' : ''; ?>>
                    <?php if ($food_to_edit && $food_to_edit['food_image']) { ?>
                        <img src="../uploads/food/<?php echo $food_to_edit['food_image']; ?>" alt="Food Image" width="100">
                    <?php } ?>
                </div>

                <div class="form-group">
                    <button type="submit" name="add_food"><?php echo $food_to_edit ? 'Update Food' : 'Add Food'; ?></button>
                </div>
            </form>
        </div>
        <!-- Foods Table -->
        <h3>Foods List</h3>
        <table>
            <thead>
                <tr>
                    <th>Food Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price (RM)</th>
                    <th>Rating</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM food";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($food = $result->fetch_assoc()) {
                        echo "<tr>
                       <td>{$food['food_name']}</td>
                       <td>{$food['food_category']}</td>
                       <td>{$food['food_quantity']}</td>
                       <td>RM " . number_format($food['food_price'], 2) . "</td>
                       <td>{$food['food_rating']}</td>

                       <td><img src='../uploads/food/{$food['food_image']}' alt='Food Image' width='100'></td>
                       <td>
                           <a href='manage_food.php?edit_id={$food['id']}'>Edit</a> |
                           <form method='POST' action='' style='display:inline;'>
                               <input type='hidden' name='delete_id' value='{$food['id']}'>
                               <button type='submit' name='delete_food'>Delete</button>
                           </form>
                       </td>
                   </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No food added yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>