<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movie Website/Slideshow</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="css/bookingStyle.css">
	<title>Booking Movie</title>
</head>
<body>
	
	<?php 
	include 'connectdb/dbconnection.php';
	include 'header.php';

	$title = $_GET['title'];
	$getmovie = mysqli_query($conn, "SELECT * FROM movies WHERE handler = '$title'");
	$movie = mysqli_fetch_assoc($getmovie);
	$movieid = $movie['id'];
	$movietitle = $movie['title'];
    $moviegenre = $movie['genre'];
    $moviedesc = $movie['description'];
    $movieredate = $movie['release_date'];
    $movieprice = $movie['price'];
    $movieduration = $movie['duration'];
    $movietype = $movie['type'];
    $moviedirector = $movie['director'];
    $moviecast = $movie['cast'];
    $movielanguage = $movie['language'];
    $moviehandler = $movie['handler'];
    $movieimage1 = $movie['image'];
    $movieimage2 = $movie['imagetitle'];
    $movieimage3 = $movie['imagebg'];
    $year = date('Y', strtotime($movieredate));
    $hours = floor($movieduration / 60);  // Get the full hours
	$minutes = $movieduration % 60;      // Get the remaining minutes
	$timestamp = strtotime($movieredate);
	$formattedDate = date('F j, Y', $timestamp);

	if ($movietype == "LF") {
		$movietype2 = "Local";
	}
	if ($movietype == "IF") {
		$movietype2 = "International";
	}

    echo '
    	<div class="banner" style="background-image: url(\'uploads/background/'.$movieimage3.'\'); opacity: 0.5;">
			<div class="overlay">
				<div class="content">
			      <h1>'.$movietitle.'</h1>
			      <div class="details">
			        <span>'.$year.'</span>
			        <span>RM '.$movieprice.'</span>
			        <span>'.$hours.'h '.$minutes.'min</span>
			        <span>'.$moviegenre.'</span>
			        <span>'.$movietype2.'</span>
			      </div>
			      <button onclick="toggleDiv()" >
			        Description
			        <i class="fa fa-caret-down"></i>
			      </button>
			    </div>
			</div>
		</div>

		<div id="hiddenDiv" style="display: none;">
			<div class="synopsis-movie" >
				<div class="content2">
					<h1 class="title2">PLOT</h1>
					<p class="text">
						'.$moviedesc.'
					</p>
					<hr class="divider">
				</div>		
		</div>
		</div>
		

		<div class="plot-movie">
			<div class="content2">
				<h2 class="subtitle">CAST</h2>
				<p class="text">
					<a href="#" class="link">'.$moviecast.'</a>
				</p>
				<div class="grid">
					<div class="grid-item">
						<h3 class="grid-item-title">DIRECTOR</h3>
						<a href="#" class="link">'.$moviedirector.'</a>
					</div>
					<div class="grid-item">
						<h3 class="grid-item-title">RELEASE DATE</h3>
						<p>'.$formattedDate.'</p>
					</div>
					<div class="grid-item">
						<h3 class="grid-item-title">LANGUAGE</h3>
						<p>'.$movielanguage.'</p>
					</div>
				</div>
			</div>
		</div>
    ';
	?>

	<div class="booking-container">
		<div class="booking-slot">
			<div class="border-top"></div>
			<div class="booking-border">
				<div class="booking-border-v2">
					<h2 class="booking-title">DATE SLOT</h2>
					<div class="booking-slot-datetime">
					<?php
// Query to get movie slots
$sql = "
    SELECT 
        movies.id AS movie_id,
        movies.title AS movie_title,
        movie_screenings.show_date,
        movie_screenings.start_time,
        movie_screenings.end_time
    FROM 
        movies
    JOIN 
        movie_screenings 
    ON 
        movies.id = movie_screenings.movie_id
    WHERE 
        movies.id = '$movieid'
";

$getslot = mysqli_query($conn, $sql);

// Function to get the day of the week
function getDayOfWeek($date) {
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    return $dateObj->format('l');
}

// Array to track displayed datesz
$displayedDates = [];

