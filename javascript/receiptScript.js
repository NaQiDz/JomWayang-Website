document.addEventListener("DOMContentLoaded", function() {
    // Header scroll event listener
    document.addEventListener("scroll", function () {
        const header = document.getElementById("mainHeader");

        if (window.scrollY > 50) {
            header.classList.add("scrolled");
        } else {
            header.classList.remove("scrolled");
        }
    });

    // Start button click event listener
    document.getElementById('startButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get form data
        const form = document.querySelector('form'); // Assuming your button is inside the form
        const formData = new FormData(form);

        // AJAX request to insert data into the database
        fetch('connectdb/checkout_booking.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show popup
                const popup = document.getElementById('popup');
                const countdownElement = document.getElementById('countdown');
                const redirectMessage = document.getElementById('redirectMessage');
                let countdown = 5;
                let delay = 2; 

                // Update order ID in the popup
                document.querySelector('.ticket-id span').textContent = '#' + data.orderId;

                // Show the popup initially
                popup.style.display = 'flex';

                // Set the initial countdown to 5
                countdownElement.innerText = countdown;

                // Start countdown after the delay
                setTimeout(function() {
                    // Show the redirect message when countdown starts
                    redirectMessage.style.display = 'inline';

                    const countdownInterval = setInterval(function() {
                        countdownElement.innerText = countdown;
                        countdown--;

                        if (countdown < 0) {
                            clearInterval(countdownInterval);
                            // Redirect after countdown finishes
                            window.location.href = 'index.php'; // Redirect to your desired page
                        }
                    }, 1000);
                }, delay * 1000);
            } else {
                // Handle error
                alert('Error during checkout: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred during checkout.');
        });
    });
});