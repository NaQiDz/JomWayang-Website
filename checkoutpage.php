<?php 
    include 'connectdb/dbconnection.php';
    session_start();
    if (isset($_SESSION['slotgain']) && $_SESSION['slotgain'] == true) {
      $slotgain = true;
      $slotid = $_SESSION['slotid'];

      $sql = "SELECT * FROM holder_booking WHERE id = '$slotid'";
      $getslot = mysqli_query($conn, $sql);
      $slot = mysqli_fetch_assoc($getslot);
      $seatno = $slot['seat_no'];
      $count = $slot['seat_count'];
      $datepick = $slot['date_pick'];
      $timepick = $slot['time_pick'];
      $hall = $slot['hall'];
      $user = $slot['user_id'];
      $movie = $slot['movie_id'];

      $sql2 = "SELECT * FROM movies WHERE id = '$movie'";
      $getmovie = mysqli_query($conn, $sql2);
      $movies = mysqli_fetch_assoc($getmovie);
      $movieid = $movies['id'];
      $movietitle = $movies['title'];
      $moviegenre = $movies['genre'];
      $moviedesc = $movies['description'];
      $movieredate = $movies['release_date'];
      $movieprice = $movies['price'];
      $movieduration = $movies['duration'];
      $movietype = $movies['type'];
      $moviedirector = $movies['director'];
      $moviecast = $movies['cast'];
      $movielanguage = $movies['language'];
      $moviehandler = $movies['handler'];
      $movieimage1 = $movies['image'];
      $movieimage2 = $movies['imagetitle'];
      $movieimage3 = $movies['imagebg'];
      $year = date('Y', strtotime($movieredate));
      $hours = floor($movieduration / 60);  // Get the full hours
      $minutes = $movieduration % 60;      // Get the remaining minutes
      $timestamp = strtotime($movieredate);
      $formattedDate = date('F j, Y', $timestamp);

      $price = $movieprice * $count;

      if ($movietype == "LF") {
        $movietype2 = "Local";
      }
      if ($movietype == "IF") {
        $movietype2 = "International";
      }
      $formattedDate = DateTime::createFromFormat('Y-m-d', $datepick)->format('M d');

      function getDayOfWeek($datepick) {
        $dateObj = DateTime::createFromFormat('Y-m-d', $datepick);
        return $dateObj->format('l');
      }
      $day = getDayOfWeek($datepick);

      function convertTo12HourFormat($timepick) {
        // Create a DateTime object from the 24-hour format time (with seconds)
        $dateObj = DateTime::createFromFormat('H:i:s', $timepick);
                      
        if ($dateObj === false) {
          return 'Invalid time format'; // Return error if time format is invalid
        }
                      
        // Return time in 12-hour format with AM/PM
        return $dateObj->format('g:i');
      }

      function getAMPM($timepick) {
        // Create a DateTime object from the 24-hour format time
        $dateObj = DateTime::createFromFormat('H:i:s', $timepick);
                      
        if ($dateObj === false) {
          return 'Invalid time format'; // Return error if time format is invalid
        }
                      
        // Get the AM/PM from the DateTime object
        return $dateObj->format('A');
      }

      $formattedTime = convertTo12HourFormat($timepick); // Converts to 12-hour format with AM/PM
      $amPm = getAMPM($timepick); // Gets AM/PM

    }
    else{
      $slotgain = false;
      $slotid = 0;
      header("Location: index.php");
    }
          
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
     <link rel="stylesheet" href="css/checkoutStyle.css">
     <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