while ($slot = mysqli_fetch_assoc($getslot)) {
    $date = $slot['show_date'];

    // Check if the date has already been displayed
    if (!in_array($date, $displayedDates)) {
        $formattedDate = DateTime::createFromFormat('Y-m-d', $date)->format('M d');

        echo '
			<button class="button-booking" onclick="showTimes(\''.$date.'\'); showDate(this);" value="'.$date.'">
				<p class="booking-title-v2">'.getDayOfWeek($date).'</p>
				<p class="booking-datetime-context">'.$formattedDate.'</p>
			</button>
		';

        // Add the date to the array of displayed dates
        $displayedDates[] = $date;
    }
}
?>

					</div>
				</div>
				<div class="divider2"></div>
				<div class="booking-border-v2">
					<h2 class="booking-title">TIME SLOT</h2>
					<div class="booking-slot-datetime">

							<?php 
								$sql = "SELECT 
										    movies.id AS movie_id,
										    movies.title AS movie_title,
										    movie_screenings.show_date,
										    movie_screenings.start_time,
										    movie_screenings.end_time
										FROM 
										    movies
										JOIN 
										    movie_screenings 
										ON 
										    movies.id = movie_screenings.movie_id
										WHERE 
										    movies.id = '$movieid'";

										    $getslot = mysqli_query($conn, $sql);
								
											function convertTo12HourFormat($time) {
												// Create a DateTime object from the 24-hour format time (with seconds)
												$dateObj = DateTime::createFromFormat('H:i:s', $time);
												
												if ($dateObj === false) {
													return 'Invalid time format'; // Return error if time format is invalid
												}
												
												// Return time in 12-hour format with AM/PM
												return $dateObj->format('g:i');
											}
		
											function getAMPM($time) {
												// Create a DateTime object from the 24-hour format time
												$dateObj = DateTime::createFromFormat('H:i:s', $time);
												
												if ($dateObj === false) {
													return 'Invalid time format'; // Return error if time format is invalid
												}
												
												// Get the AM/PM from the DateTime object
												return $dateObj->format('A');
											}

											while ($slot = mysqli_fetch_assoc($getslot)) {
												$date = $slot['show_date'];
												$time = $slot['start_time'];
												$formattedTime = convertTo12HourFormat($time);
												$amPm = getAMPM($time);
										
												echo '
												<div class="time-slot" data-date="'.$date.'" style="display: none;">
													<button class="button-booking" onclick="showTime(this)" value="'.$time.'">
														<p class="booking-title-v2">'.$formattedTime.'</p>
														<p class="booking-datetime-context">'.$amPm.'</p>
													</button>
												</div>
												';
											}
							 ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="seat-legend">
		<div class="legend-item">
		  <div class="seat-box selected"></div>
		  <p>SELECTED</p>
		</div>
		<div class="legend-item">
		  <div class="seat-box sold"></div>
		  <p>SOLD</p>
		</div>
		<div class="legend-item">
		  <div class="seat-box available"></div>
		  <p>AVAILABLE</p>
		</div>
	  </div>

	<div class="cinema">
		<div class="cinema-layout">
			<div class="screen">SCREEN</div>
			<div class="rows">
				<!-- Repeat this structure for each row -->
				<div class="row">
					<span class="row-label">F</span>
					<div class="seats">
						<button class="seat" value="F1">F1</button>
						<button class="seat" value="F2">F2</button>
						<button class="seat" value="F3">F3</button>
						<button class="seat-blank"></button>
						<button class="seat" value="F4">F4</button>
						<button class="seat" value="F5">F5</button>
						<button class="seat" value="F6">F6</button>
						<button class="seat" value="F7">F7</button>
						<button class="seat" value="F8">F8</button>
						<button class="seat" value="F9">F9</button>
						<button class="seat" value="F10">F10</button>
						<button class="seat" value="F11">F11</button>
						<button class="seat" value="F12">F12</button>
						<button class="seat" value="F13">F13</button>
						<button class="seat-blank"></button>
						<button class="seat" value="F14">F14</button>
						<button class="seat" value="F15">F15</button>
						<button class="seat" value="F16">F16</button>
						<!-- Repeat buttons for seats -->
					</div>
					<span class="row-label">F</span>
				</div>
				<div class="row">
					<span class="row-label">E</span>
					<div class="seats">
						<button class="seat" value="E1">E1</button>
						<button class="seat" value="E2">E2</button>
						<button class="seat" value="E3">E3</button>
						<button class="seat-blank"></b utton>
						<button class="seat" value="E4">E4</button>
						<button class="seat" value="E5">E5</button>
						<button class="seat" value="E6">E6</button>
						<button class="seat" value="E7">E7</button>
						<button class="seat" value="E8">E8</button>
						<button class="seat" value="E9">E9</button>
						<button class="seat" value="E10">E10</button>
						<button class="seat" value="E11">E11</button>
						<button class="seat" value="E12">E12</button>
						<button class="seat" value="E13">E13</button>
						<button class="seat-blank"></button>
						<button class="seat" value="E14">E14</button>
						<button class="seat" value="E15">E15</button>
						<button class="seat" value="E16">E16</button>
						<!-- Repeat buttons for seats -->
					</div>                
					<span class="row-label">E</span>
				</div>
				<div class="row">
				  <span class="row-label">D</span>
				  <div class="seats">
					  <button class="seat" value="D1">D1</button>
					  <button class="seat" value="D2">D2</button>
					  <button class="seat" value="D3">D3</button>
					  <button class="seat-blank"></button>
					  <button class="seat" value="D4">D4</button>
					  <button class="seat" value="D5">D5</button>
					  <button class="seat" value="D6">D6</button>
					  <button class="seat" value="D7">D7</button>
					  <button class="seat" value="D8">D8</button>
					  <button class="seat" value="D9">D9</button>
					  <button class="seat" value="D10">D10</button>
					  <button class="seat" value="D11">D11</button>
					  <button class="seat" value="D12">D12</button>
					  <button class="seat" value="D13">D13</button>
					  <button class="seat-blank"></button>
					  <button class="seat" value="D14">D14</button>
					  <button class="seat" value="D15">D15</button>
					  <button class="seat" value="D16">D16</button>
					  <!-- Repeat buttons for seats -->
				  </div>                
				  <span class="row-label">C</span>
			  </div>
			  <div class="row">
				<span class="row-label">C</span>
				<div class="seats">
					<button class="seat" value="C1">C1</button>
					<button class="seat" value="C2">C2</button>
					<button class="seat" value="C3">C3</button>
					<button class="seat-blank"></button>
					<button class="seat" value="C4">C4</button>
					<button class="seat" value="C5">C5</button>
					<button class="seat" value="C6">C6</button>
					<button class="seat" value="C7">C7</button>
					<button class="seat" value="C8">C8</button>
					<button class="seat" value="C9">C9</button>
					<button class="seat" value="C10">C10</button>
					<button class="seat" value="C11">C11</button>
					<button class="seat" value="C12">C12</button>
					<button class="seat" value="C13">C13</button>
					<button class="seat-blank"></button>
					<button class="seat" value="C14">C14</button>
					<button class="seat" value="C15">C15</button>
					<button class="seat" value="C16">C16</button>
					<!-- Repeat buttons for seats -->
				</div>                
				<span class="row-label">C</span>
			</div>
			<div class="row">
			  <span class="row-label">B</span>
			  <div class="seats">
				  <button class="seat" value="B1">B1</button>
				  <button class="seat" value="B2">B2</button>
				  <button class="seat" value="B3">B3</button>
				  <button class="seat-blank"></button>
				  <button class="seat" value="B4">B4</button>
				  <button class="seat" value="B5">B5</button>
				  <button class="seat" value="B6">B6</button>
				  <button class="seat" value="B7">B7</button>
				  <button class="seat" value="B8">B8</button>
				  <button class="seat" value="B9">B9</button>
				  <button class="seat" value="B10">B10</button>
				  <button class="seat" value="B11">B11</button>
				  <button class="seat" value="B12">B12</button>
				  <button class="seat" value="B13">B13</button>
				  <button class="seat-blank"></button>
				  <button class="seat" value="B14">B14</button>
				  <button class="seat" value="B15">B15</button>
				  <button class="seat" value="B16">B16</button>
			  </div>                
			  <span class="row-label">B</span>
		  </div>
		  <div class="row">
			<span class="row-label">A</span>
			<div class="seats">
				<button class="seat" value="A1">A1</button>
				<button class="seat" value="A2">A2</button>
				<button class="seat" value="A3">A3</button>
				<button class="seat-blank"></button>
				<button class="seat" value="A4">A4</button>
				<button class="seat" value="A5">A5</button>
				<button class="seat" value="A6">A6</button>
				<button class="seat" value="A7">A7</button>
				<button class="seat" value="A8">A8</button>
				<button class="seat" value="A9">A9</button>
				<button class="seat" value="A10">A10</button>
				<button class="seat" value="A11">A11</button>
				<button class="seat" value="A12">A12</button>
				<button class="seat" value="A13">A13</button>
				<button class="seat-blank"></button>
				<button class="seat" value="A14">A14</button>
				<button class="seat" value="A15">A15</button>
				<button class="seat" value="A16">A16</button>
				<!-- Repeat buttons for seats -->
			</div>                
			<span class="row-label">A</span>
		</div>
		
				<!-- Add more rows as needed -->
			</div>
		</div>
	</div>
	<div class="button-submit">
		<button class="submit open-popup-btn">Beli Sekarang</button>	
	</div>

	<?php 

		$sql3 = "SELECT ms.id AS screening_id, ms.movie_id, ms.show_date, ms.start_time, ms.end_time, cs.seat_number, cs.row, cs.status, sc.name AS screen_name FROM movie_screenings ms JOIN cinema_seats cs ON ms.id = cs.screening_id JOIN screens sc ON ms.screen_id = sc.id WHERE ms.movie_id = 3 AND ms.show_date = '2024-12-10' AND ms.start_time = '21:03:24' GROUP BY screen_name;";
		$getScreen = mysqli_query($conn, $sql3);
		$screen = mysqli_fetch_assoc($getScreen);
		$hall = $screen['screen_name'];

		echo '
			<!-- Popup -->
			<div id="movie-popup" class="popup-overlay">
				<div class="popup-container">
					<div class="popup-content">
						<span class="close-btn">×</span>
						<div class="movie-header">
							<img src="uploads/poster/'.$movieimage1.'" alt="'.$movietitle.' Poster" class="movie-poster">
						</div>
						<div class="movie-title">
							<h2>'.$movietitle.'</h2>
							<p>'.$hours.' h '.$minutes.' m • '.$movielanguage.'</p>
							<br>
							<p><strong>'.$movietype.' - '.$movietype2.' Film</strong></p>
							<hr>
							<div class="movie-details">
								<p><strong>Seat:</strong><span id="selected-seats"></span></p>
								<p><strong>Hall:</strong>'.$hall.'</p>
								<p><strong>Time & Date:</strong> <span id="selected-date"></span>, <span id="selected-time"></span></p> 
							</div>
							
						</div>

						'; 
							if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true) {
								$userid = $_SESSION['userid'];

								echo '
								<form id="form">
								    <input type="hidden" id="hidden-seat-no" name="seat_no" value="">
								    <input type="hidden" id="hidden-seat-count" name="seat_count" value="">
								    <input type="hidden" id="hidden-date-pick" name="date_pick" value="">
								    <input type="hidden" id="hidden-time-pick" name="time_pick" value="">
								    <input type="hidden" name="hall" value="'.$hall.'">
								    <input type="hidden" name="user_id"  value="'.$userid.'">
								    <input type="hidden" name="movie_id" value="'.$movieid.'">
								    <button class="select-seats-btn" type="submit">Proceed</button>
								</form>
								

								';
							}else{

								echo '
									<button class="select-seats-btn" type="submit"><a href="login.php" style="text-decoration:none;color: white;">Proceed</a></button>
								';

							}
						?>

						<?php echo'
						<div id="response-message"></div>
						</div>
				</div>
				
			  </div>
		';

	 ?>

	<?php include 'footer.php'; ?>
	

<script type="text/javascript" src="javascript/bookingScript.js"></script>
<script>
	function showTimes(date) {
		// Hide all time slots first
		var timeSlots = document.querySelectorAll('.time-slot');
		timeSlots.forEach(function(slot) {
			slot.style.display = 'none';
		});

		// Show the time slots for the selected date
		var selectedSlots = document.querySelectorAll('.time-slot[data-date="' + date + '"]');
		selectedSlots.forEach(function(slot) {
			slot.style.display = 'block';
		});
	}
</script>
	
</body>

</html>