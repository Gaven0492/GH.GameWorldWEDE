<?php
/*============================================================================*/
/*=================== created 06-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/

include("Inc/functions.php");
HTMLhead();
HTMLnavBar();
HTMLcategories();

$categoryId = $_GET['categoryId'] ?? null;
?>

    <section class="cardSection">
        <?php DisplayGames($categoryId); ?>
    </section>

<?php
HTMLfoot();
?>