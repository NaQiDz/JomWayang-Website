// script.js

// Example: Alert when a movie is added or updated
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    if (form) {
        form.addEventListener("submit", function (event) {
            const titleInput = document.getElementById("title").value.trim();
            if (!titleInput) {
                alert("Please fill in the movie title.");
                event.preventDefault(); // Prevent form submission
            }
        });
    }
});
