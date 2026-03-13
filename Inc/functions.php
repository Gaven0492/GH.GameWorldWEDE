<?php
/*============================================================================*/
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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="icon" type="image/png" href="Img/GameWorldLogoImage.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>GameWorld</title>
        <link rel="stylesheet" href="Css/style.css">
        <script src="Js/script.js" defer></script>
        <meta charset="UTF-8">
    </head>
<?php
}

/**
 * - Function to add the html navigation bar to the page
 * @return void
 */
function HTMLnavBar()
{
$navigation = GetNavigation(); 

?>
<body>
    <header class="header">
        <div class="headerContainer">
            <div class="headerLogo">
                <a href="index.php" class="gameWorldLogo">
                    <img src="Img/GameWorldLogo.gif" alt="GameWorld Logo" class="logoImage">
                </a>
            </div>
            <nav class="socialMenu">
                <ul>
                    <?php foreach ($navigation as $navItem): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($navItem["navLink"]); ?>">
                                <i class="<?php echo htmlspecialchars($navItem["navIcon"]); ?>"></i>
                                <?php echo htmlspecialchars($navItem["navName"]); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
<?php
}


/**
 * - Function to print the html navigation bar
 */
function HTMLcategories()
{
    $categories = GetCategories();
?>
    <nav>
        <ul class="navMenu" id="navMenu">
            <?php foreach ($categories as $category): ?>
                <?php $color = GetCategoryColor($category["categoryId"]); ?>
                <li style="background-color: <?php echo $color; ?>;">
                    <a href="products.php?categoryId=<?php echo $category["categoryId"]; ?>">
                        <img src="Img/<?php echo htmlspecialchars($category["categoryImg"]); ?>"> <?php echo htmlspecialchars($category["categoryName"]); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
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
</body>
</html>
<?php
}


/*============================================================================*/
/*=========================== Database Connections ===========================*/
/*============================================================================*/

/**
 * function to connect database
 * @return obj $conn
 */