</head>
<body>
    <i id="back"></i>
  
    <?php 
      include 'header.php';
     ?>

    <div class="banner" style="background-image: url('img/background3.jpg');">
    <div class="overlay">
            <div class="ticket-layout">
               <div class="ticket-container">
                    <?php 
                        echo '
                        <div class="poster">
                          <img src="uploads/poster/'.$movieimage1.'" alt="Movie Poster">
                          </div>
                          <div class="details">
                            <h1>'.$movietitle.'</h1>
                            <p>'.$year.' | '.$movielanguage.' | '.$hours.' h '.$minutes.' m | '.$movietype2.'</p>
                            <div class="sub-details">
                                <p><strong>Hall:</strong> '.$hall.'</p>
                                <p><strong>Time & Date:</strong> '.$day.' '.$formattedDate.', '.$formattedTime.' '.$amPm.'</p>
                                <p style="font-size:16px; font-weight:800;"><strong>Price: RM</strong> '.$movieprice.' x '.$count.'</p>
                            </div>
                            </div>
                            <div class="info-icons">
                            <div class="info-item">
                                <img src="https://via.placeholder.com/20x20.png?text=🎟" alt="Seat Icon">
                                <span>'.$seatno.'</span>
                            </div>
                            <div class="info-item">
                                <img src="https://via.placeholder.com/20x20.png?text=👤" alt="User Icon">
                                <span>Adult x '.$count.'</span>
                            </div>
                        ';
                     ?>

                    
                    </div>  
                </div> 
            </div>
    </div>
  </div>

    <div class="container" style="margin-top: 30px;">
        <!-- Navigation Bar -->
        <div class="nav-select" id="topseler">
            <a href="#topseler">Top Sellers</a>
            <a href="#alacarte">Ala Carte</a>
            <a href="#drinks">Drinks</a>
            <a href="#snacks">Snacks</a>
            <a href="#others">Others</a>
          </div>
    </div>

    <?php
    // Function to display food items
    function displayFoodItems($conn, $category, $isTopSeller = false, $limit = null) {
        if ($isTopSeller) {
            // Top Sellers: Get top 8 by rating, regardless of category
            $sql = "SELECT * FROM food WHERE food_quantity > 0 ORDER BY food_rating DESC LIMIT 6";
        } else {
            $sql = "SELECT * FROM food WHERE food_category = '$category' AND food_quantity > 0";
            if ($category == 'Top Sellers') {
                $sql .= " AND food_rating >= 4"; // Keep this condition if you want a minimum rating for non-top-seller items in this section
            }
            $sql .= " ORDER BY food_rating DESC"; // You can choose to order by rating within each category as well
            if ($limit) {
                $sql .= " LIMIT $limit";
            }
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="product" data-food-id="' . $row['id'] . '" data-food-name="' . $row['food_name'] . '">'; // Added data attributes
              echo '<div class="product-content">';
              echo '<img alt="' . $row['food_name'] . '" src="uploads/food/' . $row['food_image'] . '"/>';
              echo '<div class="product-details">';
              echo '<h3>' . $row['food_name'] . '</h3>';
              echo '<div class="price">';
              echo '<span style="color:white;text-weight:bold;font-size: 14px;">RM ' . number_format((double)$row['food_price'], 2) . '</span>';
              echo '</div>';
              echo '<div class="quantity">';
              echo '<button class="quantity-btn minus">-</button>'; // Added class names for easier selection
              echo '<span class="count">0</span>';
              echo '<button class="quantity-btn plus">+</button>'; // Added class names for easier selection
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
          }
      } else {
            echo "<p>No items found for $category.</p>";
        }
    }
    ?>

    <div class="container2" >
        <!-- Products Section -->
         <!-- Highlight Section -->
         <div class="highlight" >Top Sellers</div>
        <div class="products">
            <?php displayFoodItems($conn, 'Top Sellers', true); // Note the 'true' for isTopSeller ?>
        </div>
    </div>

    <div class="border-top" id="alacarte"></div>

    <div class="container2">
        <div class="highlight">Ala Carte</div>
        <div class="products">
            <?php displayFoodItems($conn, 'Ala Carte'); ?>
        </div>
    </div>

    <div class="border-top" id="drinks"></div>

    <div class="container2">
        <div class="highlight">Drinks</div>
        <div class="products">
            <?php displayFoodItems($conn, 'Drink'); ?>
        </div>
    </div>

    <div class="border-top" id="snacks"></div>

    <div class="container2">
        <div class="highlight">Snacks</div>
        <div class="products">
            <?php displayFoodItems($conn, 'Snack'); ?>
        </div>
    </div>

    <div class="border-top" id="others"></div>

    <div class="container2">
        <div class="highlight">Others</div>
        <div class="products">
            <?php displayFoodItems($conn, 'Other'); ?>
        </div>
    </div>
          
    <!-- Bottom Bar -->
    <div class="bottom-bar">
        <div class="bottom-bar-left">
            <strong>Total</strong>
        </div>
        <form id="checkoutForm" action="update_booking.php" method="post">
            <div class="bottom-bar-right">
                <button type="submit" class="checkout-button">
                    <span id="totalPriceDisplay" style="text-decoration: none; color: white; font-weight: 700;">RM 0.00</span>
                </button>
            </div>
            <input type="hidden" name="selectedFoods" id="selectedFoods" value="">
        </form>
    </div>

    <!--Back Buttom-->
    <div class="circle-bar">
        <div class="bottom-bar-circle">
            <a class="back-buttom" href="#back"><i class="fa fa-arrow-up"></i></a>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
    document.addEventListener("scroll", function () {
        // ... header scroll code ...
    });

    // Declare products outside so it's accessible globally
    const products = document.querySelectorAll('.product');

    document.addEventListener('DOMContentLoaded', function() {
        const totalItemsElement = document.querySelector('.bottom-bar-left strong');
        const totalPriceElement = document.querySelector('.bottom-bar-right .checkout-button #totalPriceDisplay'); // Correct selector

        function updateTotal() {
            let totalItems = 0;
            let totalPrice = parseFloat(<?php echo $price; ?>);

            products.forEach(product => {
                const quantityElement = product.querySelector('.quantity .count');
                const quantity = parseInt(quantityElement.textContent);
                totalItems += quantity;

                if (quantity > 0) {
                    const priceElement = product.querySelector('.price span');
                    const priceText = priceElement.textContent.replace('RM ', '');
                    const price = parseFloat(priceText);
                    totalPrice += price * quantity;
                }
            });

            totalItemsElement.textContent = `Total - ${totalItems} item(s)`;
            totalPriceElement.textContent = `RM ${totalPrice.toFixed(2)}`; // Update the <span>
        }

        products.forEach(product => {
            const quantityButtons = product.querySelectorAll('.quantity button');
            const quantityElement = product.querySelector('.quantity .count');

            quantityButtons.forEach(button => {
                button.addEventListener('click', function() {
                    let currentCount = parseInt(quantityElement.textContent);
                    if (this.textContent === '+') {
                        quantityElement.textContent = currentCount + 1;
                    } else if (this.textContent === '-') {
                        if (currentCount > 0) {
                            quantityElement.textContent = currentCount - 1;
                        }
                    }
                    updateTotal();
                });
            });
        });

        updateTotal(); // Initial update

        const checkoutForm = document.getElementById('checkoutForm');
        const selectedFoodsInput = document.getElementById('selectedFoods');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');

        checkoutForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const selectedFoods = [];
            products.forEach(product => { // Now products is accessible here
                const quantityElement = product.querySelector('.quantity .count');
                const quantity = parseInt(quantityElement.textContent);
                if (quantity > 0) {
                    const foodId = product.dataset.foodId;
                    const foodName = product.dataset.foodName;
                    selectedFoods.push({
                        id: foodId,
                        name: foodName,
                        quantity: quantity
                    });
                }
            });

            selectedFoodsInput.value = JSON.stringify(selectedFoods);

            // AJAX form submission
            const formData = new FormData(checkoutForm);

            fetch('connectdb/update_booking.php', { // Correct the path if necessary
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Success:', data);
                window.location.href = 'receiptpage.php';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error processing your order. Please try again.');
            });
        });
    });
</script>

</body>
</html>