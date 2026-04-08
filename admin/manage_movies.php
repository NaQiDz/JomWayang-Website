<?php
// Include database connection file
require 'connect.php';

// Add or update movie in the database
if (isset($_POST['add_movie'])) {
    // Sanitize input
    $title = $conn->real_escape_string($_POST['title']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $release_date = $_POST['release_date'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $description = $conn->real_escape_string($_POST['description']);
    $movie_type = isset($_POST['type']) ? $conn->real_escape_string($_POST['type']) : null;
    $movie_language = isset($_POST['language']) ? $conn->real_escape_string($_POST['language']) : null;
    $director = $conn->real_escape_string($_POST['director']);
    $cast = $conn->real_escape_string($_POST['cast']);
    $title_handler = strtolower(str_replace(' ', '-', $title)); 

    // Function to upload images
    function uploadImage($file, $upload_dir, $filename_prefix) {
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

    $upload_dir_pos = '../uploads/poster/';
    $upload_dir_tit = '../uploads/title/';
    $upload_dir_bg = '../uploads/background/';
    $title_formatted = strtolower(str_replace(' ', '-', $title));

    $image = $imagetitle = $imagebg = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = uploadImage($_FILES['image'], $upload_dir_pos, $title_formatted);
    }
    if (isset($_FILES['imagebg']) && $_FILES['imagebg']['error'] == 0) {
        $imagebg = uploadImage($_FILES['imagebg'], $upload_dir_bg, 'bg-' . $title_formatted);
    }
    if (isset($_FILES['imagetitle']) && $_FILES['imagetitle']['error'] == 0) {
        $imagetitle = uploadImage($_FILES['imagetitle'], $upload_dir_tit, 'title-' . $title_formatted);
    }

    if (!$movie_type || !$movie_language) {
        echo "<script>alert('Please fill in all required fields.');</script>";
        exit;
    } else {
        if (!isset($_POST['movie_id'])) {
            // Add movie if there's no movie ID
            $sql = "INSERT INTO `movies`(`title`, `genre`, `release_date`, `price`, `image`, `imagetitle`, `imagebg`, `duration`, `description`, `type`, `language`, `director`, `cast`, `status`, `handler`) 
                VALUES ('$title', '$genre', '$release_date', '$price', '$image', '$imagetitle', '$imagebg', '$duration', '$description', '$movie_type', '$movie_language', '$director', '$cast', 'yes', '$title_handler')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Movie added successfully!'); window.location.href = 'manage_movies.php';</script>";
            } else {
                echo "<script>alert('Error: {$conn->error}');</script>";
            }
        } else {
            // Update movie if there's a movie ID
            $movie_id = $conn->real_escape_string($_POST['movie_id']);
            if ($image || $imagetitle || $imagebg) {
                $sql = "UPDATE `movies` SET 
                        `title` = '$title', 
                        `genre` = '$genre', 
                        `release_date` = '$release_date', 
                        `price` = '$price', 
                        `image` = '$image',
                        `imagetitle` = '$imagetitle',
                        `imagebg` = '$imagebg',
                        `duration` = '$duration',
                        `description` = '$description',
                        `type` = '$movie_type',
                        `language` = '$movie_language',
                        `director` = '$director',
                        `cast` = '$cast'
                        WHERE `id` = '$movie_id'";
            } else {
                $sql = "UPDATE `movies` SET 
                        `title` = '$title', 
                        `genre` = '$genre', 
                        `release_date` = '$release_date', 
                        `price` = '$price', 
                        `duration` = '$duration',
                        `description` = '$description',
                        `type` = '$movie_type',
                        `language` = '$movie_language',
                        `director` = '$director',
                        `cast` = '$cast'
                        WHERE `id` = '$movie_id'";
            }

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Movie updated successfully!'); window.location.href = 'manage_movies.php';</script>";
            } else {
                echo "<script>alert('Error: {$conn->error}');</script>";
            }
        }
    }
}

