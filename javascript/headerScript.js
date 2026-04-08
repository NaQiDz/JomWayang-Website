
document.addEventListener("scroll", function () {
    const header = document.getElementById("mainHeader");
    
    // Add the "scrolled" class when the page is scrolled down 50px or more
    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});
