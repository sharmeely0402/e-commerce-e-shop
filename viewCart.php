<?php
include 'db.php';
include 'dbConfig.php';
include 'Cart.php';
$cart = new Cart;

// Check login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in to view your cart!";
    header("location: error.php");
    exit();
}

// Customer details
$first_name = $_SESSION['first_name'];
$last_name  = $_SESSION['last_name'];
$email      = $_SESSION['email'];
$address    = $_SESSION['address'];
$phone      = $_SESSION['phone'];

// Cart contents
$contents = $cart->contents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart - <?= htmlspecialchars($first_name) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="./js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body { background: #fff0f2; font-family: 'Arial', sans-serif; }
.navbar { font-size: 17px; border-radius:0; background:white; }
.navbar a { color:#ff3e6c; }
.navbar a:hover { color:#e62e5c; }
.badge { background-color:#ff3e6c; color:white; font-size:17px; }

.container { padding:30px 15px; }
h2 { color:#ff3e6c; text-align:center; margin-bottom:30px; }

.card { border-radius:12px; overflow:hidden; transition: transform 0.2s ease, box-shadow 0.2s ease; background:#fff; margin-bottom:20px; width:250px; }
.card:hover { transform: translateY(-5px); box-shadow: 0px 8px 20px rgba(0,0,0,0.15); }
.card img { width:100%; height:150px; object-fit:cover; }
.card-title { font-size:18px; font-weight:600; margin-bottom:10px; color:#ff3e6c; }
.card-text { font-size:14px; color:#555; margin-bottom:5px; }
.btn-eshop { background-color: #ff3e6c; color:white; border:none; }
.btn-eshop:hover { background-color:#e62e5c; }

.quantity-input { width:60px; display:inline-block; }
.cart-summary { background:white; padding:20px; border-radius:12px; text-align:center; margin-top:20px; }
</style>

<script>
function updateCartItem(obj, id){
    $.get("cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
        if(data == 'ok'){
            location.reload();
        } else {
            alert('Cart update failed, please try again.');
        }
    });
}
</script>
</head>
<body>

<nav class="navbar navbar-inverse">
<div class="container-fluid">
  <div class="navbar-header">
    <a class="navbar-brand" style="color:#ff3e6c;" href="home.php">E-Shop</a>
  </div>
  <ul class="nav navbar-nav navbar-right">
    <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?= htmlspecialchars($first_name) ?></a></li>
    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    <li><a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
    <li><a href="viewCart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart: <span class="badge"><?= $cart->total_items(); ?></span></a></li>
  </ul>
</div>
</nav>

<div class="container">
  <h2>Your Shopping Cart</h2>

  <?php if (empty($contents)): ?>
      <p style="text-align:center; color:#555; font-size:18px;">Your cart is empty!</p>
      <div style="text-align:center; margin-top:20px;">
        <a href="home.php" class="btn btn-eshop">Continue Shopping</a>
      </div>
  <?php else: ?>
      <div class="row" style="display:flex; flex-wrap:wrap; justify-content:center; gap:20px;">
      <?php
      $keys = array_keys($contents);
      $i = 0;
      while ($i < count($contents)):
          $item = $contents[$keys[$i]];
      ?>
        <div class="card">
<img src="uploads/<?= !empty($item['image']) ? htmlspecialchars($item['image']).'.jpg' : 'default.jpg'; ?>" 
     alt="<?= htmlspecialchars($item['name']); ?>">
            <div class="caption" style="padding:15px;">
                <h4 class="card-title"><?= htmlspecialchars($item['name']); ?></h4>
                <p class="card-text">Price: Rs. <?= htmlspecialchars($item['price']); ?></p>
                <p class="card-text">Quantity: 
                  <input type="number" class="quantity-input form-control" min="1" value="<?= htmlspecialchars($item['qty']); ?>" onchange="updateCartItem(this,'<?= $item['rowid']; ?>')">
                </p>
                <p class="card-text">Subtotal: Rs. <?= htmlspecialchars($item['subtotal']); ?></p>
                <div style="text-align:right; margin-top:10px;">
                    <a href="cartAction.php?action=removeCartItem&id=<?= $item['rowid']; ?>" class="btn btn-eshop" style="background:#e62e5c;">Remove</a>
                </div>
            </div>
        </div>
      <?php
          $i++;
      endwhile;
      ?>
      </div>

      <div class="cart-summary">
        <h3>Total Items: <?= $cart->total_items(); ?></h3>
        <h3>Total Price: Rs. <?= $cart->total(); ?></h3>
        <a href="checkout.php" class="btn btn-eshop" style="padding:10px 30px; font-size:18px;">Proceed to Checkout</a>
        <a href="home.php" class="btn btn-default" style="padding:10px 30px; font-size:18px; margin-left:10px;">Continue Shopping</a>
      </div>
  <?php endif; ?>
</div>

</body>
</html>
