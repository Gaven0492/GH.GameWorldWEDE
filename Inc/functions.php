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
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="icon" type="image/png" href="Img/GameWorldLogo.png">
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
<body>
    <header class="header">
        <div class="headerContainer">
            <div class="logo glitchCard">
                <a href="index.php" class="glitchEffect">
                    <img src="Img/GameWorldLogo.png" alt="GameWorld Logo" class="LogoImage">
                    <h1 class="LogoText">ameWorld</h1>
                </a>
                <h2 class="LogoSubText">Your Game Store</h2>
            </div>
            <nav class="socialMenu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php"><i class="fa-solid fa-user"></i> Contact</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
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
        1 => "#e61e1e",  // PC 
        2 => "#0066cc",  // PlayStation 
        3 => "#3ab814",  // Xbox 
        4 => "#be3f3f",  // PC 
        5 => "#3a84ce",  // PlayStation 
        6 => "#8ce072",  // Xbox 
    ];
    
    // if category exists, return color,  default purple
    if (isset($colors[$categoryId])) {
        return $colors[$categoryId];
    } else {
        return "#4a4363";  // default purple
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
    $games    = GetGameByCategory($categoryId);
    $colors    = GetCategoryColor($categoryId + 3);

    foreach ($games as $game) {
        ?>
        <article class="card">
            <div class="cardImage" style="background-color: <?php echo $colors; ?>;">
                <div class="categoryLogo">
                    <img src="Img/<?php echo htmlspecialchars($category["categoryImg"]); ?>" alt="<?php echo htmlspecialchars($category["categoryName"]); ?>">
                </div>
                <button class="wishlistButton" onclick="toggleWishlist(this)">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <img src="Img/<?php echo htmlspecialchars($game["gameImg"]); ?>" alt="<?php echo htmlspecialchars($game["gameName"]); ?>">
                <div class="cardPrice">€ <?php echo number_format($game["gamePrice"], 2); ?></div>
            </div>
            
            <div class="cardContent">
                <h3 class="cardTitle"><?php echo htmlspecialchars($game["gameName"]); ?></h3>
                <div class="cardButtons">
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="add" value="<?php echo $game['gameId']; ?>">
                        <button type="submit" class="cardButton addToCartButton submitButton">
                            <span>
                                <i class="fa fa-plus"></i>
                                <i class="fa-solid fa-cart-shopping"></i>
                            </span>
                        </button>
                    </form>
                    <button class="cardButton buyNowButton resetButton">
                        <span>Buy Now</span>
                    </button>
                </div>
            </div>
        </article>
        <?php
    }
}

/**
 * function to add items to cart
 * 
 */
function addToCart($gameId)
{
    $db = DbConnect();
    $statement = $db->prepare("SELECT gameId, gameName, gamePrice FROM game WHERE gameId = ?");
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
?>