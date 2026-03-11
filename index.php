<?php
/*============================================================================*/
/*=================== created 02-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/

include("Inc/functions.php");
HTMLhead();
HTMLnavBar();
HTMLcategories();

?>
    <main class="heroSection">
        <h2 class="heroTitle">Welcome to GameWorld</h2>
        <p class="heroSubtitle">Find the best games for PC, PlayStation 5, and Xbox Series X|S</p>
    </main>

    <section id="featuredGames">
        <h2 class="sectionTitle">Featured Games</h2>
        <div class="featuredSection">
            <?php DisplayPopularGames(rand(1, 24)); ?>
        </div>
    </section>
</div>

<?php HTMLfoot(); ?>