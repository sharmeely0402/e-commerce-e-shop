<?php

include 'db.php';
include 'dbConfig.php';
include 'Cart.php';

$cart = new Cart;

// Check if product id is passed
if (isset($_GET['id'])) {
    $productID = intval($_GET['id']);

    // Fetch product from database
    $query = $mysqli->query("SELECT * FROM products WHERE id = {$productID}");
    $product = $query->fetch_assoc();

    if ($product) {
        // Prepare item data for cart
        $itemData = array(
            'id'    => $product['id'],
            'name'  => $product['name'],
            'price' => $product['price'],
            'qty'   => 1,
            'image' => $product['Image'] // ✅ include product image
        );

        // Insert item into cart
        $insertItem = $cart->insert($itemData);

        // Redirect to cart page if added successfully
        if ($insertItem) {
            header("Location: viewCart.php");
        } else {
            $_SESSION['message'] = "Failed to add product to cart!";
            header("Location: home.php");
        }
    } else {
        $_SESSION['message'] = "Invalid product!";
        header("Location: home.php");
    }
} else {
    $_SESSION['message'] = "No product selected!";
    header("Location: home.php");
}
exit();
