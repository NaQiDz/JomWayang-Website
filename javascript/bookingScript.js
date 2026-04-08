document.addEventListener("scroll", function () {
    const header = document.getElementById("mainHeader");

    // Add the "scrolled" class when the page is scrolled down 50px or more
    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});

function toggleDiv() {
    const div = document.getElementById('hiddenDiv');
    // Toggle the display property
    if (div.style.display === 'none' || div.style.display === '') {
        div.style.display = 'block'; // Show the div
        setTimeout(() => {
            div.scrollIntoView({ behavior: 'smooth' }); // Scroll smoothly to the div
        }, 500);
    } else {
        div.style.display = 'none'; // Hide the div
    }
}

const openPopupBtn = document.querySelector('.open-popup-btn');
const popupOverlay = document.getElementById('movie-popup');
const closeBtn = document.querySelector('.close-btn');
const form = document.getElementById('form'); // Get the form element

// Show Popup
openPopupBtn.addEventListener('click', () => {
    popupOverlay.style.display = 'flex';
});

// Close Popup
closeBtn.addEventListener('click', () => {
    popupOverlay.style.display = 'none';
});

// Close Popup when clicking outside the content
popupOverlay.addEventListener('click', (event) => {
    if (event.target === popupOverlay) {
        popupOverlay.style.display = 'none';
    }
});

// --- Seat Selection Logic ---

// Array to store currently selected seats
let selectedSeats = JSON.parse(localStorage.getItem('selectedSeats')) || [];
let bookedSeats = [];

function fetchBookedSeats(date, time, movie_id) {
    console.log("Fetching booked seats for:", date, time, movie_id); // Debugging
    fetch(`./connectdb/get_booked_seats.php?date=${date}&time=${time}&movie_id=${movie_id}`)
        .then(response => response.json())
        .then(data => {
            console.log("Booked seats data received:", data); // Debugging
            bookedSeats = data;
            renderSeats();
        })
        .catch(error => {
            console.error('Error fetching booked seats:', error);
        });
}

function renderSeats() {
    console.log("Rendering seats. Booked seats:", bookedSeats); // Debugging
    document.querySelectorAll('.seat').forEach(seat => {
        const seatValue = seat.value;

        if (bookedSeats.includes(seatValue)) {
            seat.classList.add('sold');
            seat.disabled = true;
        } else if (selectedSeats.includes(seatValue)) {
            seat.classList.add('selected');
            seat.disabled = false; // Allow deselection of selected seats
        } else {
            seat.classList.remove('selected', 'sold');
            seat.disabled = false;
        }
    });
    updateSelectedSeatsDisplay();
}

function updateSelectedSeatsDisplay() {
    document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
}

document.querySelectorAll('.seat').forEach(seat => {
    seat.addEventListener('click', function () {
        const seatValue = this.value;

        if (bookedSeats.includes(seatValue)) {
            return; // Do nothing if seat is booked
        }

        if (selectedSeats.includes(seatValue)) {
            const index = selectedSeats.indexOf(seatValue);
            selectedSeats.splice(index, 1);
            this.classList.remove('selected');
        } else {
            selectedSeats.push(seatValue);
            this.classList.add('selected');
        }

        localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
        updateSelectedSeatsDisplay();
    });
});

// --- Time and Date Selection ---

let selectedDate = '';
let selectedTime = ''; // Store selected time globally

function showTime(button) {
    document.querySelectorAll('.time-slot .button-booking').forEach(btn => {
        btn.classList.remove('clicked');
    });

    button.classList.add('clicked'); // Use add instead of toggle

    selectedTime = button.value; // Update global selectedTime
    document.getElementById('selected-time').textContent = selectedTime;

    console.log("showTime called. Selected Date:", selectedDate, "Selected Time:", selectedTime);

    if (selectedDate && selectedTime) {
        const movieId = document.querySelector('input[name="movie_id"]').value;
        fetchBookedSeats(selectedDate, selectedTime, movieId);
    }
}

function showDate(button) {
    document.querySelectorAll('.booking-slot-datetime .button-booking').forEach(btn => {
        btn.classList.remove('clicked');
    });

    const newSelectedDate = button.value;

    if (selectedDate === newSelectedDate) {
        selectedDate = '';
        document.getElementById('selected-date').textContent = '';
    } else {
        selectedDate = newSelectedDate;
        button.classList.add('clicked');
        document.getElementById('selected-date').textContent = selectedDate;
    }
    
    console.log("showDate called. Selected Date:", selectedDate, "Selected Time:", selectedTime);
    
    // Only fetch booked seats if both date and time are selected
    if (selectedDate && selectedTime) {
        const movieId = document.querySelector('input[name="movie_id"]').value;
        fetchBookedSeats(selectedDate, selectedTime, movieId);
    }
}

// --- Form Submission ---

form.addEventListener('submit', function (e) {
    e.preventDefault();

    const seatspan = document.getElementById('selected-seats').textContent;
    const datespan = document.getElementById('selected-date').textContent;
    const timespan = document.getElementById('selected-time').textContent;

    const seatArray = seatspan.split(',').map(seat => seat.trim());
    const seatCount = seatArray.length;

    // Set values of hidden input fields
    document.getElementById('hidden-seat-no').value = seatArray.join(',');
    document.getElementById('hidden-seat-count').value = seatCount;
    document.getElementById('hidden-date-pick').value = datespan;
    document.getElementById('hidden-time-pick').value = timespan;

    // Check if any seats are selected
    if (seatCount === 0) {
        alert("Please select at least one seat.");
        return; // Stop the form submission
    }

    // Check if date and time are selected
    if (!datespan || !timespan) {
        alert("Please select both a date and a time.");
        return; // Stop the form submission
    }

    // If no validation errors, submit via AJAX
    if (form.querySelectorAll('.form-control.error').length === 0) {
        const formData = new FormData(form);

        fetch('./connectdb/bookingDB.php', {
            method: 'POST',
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'success') {
                // Clear selected seats from localStorage on successful booking
                localStorage.removeItem('selectedSeats');
                // Redirect to the next page
                window.location.href = 'checkoutpage.php';
            } else {
                // Show an error message
                document.getElementById('response-message').textContent = `Error: ${data.message}`;
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            document.getElementById('response-message').textContent = 'Something went wrong. Please try again.';
        });
    }
});