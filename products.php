<?php
/*============================================================================*/
/*=================== created 06-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/

include("Inc/functions.php");
HTMLhead();
HTMLnavBar();
HTMLcategories();

$categoryId = $_GET['categoryId'];

if (isset($_GET["id"])){
    $gameId = $_GET["id"];

    if (addToCart($gameId)){
        $_SESSION["succesMessage"] = "Product added to cart succesfully";
    }else{
        $_SESSION["errorMessage"] = "Product not found";
    }
}else{
    $_SESSION["errorMessage"] = "Invalid product ID";
}
?>

    <section class="cardSection">
        <?php DisplayGames($categoryId); ?>
    </section>

<?php
HTMLfoot();
?>