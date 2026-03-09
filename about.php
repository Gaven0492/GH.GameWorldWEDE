<?php
/*============================================================================*/
/*=================== created 27-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/

require_once "Inc/functions.php";

$trailerId = isset($_GET["trailerId"]) ? (int)$_GET["trailerId"] : 1;
$aboutIds = [1, 2, 3];

list($whoami, $contact) = GetAboutContact();

HTMLhead();
HTMLnavBar();
HTMLcategories();
?>

<main class="aboutPage">
    <div>
        <div class="aboutContentAlign">
            <?php DisplaySections(); ?>
            <div class="aboutImageContainer">
                <div class="aboutImageOverlay">
                    <a href="https://www.deepsilver.com/games/kingdom-come-deliverance-ii" target="_blank" class="aboutImageLink">
                        <img src="Img/KCD2_1.jpeg" alt="Screenshot from Kingdom Come: Deliverance 2" class="aboutImage" id="aboutImg">
                    </a>
                </div>
            </div>
        </div>
        <section> <?php DisplayArticles(); ?> </section>
    </div>

    <aside>
        <div class="sideCard" id="sideCard1"> 
            <h3><?= $whoami['contactTitle']; ?></h3> 
            <div class="teamCard"> 
                <img src="images/<?= $whoami['contactImg']; ?>" alt="Photo of Gaven Mikkers"> 
                <h4><?= $whoami['contactText1']; ?></h4> 
                <span><?= $whoami['contactText2']; ?></span>
                <span><h4><?= $whoami['contactLink1']; ?></h4></span> 
            </div> 
        </div> 

        <div class="sideCard" id="sideCard2">
            <h3><?= $contact['contactTitle']; ?></h3>
            <p><?= $contact['contactText1']; ?></p>
            <br>
            <p><a href="<?= $contact['contactLink1']; ?>">Email Me</a></p>
            <p><a href="<?= $contact['contactLink2']; ?>">My LinkedIn Profile</a></p>
            <p><?= $contact['contactText2']; ?></p>
        </div>
    </aside>

    <section class="trailerSection">
        <div class="sliderWrapper">
            <button class="sliderArrow leftArrow" onclick="changeSlide(-1)"><</button>
            <div class="sliderTrack">
                <?php 
                $trailerIds = [1, 2];
                foreach ($trailerIds as $trailerId) { ?>
                    <div class="slide">
                        <?php DisplayTrailerVideo($trailerId); ?>
                    </div>
                <?php } ?>
            </div>
            <button class="sliderArrow rightArrow" onclick="changeSlide(1)">></button>
        </div>

        <div class="sliderDots">
            <span class="dot active" onclick="goToSlide(0)"></span>
            <span class="dot" onclick="goToSlide(1)"></span>
        </div>
    </section>
</main>


<?php HTMLfoot(); ?>