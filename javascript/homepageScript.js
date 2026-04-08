document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.carousel');
  var instances = M.Carousel.init(elems, options);
});

// Or with jQuery

$(document).ready(function(){
  $('.carousel').carousel();
});
function changeBg(imageUrl, movieClass) {
    // Change the background image of the banner
    document.querySelector('.banner').style.backgroundImage = `url(./uploads/background/${imageUrl})`;

    // Remove active class from other movies
    document.querySelectorAll('.content').forEach(content => content.classList.remove('active'));

    // Add active class to the selected movie
    document.querySelector(`.${movieClass}`).classList.add('active');
}

// JavaScript for pagination functionality
document.addEventListener('DOMContentLoaded', function () {
  const itemsPerPage = 8; // Number of items per page (2 columns * 3 rows)
  const movieCards = document.querySelectorAll('.movie-card');
  const totalPages = Math.ceil(movieCards.length / itemsPerPage);
  const paginationLinks = document.querySelectorAll('.page-link');

  function showPage(page) {
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    // Hide all movie cards
    movieCards.forEach(card => card.style.display = 'none');
    
    // Show the cards for the current page
    for (let i = startIndex; i < endIndex; i++) {
      if (movieCards[i]) {
        movieCards[i].style.display = 'block';
      }
    }
  }

  // Initially show the first page
  showPage(1);

  // Event listener for pagination links
  paginationLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const page = parseInt(link.getAttribute('data-page'));
      showPage(page);
      
      // Highlight the active page
      paginationLinks.forEach(l => l.classList.remove('active'));
      link.classList.add('active');
    });
  });
});

document.addEventListener("scroll", function () {
    const header = document.getElementById("mainHeader");
    
    // Add the "scrolled" class when the page is scrolled down 50px or more
    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});
