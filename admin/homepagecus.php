<?php include 'checksession.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket - Customer Home</title>
    <link rel="stylesheet" href="style1.css"> <!-- Link to the CSS stylesheet -->
</head>
<body>

    <header>
        <h1>Welcome to Movie Ticket Booking</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="viewbookings.php">My Bookings</a></li>
                <li><a href="nowshowing.php">Now Showing</a></li>
                <li><a href="upcoming.php">Upcoming Movies</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="now-showing">
            <h2>Now Showing Movies</h2>
            <div class="movie-list">
                <!-- Placeholder for movie posters -->
                <div class="movie-item">
                    <img src="venom.png" alt="Movie 1">
                    <h3>Movie VENOM</h3>
                    <p>Genre: Action</p>
                    <a href="book.php?movie=1" class="book-button">Book Now</a>
                </div>
                <!-- Repeat movie items as necessary -->
            </div>
        </section>

        <section id="upcoming-movies">
            <h2>Now Showing Movies</h2>
            <div class="movie-list">
                <!-- Placeholder for upcoming movie posters -->
                <div class="movie-item">
                    <img src="harry.png" alt="Movie 2">
                    <h3>Movie HARRY POTTER</h3>
                    <p>Genre: Comedy</p>
                    <a href="book.php?movie=1" class="book-button">Book Now</a>
                </div>
                <!-- Repeat upcoming movies as needed -->
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; Movie Ticket Reservation System</p>
    </footer>

</body>
</html>
