/*=================== created 09-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/
/** 
 * function to change img uppon hover (logo)
 */
const logoImg = document.getElementById("logoImage");

if (logoImg){
    logoImg.addEventListener("mouseenter", () => {
        logoImg.src = "Img/GameWorldLogo.gif";
    });

        logoImg.addEventListener("mouseleave", () => {
        logoImg.src = "Img/GameWorldLogoHover.png";
    });
}


/**
 * function to change img uppon hover (aboutUs.php)
 */
const aboutImg = document.getElementById("aboutImg");

// hover
if (aboutImg) {
    aboutImg.addEventListener("mouseenter", () => {
        aboutImg.src = "Img/KCD_1.jpg";
        aboutImg.style.width = "190px";
        aboutImg.style.height = "auto";
        aboutImg.style.top = "-310px";
    });

    aboutImg.addEventListener("mouseleave", () => {
        aboutImg.src = "Img/KCD2_1.jpeg";
        aboutImg.style.width = "190px";
        aboutImg.style.height = "auto";
        aboutImg.style.top = "-270px";
    });
}


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


/**
 * function for the slide (product.php)
 */
var CurrentIndex = 0;

function SetMedia(index) {
    var imgEl = document.getElementById("mainProductImage");
    var iframeEl = document.getElementById("mainProductTrailer");
    var thumbnails = document.querySelectorAll(".thumbnail, .trailerThumbnail");

    thumbnails.forEach(function (thumb, i) {
        thumb.classList.toggle("activeThumbnail", i === index);
    });

    var item = MediaItems[index];
    CurrentIndex = index;

    if (item.type === "image") {

        imgEl.src = item.src;
        imgEl.style.display = "block";

        iframeEl.style.display = "none";
        iframeEl.src = "";

    } else {

        iframeEl.src = item.src;
        iframeEl.style.display = "block";

        imgEl.style.display = "none";
    }
}

function PrevMedia() {
    SetMedia((CurrentIndex - 1 + MediaItems.length) % MediaItems.length);
}

function NextMedia() {
    SetMedia((CurrentIndex + 1) % MediaItems.length);
}

document.addEventListener("DOMContentLoaded", function () {
    if (MediaItems.length > 0) {
        SetMedia(0);
    }
});