const form = document.getElementById('form');
const username = document.getElementById('username');
const password = document.getElementById('password');


function showPopup(message, duration = 2000) {
  const popup = document.getElementById('popup');
  const popupMessage = document.getElementById('popup-message');

  popupMessage.textContent = message;
  popup.classList.remove('hidden');

  // Automatically close the popup after the specified duration
  setTimeout(() => {
    closePopup();
  }, duration);
}

function closePopup() {
  const popup = document.getElementById('popup');
  popup.classList.add('hidden');
}

// Handle form submission
form.addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append('username', username.value.trim());
  formData.append('password', password.value.trim());

  fetch('./connectdb/loginDB.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === 'success') {
        showPopup(data.message);
        setTimeout(() => {
          window.location.href = './index.php'; // Redirect on success
        }, 2000);
      } else {
        showPopup(data.message); // Show error message
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      showPopup('Something went wrong. Please try again.');
      setTimeout(() => {
            popup.classList.add('hidden');
        }, 2000);
    });
});
function goToHome() {
  window.location.href = 'index.php';
}