// Fetch movie for editing if an id is provided
$movie_to_edit = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $conn->real_escape_string($_GET['edit_id']);
    $result = $conn->query("SELECT * FROM movies WHERE id = '$edit_id'");
    if ($result->num_rows > 0) {
        $movie_to_edit = $result->fetch_assoc();
    }
}

// Handle movie deletion
if (isset($_POST['delete_movie'])) {
    $delete_id = $conn->real_escape_string($_POST['delete_id']);
    $result = $conn->query("SELECT `image`, `imagetitle`, `imagebg` FROM `movies` WHERE `id` = '$delete_id'");
    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
        foreach (['image', 'imagetitle', 'imagebg'] as $img_field) {
            if (file_exists($movie[$img_field])) {
                unlink($movie[$img_field]);
            }
        }
    }
    $conn->query("DELETE FROM `movies` WHERE `id` = '$delete_id'");
    echo "<script>alert('Movie deleted successfully!'); window.location.href = 'manage_movies.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies - Jomayang Booking System</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <script src="js/managemovie.js" defer></script>
</head>
<body>
<?php include 'sidebar.php'; ?>

   <div class="main-content">
       <div class="header"><?php echo $movie_to_edit ? 'Edit Movie' : 'Add New Movie'; ?></div>
       <div class="movie-form">
           <h3><?php echo $movie_to_edit ? 'Edit Movie' : 'Add New Movie'; ?></h3>
           <form method="POST" action="" enctype="multipart/form-data">
               <?php if ($movie_to_edit) { ?>
                   <input type="hidden" name="movie_id" value="<?php echo $movie_to_edit['id']; ?>">
               <?php } ?>
               <div class="form-group">
                   <label for="title">Movie Title</label>
                   <input type="text" id="title" name="title" required value="<?php echo $movie_to_edit['title'] ?? ''; ?>">
               </div>
               <div class="form-group">
                   <label for="genre">Movie Genre</label>
                   <select id="genre" name="genre" required>
                       <option hidden value="">Select genre</option>
                       <?php
                       $genres = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi'];
                       foreach ($genres as $genre) {
                           $selected = ($movie_to_edit['genre'] ?? '') === $genre ? 'selected' : '';
                           echo "<option value='$genre' $selected>$genre</option>";
                       }
                       ?>
                   </select>
               </div>
               <div class="form-group">
                   <label for="release-date">Release Date</label>
                   <input type="date" id="release-date" name="release_date" required value="<?php echo $movie_to_edit['release_date'] ?? ''; ?>">
               </div>
               <div class="form-group">
                   <label for="duration">Duration</label>
                   <input type="number" id="duration" name="duration" min="1" required value="<?php echo $movie_to_edit['duration'] ?? ''; ?>">
               </div>
               <div class="form-group">
                   <label for="description">Description</label>
                   <textarea id="description" name="description" required><?php echo $movie_to_edit['description'] ?? ''; ?></textarea>
               </div>
               <div class="form-group">
                    <label for="type">Movie Type</label>
                    <select id="type" name="type" required>
                        <option hidden value="">Select type</option>
                        <?php
                        $types = [
                            'IF' => 'International Film',
                            'LF' => 'Local Film'
                        ];
                        foreach ($types as $value => $label) {
                            $selected = ($movie_to_edit['type'] ?? '') === $value ? 'selected' : '';
                            echo "<option value='$value' $selected>$label</option>";
                        }
                        ?>
                    </select>
                </div>
               <div class="form-group">
                   <label for="language">Movie Language</label>
                   <input type="text" id="language" name="language" required value="<?php echo $movie_to_edit['language'] ?? ''; ?>">
               </div>
               <div class="form-group">
                   <label for="director">Movie Director</label>
                   <input type="text" id="director" name="director" required value="<?php echo $movie_to_edit['director'] ?? ''; ?>">
               </div>
               <div class="form-group">
                   <label for="cast">Movie Cast</label>
                   <input type="text" id="cast" name="cast" required value="<?php echo $movie_to_edit['cast'] ?? ''; ?>">
               </div>
               <div class="form-group">
                   <label for="price">Price (RM)</label>
                   <input type="number" id="price" name="price" step="0.01" required value="<?php echo $movie_to_edit['price'] ?? ''; ?>">
               </div>
               <div class="form-group">
                   <label for="image">Movie Poster</label>
                   <input type="file" id="image" name="image" <?php echo !$movie_to_edit ? 'required' : ''; ?>>
                   <?php if ($movie_to_edit && $movie_to_edit['image']) { ?>
                       <img src="<?php echo $movie_to_edit['image']; ?>" alt="Image" width="100">
                   <?php } ?>
               </div>
               <div class="form-group">
                   <label for="imagebg">Movie Background</label>
                   <input type="file" id="imagebg" name="imagebg" <?php echo !$movie_to_edit ? 'required' : ''; ?>>
                   <?php if ($movie_to_edit && $movie_to_edit['imagebg']) { ?>
                       <img src="<?php echo $movie_to_edit['imagebg']; ?>" alt="Background Image" width="100">
                   <?php } ?>
               </div>
               <div class="form-group">
                   <label for="imagetitle">Movie Title Image (PNG only)</label>
                   <input type="file" id="imagetitle" name="imagetitle" <?php echo !$movie_to_edit ? 'required' : ''; ?>>
                   <?php if ($movie_to_edit && $movie_to_edit['imagetitle']) { ?>
                       <img src="<?php echo $movie_to_edit['imagetitle']; ?>" alt="Title Image" width="100">
                   <?php } ?>
               </div>
               <div class="form-group">
                   <button type="submit" name="add_movie"><?php echo $movie_to_edit ? 'Update Movie' : 'Add Movie'; ?></button>
               </div>
           </form>
       </div>
       <!-- Movies Table -->
       <h3>Movies List</h3>
       <table>
           <thead>
               <tr>
                   <th>Movie Title</th>
                   <th>Genre</th>
                   <th>Description</th>
                   <th>Release Date</th>
                   <th>Duration</th>
                   <th>Type</th>
                   <th>Language</th>
                   <th>Director</th>
                   <th>Cast</th>
                   <th>Price (RM)</th>
                   <th>Image Poster</th>
                   <th>Image Background</th>
                   <th>Image Title</th>
                   <th>Actions</th>
               </tr>
           </thead>
           <tbody>
               <?php
               $sql = "SELECT * FROM movies";
               $result = $conn->query($sql);

               if ($result->num_rows > 0) {
                   while ($movie = $result->fetch_assoc()) {
                       echo "<tr>
                           <td>{$movie['title']}</td>
                           <td>{$movie['genre']}</td>
                           <td>{$movie['description']}</td>
                           <td>{$movie['release_date']}</td>
                           <td>{$movie['duration']} mins</td>
                           <td>{$movie['type']}</td>
                           <td>{$movie['language']}</td>
                           <td>{$movie['director']}</td>
                           <td>{$movie['cast']}</td>
                           <td>RM " . number_format($movie['price'], 2) . "</td>
                           <td><img src='./uploads/poster/{$movie['image']}' alt='Movie Image' width='100'></td>
                           <td><img src='./uploads/background/{$movie['imagebg']}' alt='Movie Image' width='100'></td>
                           <td><img src='./uploads/title/{$movie['imagetitle']}' alt='Movie Image' width='100'></td>
                           <td>
                               <a href='manage_movies.php?edit_id={$movie['id']}'>Edit</a> |
                               <form method='POST' action='' style='display:inline;'>
                                   <input type='hidden' name='delete_id' value='{$movie['id']}'>
                                   <button type='submit' name='delete_movie'>Delete</button>
                               </form>
                           </td>
                       </tr>";
                   }
               } else {
                   echo "<tr><td colspan='10'>No movies added yet.</td></tr>";
               }
               ?>
           </tbody>
       </table>
   </div>
</body>
</html>