function DbConnect(){
    $servername     =   "localhost";    // location of the database server
    $username       =   "root";         // username to login server
    $password       =   "";             // password to login server
    $dbname         =   "gameworld";    // name of the database    

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


/**
 * function to get navigation from database
 * @return array $navigation
 */
function GetNavigation()
{
    // connect to database
    $db = DbConnect();
    // define sql statements
    $sql = "SELECT * FROM `navigation` ";
    // run query on database 
    $resource = $db->query($sql) or die($db->error);
    // fetch data as associated array
    $navigation = $resource->fetch_all(MYSQLI_ASSOC);
    // close connection
    $db->close();
    // return array navigation
    return $navigation;
}


/**
 * function to fetch all categorys from category table
 * @return array $category
 */

function GetCategories()
{
    // connect to database
    $db = DbConnect();
    // define sql statements
    $sql = "SELECT * FROM `category` ORDER BY `categoryId` ASC";
    // run query on database 
    $resource = $db->query($sql) or die($db->error);
    // fetch data as associated array
    $categories = $resource->fetch_all(MYSQLI_ASSOC);
    // close connection
    $db->close();
    // return array categories
    return $categories;
}


/**
 * function to fetch category from category table defined by categoryId
 * @param int $categoryId
 * @return array $category
 */
function GetCategoryById($categoryId)
{
    $db = DbConnect();
    // define sql statement
    $sql = "SELECT * FROM category WHERE categoryId = " . intval($categoryId);
    $resource = $db->query($sql) or die($db->error);
    // fetch data as associated array
    $category = $resource->fetch_assoc();
    // close connection
    $db->close();
    // return category
    return $category;
}


/**
 * - Function to get color based on category ID
 * @param int $categoryId
 * @return string $color
 */
function GetCategoryColor($categoryId)
{
    $colors = [
        1 => "#9836b6",  // PC 
        2 => "#0042ad",  // PlayStation 
        3 => "#139713",  // Xbox 
        4 => "#E60012",  // Nintendo 
        5 => "#9a69d2",  // PC 
        6 => "#3a84ce",  // Playstation 
        7 => "#8ce072",  // Xbox 
        8 => "#d94b4b",  // Nintendo
    ];
    
    // if category exists, return color,  default purple
    if (isset($colors[$categoryId])) {
        return $colors[$categoryId];
    } else {
        return "#9836b6";  // default purple
    }
}


/**
 * function to fetch games from game table defined by categoryId
 * @param int $categoryId
 * @return array $games
 */
function GetGameByCategory($categoryId)
{
    // connect to database
    $db = DbConnect();
    // the query
    $sql = "SELECT * FROM game WHERE categoryId = " . intval($categoryId);
    // run query
    $resource = $db->query($sql);
    // fetch data as assoc array
    $games = $resource->fetch_all(MYSQLI_ASSOC);
    // close connection
    $db->close();
    // return array of games
    return $games;
}


/**
 * function to fetch games from game table defined by gameId
 * @param int $gameId
 * @return array $gameId
 */
function GetGameById($gameId)
{
    $db = DbConnect();
    $sql = "SELECT * FROM game WHERE gameId = " . intval($gameId);
    $result = $db->query($sql);
    $game = $result->fetch_assoc();
    $db->close();
    return $game;
}

/**
 * - Function to display games based on category
 * @param int $categoryId
 * @return void
 */
function DisplayGames($categoryId)
{
    $category = GetCategoryById($categoryId);
    $games = GetGameByCategory($categoryId);
    $colors = GetCategoryColor($categoryId + 4);

    foreach ($games as $game) {
        ?>
        <article class="card">
            <div class="cardImage" style="background-color: <?php echo $colors; ?>;">
                <div class="categoryLogo">
                    <img src="Img/<?php echo htmlspecialchars($category["categoryImg"]); ?>" alt="<?php echo htmlspecialchars($category["categoryName"]); ?>">
                </div>
                <img src="Img/<?php echo htmlspecialchars($game["gameImg"]); ?>" alt="<?php echo htmlspecialchars($game["gameName"]); ?>">
                <div class="cardPrice">€ <?php echo number_format($game["gamePrice"], 2); ?></div>
            </div>
            
            <div class="cardContent">
                <h3 class="cardTitle"><?php echo htmlspecialchars($game["gameName"]); ?></h3>
                <div class="cardButtons">
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="add" value="<?php echo $game["gameId"]; ?>">
                        <button type="submit" class="cardButton addToCartButton submitButton">
                            <span>
                                <i class="fa fa-plus"></i>
                                <i class="fa-solid fa-cart-shopping"></i>
                            </span>
                        </button>
                    </form>
                    <a href="products.php?categoryId=<?php echo $game["categoryId"]; ?>&gameId=<?php echo $game["gameId"]; ?>"
                    class="cardButton buyNowButton resetButton">
                        <span>Buy Now</span>
                    </a>
                </div>
            </div>
        </article>
        <?php
    }
}


/**
 * Function to display popular games
 */
function DisplayPopularGames() {
    $categories = GetCategories();
    shuffle($categories); // randomize categories
    $categories = array_slice($categories, 0, 4); // take 4 categories

    foreach ($categories as $category) {
        $categoryId = $category["categoryId"];
        $games = GetGameByCategory($categoryId);
        if (empty($games)) {
            continue; // if category has no games
        }

        shuffle($games);
        $game = $games[0]; // pick 1 game
        $colors = GetCategoryColor($categoryId + 4);
        ?>

        <article class="card">
            <div class="cardImage" style="background-color: <?php echo $colors; ?>;">              
                <div class="categoryLogo">
                    <img src="Img/<?php echo htmlspecialchars($category["categoryImg"]); ?>" 
                        alt="<?php echo htmlspecialchars($category["categoryName"]); ?>">
                </div>

                <img src="Img/<?php echo htmlspecialchars($game["gameImg"]); ?>" 
                    alt="<?php echo htmlspecialchars($game["gameName"]); ?>">

                <div class="cardPrice">
                    € <?php echo number_format($game["gamePrice"], 2); ?>
                </div>
            </div>
            
            <div class="cardContent">
                <h3 class="cardTitle"><?php echo htmlspecialchars($game["gameName"]); ?></h3>
                <div class="cardButtons">
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="add" value="<?php echo $game["gameId"]; ?>">
                        <button type="submit" class="cardButton addToCartButton submitButton">
                            <span>
                                <i class="fa fa-plus"></i>
                                <i class="fa-solid fa-cart-shopping"></i>
                            </span>
                        </button>
                    </form>

                    <a href="products.php?categoryId=<?php echo $game["categoryId"]; ?>&gameId=<?php echo $game["gameId"]; ?>"
                    class="cardButton buyNowButton resetButton">
                        <span>Buy Now</span>
                    </a>
                </div>
            </div>
        </article>
        <?php
    }
}


/**
 * Display a single game as a full product detail page
 * @param int $gameId
 * @return void
 */
function DisplaySingleProduct($gameId)
{
    $game = GetGameById($gameId);
    $mediaItems = GetGameImages($gameId); // now returns images + trailers combined

    // fallback if nothing found
    if (empty($mediaItems)) {
        $mediaItems[] = [
            "type" => "image",
            "src"  => "Img/" . $game["gameImg"]
        ];
    }

    $mediaJson = json_encode($mediaItems);
?>
<main>
    <section class="productPage">

        <!-- left side -->
        <div class="productGallery">

            <!-- main display area -->
            <div class="mainImageContainer">
                <button class="galleryButton galleryPrev" onclick="PrevMedia()">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <!-- main image area -->
                <img id="mainProductImage"
                    class="mainProductImage"
                    src="<?php echo htmlspecialchars($mediaItems[0]["src"]); ?>">

                <!-- trailer area, hidden by default -->
                <iframe id="mainProductTrailer"
                    class="mainProductImage"
                    allowfullscreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                </iframe>

                <button class="galleryButton galleryNext" onclick="NextMedia()">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

            <!-- thumbnail row -->
            <div class="thumbnailRow">
                <?php foreach ($mediaItems as $index => $item): ?>
                    <?php if ($item["type"] === "image"): ?>
                        <img class="thumbnail <?php echo $index === 0 ? "activeThumbnail" : ""; ?>"
                            src="<?php echo htmlspecialchars($item["src"]); ?>"
                            onclick="SetMedia(<?php echo $index; ?>)">
                    <?php else: ?>
                        <!-- trailer thumbnail: show a play icon -->
                        <div class="thumbnail trailerThumbnail <?php echo $index === 0 ? "activeThumbnail" : ""; ?>"
                            onclick="SetMedia(<?php echo $index; ?>)">
                            <i class="fa-solid fa-circle-play"></i>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>


    <!-- right side -->
        <div class="productDetails">
            <h1 class="productTitle"> 
                <?php echo htmlspecialchars($game["gameName"]); ?> 
            </h1>

            <div class="priceBox">
                <span class="price">€ <?php echo number_format($game["gamePrice"],2); ?></span>
            </div>

            <p class="productDescription"> 
                <?php echo htmlspecialchars($game["gameDescription"]); ?> 
            </p>

            <div class="productButtons">
                <a href="products.php?categoryId=<?php echo $game['categoryId']; ?>" 
                    id="goBackButton" 
                    class="productButton">
                    <span class="goBackIcon">←</span> Go Back
                </a>

                <form method="POST" action="cart.php">
                    <input type="hidden" name="add" value="<?php echo $game["gameId"]; ?>">
                    <button type="submit" id="productAddToCart" class="productButton">
                        Add To Cart <span> <i class="fa-solid fa-cart-shopping"></i></span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>

<script> 
    var MediaItems = <?php echo $mediaJson; ?>; 
</script>
<script 
    src="js/productGallery.js">
</script>
<?php
}


/**
 * - Function to get all images for a game
 * @param int $gameId
 * @return array $images
 */
function GetGameImages($gameId)
{
    $db = DbConnect();
    $gameId = intval($gameId);

    $items = [];

    // get base game image from game table
    $sqlGame = "SELECT gameImg FROM game WHERE gameId = $gameId";
    $resultGame = $db->query($sqlGame);
    if ($resultGame && $rowGame = $resultGame->fetch_assoc()) {
        $items[] = [
            "type" => "image",
            "src"  => "Img/" . $rowGame["gameImg"]
        ];
    }

    // get trailers
    $sql = "SELECT gameTrailer FROM game WHERE gameId = $gameId";
    $result = $db->query($sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {

            // image
            if (!empty($row["gameImg"])) {
                $items[] = [
                    "type" => "image",
                    "src"  => "Img/" . $row["gameImg"]
                ];
            }

            // trailer
            if (!empty($row["gameTrailer"])) {
                $items[] = [
                    "type" => "trailer",
                    "src"  => ConvertToEmbedURL($row["gameTrailer"])
                ];
            }
        }
    }
    $db->close();
    return $items;
}


/*============================================================================*/
/*============================== Cart Functions ==============================*/
/*============================================================================*/

/**
 * function to add items to cart
 * 
 */
function addToCart($gameId)
{
    $db = DbConnect();
    $statement = $db -> prepare("SELECT gameId, gameName, gameImg, gamePrice FROM game WHERE gameId = ?");
    $statement -> bind_param("i", $gameId);
    $statement -> execute();
    $result = $statement -> get_result();
    $game = $result -> fetch_assoc();
    $statement -> close();
    $db -> close();

    if ($game) {
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        if (isset($_SESSION["cart"][$gameId])) {
            $_SESSION["cart"][$gameId]["quantity"]++;
        } else {
            $_SESSION["cart"][$gameId] = [
                "name" => $game["gameName"],
                "image" => $game["gameImg"],
                "price" => $game["gamePrice"],
                "quantity" => 1
            ];
        }
        return true;
    }
    return false;
}


/**
 * - function to remeove products from cart
 * 
 */
function removeFromCart($gameId)
{
    if (isset($_SESSION["cart"][$gameId])) {
        unset($_SESSION["cart"][$gameId]);
        return true;
    }
    return false;
}

/**
 * - function to update quantity fof cart
 */
function updateCartQuantity($gameId, $quantity)
{
        if (isset($_SESSION["cart"][$gameId])) {
        $_SESSION["cart"][$gameId]["quantity"] = max(1, (int)$quantity);
        return true;
    }
    return false;
}

/**
 * - function to calc total products in cart
 */
function getCartTotal()
{
    $total = 0;
    if (isset($_SESSION["cart"])){
        foreach ($_SESSION["cart"] as $item) {
            $total += $item["price"] * $item["quantity"];
        }
    }
    return $total;
}

/*============================================================================*/
/*======================= Content Functions (About.php) ======================*/
/*============================================================================*/

/**
 * Fetch all about content from the database
 * @return array $content
 */
function GetAboutArticles()
{
    $db = DbConnect();
    $sql = "SELECT * FROM about_content ORDER BY aboutId ASC";
    $result = $db->query($sql);
    $content = $result->fetch_all(MYSQLI_ASSOC);
    $db->close();
    return $content;
}

/**
 * Display only rows where aboutType = "Section"
 * @return void
 */
function DisplaySections()
{
    $allContent = GetAboutArticles();

    foreach ($allContent as $item) {
        if ($item["aboutType"] == "Section") {
            ?>
            <section>
                <h2><?php echo htmlspecialchars($item["aboutName"]); ?></h2>
                <p><?php echo htmlspecialchars($item["aboutText"]); ?></p>
            </section>
            <?php
        }
    }
}

/**
 * Display only rows where aboutType = "Article"
 * @return void
 */
function DisplayArticles()
{
    $allContent = GetAboutArticles();

    foreach ($allContent as $item) {
        if ($item["aboutType"] == "Article") {
            ?>
            <article>
                <h3><?php echo htmlspecialchars($item["aboutName"]); ?></h3>
                <p><?php echo htmlspecialchars($item["aboutText"]); ?></p>
            </article>
            <?php
        }
    }
}

function GetAboutContact(){
    $db = DbConnect();
    $sql = "SELECT * FROM about_contact";
    $result = $db->query($sql);
    $whoami = null;
    $contact = null;
    if ($result) {
        $whoami = $result->fetch_assoc();
        $contact = $result->fetch_assoc();
    }
    
    $db->close();
    return [$whoami, $contact];
}


/*============================================================================*/
/*======================= Trailer Functions (About.php) ======================*/
/*============================================================================*/

/**
 * function to fetch all trailers from trailer table
 * @return array $trailers
 */
function GetAllTrailers()
{
    $db = DbConnect();
    $sql = "SELECT * FROM trailer";
    $result = $db->query($sql);
    $trailers = $result->fetch_all(MYSQLI_ASSOC);
    $db->close();
    return $trailers;
}


/**
 * function to fetch one trailer from trailer table by trailerId
 * @param int $trailerId
 * @return array|null $trailer
 */
function GetTrailerById($trailerId)
{
    $db = DbConnect();
    $statement = $db->prepare("SELECT * FROM trailer WHERE trailerId = ?");
    $statement->bind_param("i", $trailerId);
    $statement->execute();
    $result = $statement->get_result();
    $trailer = $result->fetch_assoc();
    $statement->close();
    $db->close();
    return $trailer;
}


/**
 * function to display trailer video by trailerId
 * @param int $trailerId
 * @return void
 */
function DisplayTrailerVideo($trailerId)
{
    // get the trailer from the database
    $trailer = GetTrailerById($trailerId);

    // stop if no trailer found
    if ($trailer == null || empty($trailer["trailerURL"])) {
        return;
    }

    // convert the YouTube URL to an embed URL
    $embedUrl = ConvertToEmbedURL($trailer["trailerURL"]);
    ?>
    <iframe class="video"
            src="<?php echo $embedUrl; ?>"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen>
    </iframe>
    <?php
}

/**
 * Convert YouTube watch URL to embed URL
 * @param string $url
 * @return string
 */
function ConvertToEmbedURL($url) 
{
    // video ID from YouTube URL
    if (preg_match('/[?&]v=([^&]+)/', $url, $matches)) {
        $videoId = $matches[1];
        return "https://www.youtube.com/embed/" . $videoId;
    }
    // If already an embed URL or invalid return as is
    return $url;
}

?>