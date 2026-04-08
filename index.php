<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movie Website/Slideshow</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="css/homepageStyle.css">
</head>
<body>
	<?php
		include 'header.php';
    ?>

	<div class="banner">

		<?php 
        include 'connectdb/dbconnection.php';

        // Get movies with 'yes' status
        $getmovie = mysqli_query($conn, "SELECT * FROM movies WHERE status = 'yes' AND id = 1");

        while ($movie = mysqli_fetch_assoc($getmovie)) {
            $movietitle = $movie['title'];
            $moviegenre = $movie['genre'];
            $moviedesc = $movie['description'];
            $movieredate = $movie['release_date'];
            $movieprice = $movie['price'];
            $movieduration = $movie['duration'];
            $movietype = $movie['type'];
            $movielanguage = $movie['language'];
            $moviehandler = $movie['handler'];
            $movieimage1 = $movie['image'];
            $movieimage2 = $movie['imagetitle'];
            $movieimage3 = $movie['imagebg'];
            $year = date('Y', strtotime($movieredate));
            $hours = floor($movieduration / 60);  // Get the full hours
						$minutes = $movieduration % 60;      // Get the remaining minutes

            echo '
            <div class="content '.$moviehandler.' active">
			        <img src="uploads/title/'.$movieimage2.'" alt="" class="movie-title"/>
			        <h4>
			            <span>'.$year.'</span><span><i>'.$movietype.'</i></span><span>'.$hours.'h '.$minutes.'min</span><span>'.$moviegenre.'</span>
			        </h4>
			        <p>
			            '.$moviedesc.'
			        </p>
			        <div class="button">
			            <a href="#"><i class="fa fa-play" aria-hidden="true"></i> Watch</a>
			            <a href="#"><i class="fa fa-plus" aria-hidden="true"></i> My List</a>
			        </div>
			    </div>';

  } ?>

  <?php 
        include 'connectdb/dbconnection.php';

        // Get movies with 'yes' status
        $getmovie = mysqli_query($conn, "SELECT * FROM movies WHERE status = 'yes' AND id != 1");

        while ($movie = mysqli_fetch_assoc($getmovie)) {
            $movietitle = $movie['title'];
            $moviegenre = $movie['genre'];
            $moviedesc = $movie['description'];
            $movieredate = $movie['release_date'];
            $movieprice = $movie['price'];
            $movieduration = $movie['duration'];
            $movietype = $movie['type'];
            $movielanguage = $movie['language'];
            $moviehandler = $movie['handler'];
            $movieimage1 = $movie['image'];
            $movieimage2 = $movie['imagetitle'];
            $movieimage3 = $movie['imagebg'];
            $year = date('Y', strtotime($movieredate));
            $hours = floor($movieduration / 60);  // Get the full hours
						$minutes = $movieduration % 60;      // Get the remaining minutes

            echo '
            <div class="content '.$moviehandler.'">
			        <img src="uploads/title/'.$movieimage2.'" alt="" class="movie-title"/>
			        <h4>
			            <span>'.$year.'</span><span><i>'.$movietype.'</i></span><span>'.$hours.'h '.$minutes.'min</span><span>'.$moviegenre.'</span>
			        </h4>
			        <p>
			            '.$moviedesc.'
			        </p>
			        <div class="button">
			            <a href="#"><i class="fa fa-play" aria-hidden="true"></i> Watch</a>
			            <a href="#"><i class="fa fa-plus" aria-hidden="true"></i> My List</a>
			        </div>
			    </div>';

  } ?>

    <div class="carousel-box">
        <div class="carousel">

        		<?php 
        include 'connectdb/dbconnection.php';

        // Get movies with 'yes' status
        $getmovie = mysqli_query($conn, "SELECT * FROM movies WHERE status = 'yes' AND id = 1");

        while ($movie = mysqli_fetch_assoc($getmovie)) {
            $movietitle = $movie['title'];
            $moviegenre = $movie['genre'];
            $moviedesc = $movie['description'];
            $movieredate = $movie['release_date'];
            $movieprice = $movie['price'];
            $movieduration = $movie['duration'];
            $movietype = $movie['type'];
            $movielanguage = $movie['language'];
            $moviehandler = $movie['handler'];
            $movieimage1 = $movie['image'];
            $movieimage2 = $movie['imagetitle'];
            $movieimage3 = $movie['imagebg'];

            ?>
            <div class="carousel-item" onclick="changeBg('<?php echo $movieimage3; ?>', '<?php echo strtolower(str_replace(' ', '-', $moviehandler)); ?>');">
						    <img src="./uploads/poster/<?php echo $movieimage1; ?>" alt="<?php echo $movietitle; ?> Poster">
						</div>

  			<?php } ?>
  			<?php 
        include 'connectdb/dbconnection.php';

        // Get movies with 'yes' status
        $getmovie = mysqli_query($conn, "SELECT * FROM movies WHERE status = 'yes' AND id != 1");

        while ($movie = mysqli_fetch_assoc($getmovie)) {
            $movietitle = $movie['title'];
            $moviegenre = $movie['genre'];
            $moviedesc = $movie['description'];
            $movieredate = $movie['release_date'];
            $movieprice = $movie['price'];
            $movieduration = $movie['duration'];
            $movietype = $movie['type'];
            $movielanguage = $movie['language'];
            $moviehandler = $movie['handler'];
            $movieimage1 = $movie['image'];
            $movieimage2 = $movie['imagetitle'];
            $movieimage3 = $movie['imagebg'];

            ?>
            <div class="carousel-item" onclick="changeBg('<?php echo $movieimage3; ?>', '<?php echo strtolower(str_replace(' ', '-', $moviehandler)); ?>');">
						    <img src="./uploads/poster/<?php echo $movieimage1; ?>" alt="<?php echo $movietitle; ?> Poster">
						</div>

  			<?php } ?>
        </div>
    </div>

    <a href="#" class="play"><i class="fa fa-play-circle-o" aria-hidden="true"></i> Watch Trailer</a>

    <ul class="sci">
        <li>
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
        </li>
    </ul>
