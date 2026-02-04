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
        <link rel="icon" type="image/png" href="Img/.png">
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
            <div class="logo">
                <a href="index.php">
                    <img src="Img/.png" alt="GameWorld Logo" class="LogoImage">
                    <h1 class="LogoText">GameWorld</h1>
                </a>
                <h2 class="LogoSubText">Your Game Store</h2>
            </div>
            <nav class="socialMenu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#"><i class="fa-solid fa-user"></i> Contact</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>
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
                <?php $color = GetCategoryColor($category['categoryId']); ?>
                <li style="background-color: <?php echo $color; ?>;">
                    <a href="games.php?categoryId=<?php echo $category['categoryId']; ?>">
                        <?php echo htmlspecialchars($category['categoryName']); ?>
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
        4 => "#c05555",  // PC 
        5 => "#3a84ce",  // PlayStation 
        6 => "#8ce072",  // Xbox 
    ];
    
    // if category exists, return its color, otherwise return default purple
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
 * - Function to display games based on category
 * @param int $categoryId
 * @return void
 */
function DisplayGames($categoryId)
{
    $games = GetGameByCategory($categoryId);
    $colors = GetCategoryColor($categoryId + 3);

    foreach ($games as $game) {
        ?>
        <article class="card">
            <div class="cardImage" style="background-color: <?php echo $colors; ?>;">
                <img src="Img/<?php echo htmlspecialchars($game['gameImg']); ?>" alt="<?php echo htmlspecialchars($game['gameName']); ?>">
            </div>
            <div class="cardContent" >
                <h3 class="cardTitle"><?php echo htmlspecialchars($game['gameName']); ?></h3>
                <p class="cardPrice">$<?php echo number_format($game['gamePrice'], 2); ?></p>
                <button class="cardButton">Buy Now</button>
            </div>
        </article>
        <?php
    }
}
?>

