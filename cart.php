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

    if (addToCart($gameId)) {
        $_SESSION["successMessage"] = "Game added to cart!";
    } else {
        $_SESSION["errorMessage"] = "Game not found!";
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
            <?php foreach ($_SESSION["cart"] as $id => $item):
                $subtotal = $item["price"] * $item["quantity"];
            ?>
                <tr>
                    <td class="productCell">
                        <?php
                        $image = $item["image"] ?? "default.jpg";
                        $name  = $item["name"] ?? "Unknown Game";
                        ?>

                        <img src="Img/<?php echo htmlspecialchars($image); ?>" 
                            alt="<?php echo htmlspecialchars($name); ?>" 
                            width="80">
                        <p><?= htmlspecialchars($name); ?></p>
                    </td>
                    <td>€ <?= number_format($item["price"], 2); ?></td>
                    <td>
                        <form action="cart.php" method="post" class="quantityForm">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="number" name="quantity" value="<?= $item["quantity"] ?>" min="1" class="quantityInput">
                            <button type="submit" id="updateButton" class="btn btn-order"><strong>Update</strong></button>
                        </form>
                    </td>
                    <td>€ <?= number_format($subtotal, 2); ?></td>
                    <td><a id="removeButton" class="btn btn-order" href="cart.php?remove=<?= $id; ?>"><strong>Remove</strong></a></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>€ <?= number_format(getCartTotal(), 2); ?></strong></td>
                    <td>
                        <form action="cart.php" method="GET" class="orderForm">
                            <button type="submit" name="order" class="btn btn-order" id="orderButton"><strong>Order now</strong></button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>


<?php HTMLfoot(); ?>