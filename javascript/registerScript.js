const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const phone = document.getElementById('phone');
const address = document.getElementById('address');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');

// show input error message
function showError(input, message) {
  const formControl = input.parentElement;
  formControl.className = 'form-control error';
  const small = formControl.querySelector('small');
  small.innerText = message;
}

// show success message
function showSuccess(input) {
  const formControl = input.parentElement;
  formControl.className = 'form-control success';
}

// check email is valid
function checkEmail(input) {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (re.test(input.value.trim())) {
    showSuccess(input);
  } else {
    showError(input, 'Email is not valid');
  }
}

// check phone number is valid
function checkPhoneNumber(input) {
  const re = /^[0-9]{11}$/;  // Matches exactly 11 digits
  if (re.test(input.value.trim())) {
    showSuccess(input);
  } else {
    showError(input, 'Phone number not valid');
  }
}

// check required fields
function checkRequired(inputArr) {
  inputArr.forEach(function (input) {
    if (input.value.trim() === '') {
      showError(input, `${getFieldName(input)} is required`);
    } else {
      showSuccess(input);
    }
  });
}

// check input length
function checkLength(input, min, max) {
  if (input.value.length < min) {
    showError(input, `${getFieldName(input)} must be at least ${min} characters`);
  } else if (input.value.length > max) {
    showError(input, `${getFieldName(input)} must be less than ${max} characters`);
  } else {
    showSuccess(input);
  }
}

// check passwords match
function checkPasswordsMatch(input1, input2) {
  if (input1.value !== input2.value) {
    showError(input2, 'Passwords do not match');
  }
}

// Get field name (capitalized)
function getFieldName(input) {
  return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

// Show popup with message
function showPopup(message) {
  const popup = document.getElementById('popup');
  const popupMessage = document.getElementById('popup-message');
  popupMessage.textContent = message;
  popup.classList.remove('hidden');
}

// Close popup
function closePopup() {
  const popup = document.getElementById('popup');
  popup.classList.add('hidden');
}

// Handle form submission
form.addEventListener('submit', function (e) {
  e.preventDefault();  // Prevent the default form submission

  // Validate form fields
  checkRequired([username, email, phone, address, password, password2]);
  checkLength(username, 3, 15);
  checkLength(phone, 11, 12);
  checkLength(address, 3, 90);
  checkLength(password, 6, 25);
  checkEmail(email);
  checkPhoneNumber(phone);
  checkPasswordsMatch(password, password2);

// If no validation errors, submit via AJAX
  if (form.querySelectorAll('.form-control.error').length === 0) {
    const formData = new FormData(form);

    fetch('./connectdb/registerDB.php', {
      method: 'POST',
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        // Show the response in the popup
        showPopup(data);

        if (data.toLowerCase().includes('successful')) {
          // Show success message
          showPopup('Registration successful! \n Redirecting to login page...');
          
          // Clear form fields
          form.reset(); 
          
          // Navigate to login page after 2 seconds
          setTimeout(() => {
            window.location.href = 'login.php';
          }, 2000); // 2000ms = 2 seconds
        }

      })
      .catch((error) => {
        console.error('Error:', error);
        showPopup('Something went wrong. Please try again.');
      });
  }
});

function goToHome() {
  window.location.href = 'index.php';
}
