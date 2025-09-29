<?php

include 'dbConfig.php';
include 'Cart.php';

$cart = new Cart;

// Check login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your cart!";
    header("location: error.php");
    exit();
}

// redirect to home if cart is empty
if ($cart->total_items() <= 0) {
    header("Location: home.php");
    exit();
}

// get customer details
$query = $db->query("SELECT * FROM customers WHERE id = " . $_SESSION['sessCustomerID']);
$custRow = $query->fetch_assoc();
$cartItems = $cart->contents();
$first_name = $_SESSION['first_name'];

// Handle address update
$update_msg = '';
if (isset($_POST['updateAddress'])) {
    $new_address = $db->real_escape_string($_POST['address']);
    $update = $db->query("UPDATE customers SET address='$new_address' WHERE id=" . $_SESSION['sessCustomerID']);
    if ($update) {
        $custRow['address'] = $new_address;
        $update_msg = "Address updated successfully!";
    } else {
        $update_msg = "Failed to update address!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - <?= htmlspecialchars($first_name); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="./js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body { background: #fff0f2; font-family: 'Titillium Web', sans-serif; margin:0; padding:0; }
.navbar{font-size: 17px; border-radius:0;}
.navbar-brand { color:#e62e5c !important; font-weight:700;}
.badge{font-size: 17px; background-color:#ff3e6c; color:white;}
.container { max-width:1200px; margin:auto; padding:30px; display:flex; flex-wrap:wrap; gap:20px; }
h1 { width:100%; text-align:center; color:#ff3e6c; margin-bottom:30px; font-weight:700; }

.cart-left { flex:2; display:flex; flex-wrap:wrap; gap:20px; }
.card { width:250px; background:#fff0f2; border-radius:12px; overflow:hidden; transition: transform 0.2s ease, box-shadow 0.2s ease; }
.card:hover { transform: translateY(-5px); box-shadow: 0px 8px 20px rgba(0,0,0,0.15); }
.card img { width:100%; height:150px; object-fit:cover; }
.card-title { font-size:18px; font-weight:600; margin:10px; }
.card-text { font-size:14px; color:#555; margin:5px 10px; }

.cart-right { flex:1; background:white; padding:20px; border-radius:12px; height:max-content; position:sticky; top:30px; }
.cart-right h4 { color:#ff3e6c; margin-bottom:15px; }
.cart-right p { margin:5px 0; font-size:14px; }

.checkout-summary { width:100%; margin-top:30px; text-align:center; }
.btn-eshop { background-color:#ff3e6c; color:white; }
.btn-eshop:hover { background-color:#e62e5c; }
.btn-default { margin-left:10px; }

textarea.form-control { resize:none; }

.alert-msg { margin-bottom:15px; }

@media(max-width:900px){
    .container { flex-direction:column; }
    .cart-right { position:static; width:100%; }
}
</style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid" style="background-color:white;">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">E-Shop</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="home.php">Home</a></li>
      <li><a href="#">Page</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?= htmlspecialchars($first_name)?></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      <li><a href="viewCart.php" title="View Cart">
        <span class="glyphicon glyphicon-shopping-cart"></span> Cart:
        <span class="badge"><?= $cart->total_items();?></span>
      </a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <h1>Order Preview</h1>

    <div class="cart-left">
        <?php foreach($cartItems as $item): ?>
            <div class="card">
                <img src="uploads/<?= !empty($item['Image']) ? $item['Image'] : 'default.jpg'; ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                <h4 class="card-title"><?= htmlspecialchars($item['name']); ?></h4>
                <p class="card-text">Price: Rs. <?= $item['price']; ?></p>
                <p class="card-text">Quantity: <?= $item['qty']; ?></p>
                <p class="card-text">Subtotal: Rs. <?= $item['subtotal']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="cart-right">
        <h4>Shipping Details</h4>
        <?php if(!empty($update_msg)): ?>
            <div class="alert alert-info alert-msg"><?= $update_msg; ?></div>
        <?php endif; ?>
        <form method="post">
            <p><strong>Name:</strong> <?= htmlspecialchars($custRow['first_name'].' '.$custRow['last_name']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($custRow['email']); ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($custRow['phone']); ?></p>
            <p><strong>Address:</strong></p>
            <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($custRow['address']); ?></textarea>
            <button type="submit" name="updateAddress" class="btn btn-eshop" style="margin-top:10px;">Update Address</button>
        </form>
    </div>

    <div class="checkout-summary">
        <h3>Total Items: <?= $cart->total_items(); ?></h3>
        <h3>Total Price: Rs. <?= $cart->total(); ?></h3>
        <a href="cartAction.php?action=placeOrder" class="btn btn-eshop" style="padding:10px 30px; font-size:18px;">Place Order</a>
        <a href="home.php" class="btn btn-default" style="padding:10px 30px; font-size:18px;">Continue Shopping</a>
    </div>
</div>

</body>
</html>
