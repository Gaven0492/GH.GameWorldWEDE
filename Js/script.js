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
    img.style.top = "-150px";
});

img.addEventListener("mouseleave", () => {
    img.src = "Img/KCD2_1.jpeg";
    img.style.width = "190px";
    img.style.height = "auto";
    img.style.top = "-110px";
});