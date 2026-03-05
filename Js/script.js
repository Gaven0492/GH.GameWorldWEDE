/*=================== created 09-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/

/**
 * Function to toggle wishlist heart icon
 * @param {HTMLElement} button - The wishlist button that was clicked
 */
function toggleWishlist(button) {
    button.classList.toggle("active");
}


/**
 * function to change img src uppon hover (aboutUs.php)
 */
const img = document.getElementById("aboutImg");

// hover
img.addEventListener("mouseenter", () => {
    img.src = "Img/KCD_1.jpg";
    img.style.width = "190px";
    img.style.height = "auto";
    img.style.top = "-310px";
});

img.addEventListener("mouseleave", () => {
    img.src = "Img/KCD2_1.jpeg";
    img.style.width = "190px";
    img.style.height = "auto";
    img.style.top = "-270px";
});


/**
 * function for the slide (about.php)
 */
let currentSlide = 0;

// get all slides
const slides = document.querySelectorAll(".slide")

// get all dots
const dots = document.querySelectorAll(".dot")

function goToSlide(index){
    // update current slide number
    currentSlide = index;

    // move each slide
    slides.forEach(function(slide){
        slide.style.transform = "translateX(" + (-index * 100) + "%)";
    });

    // update dots
    dots.forEach(function(dot){
        dot.classList.remove("active");
    });
    dots[currentSlide].classList.add("active");
}

function changeSlide(direction) {
    // calc next slide
    let nextSlide = (currentSlide + direction + slides.length) % slides.length;

    goToSlide(nextSlide);
}