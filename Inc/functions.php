<?php
/*=================== created 02-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/


/**
 * - Function to add the html head section to the page
 * @return void
 */
function HTMLhead(){
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="author" content="Gaven Mikkers">
        <meta name="description" content="A store where you can buy games for different platforms">
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="Img/mainLogo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GameWorld</title>
        <link rel="stylesheet" href="Css/style.css">
        <script src="Js/script.js" defer></script>
    </head>
<?php
}

/**
 * - Function to add the html navigation bar to the page
 * @return void
 */
function HTMLnavBar()
{
?>
    <header class="header">
        <div class="headerContainer">
            <div class="logo">
                <a href="index.php">
                    <img src="Img/mainLogo.png" alt="GameWorld Logo" class="LogoImage">
                    <h1 class="LogoText">GameWorld</h1>
                </a>
            </div>
            <nav>
                <ul class="navMenu" id="navMenu">
                </ul>
            </nav>
        </div>
    </header>
<?php
}

/**
 * - Function to print the html footer section
 */
function HTMLfoot()
{
?>
        <footer>
            &copy; 2026 GameWorld
        </footer>
</html>
<?php
}
?>

