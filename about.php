<?php
/*============================================================================*/
/*=================== created 27-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/

require_once "Inc/functions.php";

$trailerId = isset($_GET["trailerId"]) ? (int)$_GET["trailerId"] : 1;

HTMLhead();
HTMLnavBar();
HTMLcategories();
?>

<main class="aboutPage">
    <div>
        <section>
            <h2>About GameWorld</h2>
            <p>GameWorld is my chance to show my peers that I have control and initiative in creating and connecting databases. This project is built as part of my MBO niveau 4 studies, where I get to combine my love for gaming with web development.</p>
        </section>

        <section>
            <h2>My Inspiration</h2>

            <div class="aboutImageContainer">
                <p>The inspiration for the colours and design came from the video game Kingdom Come: Deliverance 2. The game has a very distinct medieval atmosphere, which I tried to bring into this website.</p>

                <div class="aboutImageOverlay">
                    <a href="https://www.deepsilver.com/games/kingdom-come-deliverance-ii" target="_blank" class="aboutImageLink">
                        <img src="Img/KCD2_1.jpeg" alt="Screenshot from Kingdom Come: Deliverance 2" class="aboutImage" id="aboutImg">
                    </a>
                </div>
            </div>

            <article>
                <h3>Colour Scheme</h3>
                <p>The colours are based on the earthy, warm tones you see throughout KCD2 — deep browns, muted golds, and dark blues. These match the medieval setting of the game and give the site a serious but inviting feel.</p>
            </article>

            <article>
                <h3>Why I Chose This Game</h3>
                <p>Kingdom Come: Deliverance 2 stood out to me because of its realistic and detailed world. The atmosphere felt like a perfect fit for a project I wanted to be proud of — something that looks good but also has a clear identity.</p>
            </article>

            <article>
                <h3>Future Changes</h3>
                <p></p>
            </article>
        </section>
    </div>

    <aside>
        <div class="sideCard" id="sideCard1">
            <h3>Who Am I</h3>

            <div class="teamCard">
                <img src="" alt="Photo of Gaven Mikkers">
                <h4>Gaven Mikkers</h4>
                <span>MBO niveau 4 student</span>
                <span><h4>Ter AA</h4></span>
            </div>
        </div>

        <div class="sideCard" id="sideCard2">
            <h3>Contact Me</h3>
            <p>Have a question or want to give feedback? Feel free to reach out!</p>
            <br>
            <p><a href="mailto:gaven.mikkers@outlook.com">Email Me</a></p>
            <p><a href="https://www.linkedin.com/in/gaven-mikkers-237191348/">My LinkedIn Profile</a></p>
            <p>Helmond, Netherlands</p>
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