</div>

	 <div class="container">
      <div class="header-movie-container">
      	<h1 class="title">Showtimes</h1>
      <div class="header-container">        
        <nav class="header-movie-card">
          <ul class="menu">
            <li><a class="active" href="#">Now Showing</a></li>
            <li><a href="#">Today's Movies</a></li>
            <li><a href="#">Coming Soon</a></li>
            <li><a href="#">Latest Movies</a></li>
            <li><a href="#">International Releases</a></li>
          </ul>
        </nav>
      </div>
    </div>
</div>



      <div class="container">
        <section class="movie-gallery" id="movieGallery">

        	<?php

        	// Get movies with 'yes' status
        $getmovie = mysqli_query($conn, "SELECT * FROM movies WHERE status = 'yes'");

        while ($movie = mysqli_fetch_assoc($getmovie)) {
            $movietitle = $movie['title'];
            $moviegenre = $movie['genre'];
            $moviedesc = $movie['description'];
            $movieredate = $movie['release_date'];
            $movieprice = $movie['price'];
            $movieduration = $movie['duration'];
            $movietype = $movie['type'];
            $movielanguage = $movie['language'];
            $moviehandler = $movie['handler'];
            $movieimage1 = $movie['image'];
            $movieimage2 = $movie['imagetitle'];
            $movieimage3 = $movie['imagebg'];

            echo '
            	<div class="movie-card">
		          	<div class="overlay">
							    	<h3>'.$movietitle.'</h3>
							    	<button><a href="bookingpage.php?title='.$moviehandler.'" style="text-docoration:none; color:white;";>Book Now!</a></button>
							  </div>
           		 <img src="uploads/poster/'.$movieimage1.'" alt="'.$movietitle.' Poster">
          		</div>
            ';
          }

            ?>

            <?php

        	// Get movies with 'yes' status
		        $getmovie = mysqli_query($conn, "SELECT * FROM movies WHERE status = 'no'");

		        while ($movie = mysqli_fetch_assoc($getmovie)) {
		            $movietitle = $movie['title'];
		            $moviegenre = $movie['genre'];
		            $moviedesc = $movie['description'];
		            $movieredate = $movie['release_date'];
		            $movieprice = $movie['price'];
		            $movieduration = $movie['duration'];
		            $movietype = $movie['type'];
		            $movielanguage = $movie['language'];
		            $moviehandler = $movie['handler'];
		            $movieimage1 = $movie['image'];
		            $movieimage2 = $movie['imagetitle'];
		            $movieimage3 = $movie['imagebg'];

		            echo '
		            	<div class="movie-card placeholder">
				          	<img src="uploads/poster/'.$movieimage1.'" alt="'.$movietitle.' Poster">
				          </div>
		            ';
		          }

            ?>

        </section>

        <div class="pagination">
          <a href="#" class="page-link" data-page="1">1</a>
          <a href="#" class="page-link" data-page="2">2</a>
          <a href="#" class="page-link" data-page="3">3</a>
          <a href="#" class="page-link" data-page="4">4</a>
        </div>

        <section class="top-movies">
          <h2>Top 10 Movies</h2>
          <ol>
          <?php
						// Assuming you have a table named 'movies' to store movie data
						// Fetch the top 10 movies (you might need to adjust the query based on your ranking criteria)
						$topMoviesQuery = mysqli_query($conn, "SELECT title, handler FROM movies WHERE status='yes' ORDER BY id ASC LIMIT 10");

						$rank = 1;
						while ($topMovie = mysqli_fetch_assoc($topMoviesQuery)) {
						    $movieTitle = $topMovie['title'];
						    $movieHandler = $topMovie['handler'];
						    echo "<li>$rank. $movieTitle <a href=\"bookingpage.php?title=$movieHandler\">More Info</a></li>";
						    $rank++;
						}
					?>
          </ol>
        </section>      
    </div>

	<?php 
		include_once 'footer.php';
	?>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript" src="javascript/homepageScript.js"></script>
</body>

</html>