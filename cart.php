<?php
/*============================================================================*/
/*=================== created 13-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/

include("Inc/functions.php");
// start session
session_start();

// handle cart operators
if (isset($_POST["add"])) {
    $gameId = intval($_POST["add"]);
    $game = GetGameById($gameId); 

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
        $_SESSION["successMessage"] = "Game added to cart!";
    }
    header("Location: cart.php");
    exit();
}

if (isset($_GET["remove"])){
    if (removeFromCart($_GET["remove"])){
        $_SESSION["successMessage"] = "Item rmoved from cart";
    }
    header("Location: cart.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["quantity"])){
    if (updateCartQuantity($_POST["id"], $_POST["quantity"])){
        $_SESSION["successMessage"] = "Cart updated succesfully";
    }
    header("Location: cart.php");
    exit();
}

/*== include files ==*/ 
HTMLhead();
HTMLnavBar();
HTMLcategories();


if (!empty($_SESSION['cart'])): ?>
<section class="cartSection">
    <div class="cartTableWrapper">
        <table class="cartTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['cart'] as $id => $item):
                $subtotal = $item['price'] * $item['quantity'];
            ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= number_format($item['price'], 2); ?> €</td>
                    <td>
                        <form action="cart.php" method="post" class="quantityForm">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="quantityInput">
                            <button type="submit" class="updateButton">Update</button>
                        </form>
                    </td>
                    <td><?= number_format($subtotal, 2); ?> €</td>
                    <td><a href="cart.php?remove=<?= $id; ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="1"><strong><?= number_format(getCartTotal(), 2); ?> €</strong></td>
                <td>
                    <form action="cart.php" method="GET"><button type="submit" name="order" class="orderButton">Order now</button></form>
                </td>
            </tr>
        </table>
    </section>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>


<?php HTMLfoot(); ?>