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

if (isset($_POST["id"]) && isset($_POST["quantity"])) {
    $id = intval($_POST["id"]);
    $quantity = max(1, intval($_POST["quantity"]));

    if (updateCartQuantity($id, $quantity)) {
        $_SESSION["successMessage"] = "Cart updated successfully";
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
                        <form action="cart.php" method="POST" class="quantityForm">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="number" name="quantity" value="<?= $item["quantity"] ?>" min="1" class="quantityInput" onchange="this.form.submit()">
                        </form>
                    </td>
                    <td>€ <?= number_format($subtotal, 2); ?></td>
                    <td><a id="removeButton" class="cartButton buttonRemove" href="cart.php?remove=<?= $id; ?>"><strong>Remove</strong></a></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>€ <?= number_format(getCartTotal(), 2); ?></strong></td>
                    <td>
                        <form action="cart.php" method="GET" class="orderForm">
                            <button type="submit" name="order" class="cartButton buttonOrder" id="orderButton"><strong>Order now</strong></button>
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