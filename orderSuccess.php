<?php
session_start();
require 'db.php';

$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : "User";
$order_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : "N/A";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Success - <?= $first_name; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="./js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
body { background: #fff0f2; font-family: 'Titillium Web', sans-serif; margin:0; padding:0; }
.navbar{font-size: 17px; border-radius:0;}
.navbar-brand { color:#e62e5c !important; font-weight:700;}
.badge{font-size: 17px; background-color:#ff3e6c; color:white;}
.container{ max-width: 900px; margin:auto; padding:30px; }
.jumbotron{ background:#fff0f2; border-radius:12px; text-align:center; padding:40px; box-shadow:0px 8px 20px rgba(0,0,0,0.1);}
.jumbotron h1 { color:#ff3e6c; font-weight:700; margin-bottom:20px; }
.jumbotron p { color: #34a853; font-size:18px; }
.btn-eshop { background-color:#ff3e6c; color:white; padding:10px 30px; font-size:16px; border:none; border-radius:8px; }
.btn-eshop:hover { background-color:#e62e5c; color:white; }
</style>
</head>
<body>

<!-- Navbar -->
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
      <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?= htmlspecialchars($first_name); ?></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      <li><a href="viewCart.php" title="View Cart">
        <span class="glyphicon glyphicon-shopping-cart"></span> Cart:
        <span class="badge"><?= isset($_SESSION['cart_contents']) ? count($_SESSION['cart_contents']) - 2 : 0; ?></span>
      </a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="jumbotron">
        <h1>Order Status</h1>
        <p>Your order has been placed successfully!</p>
        <p><strong>Order ID:</strong> #<?= $order_id; ?></p>
        <a href="cartAction.php?action=placeOrder1" class="btn btn-eshop">Go to Review <i class="glyphicon glyphicon-menu-right"></i></a>
        <a href="home.php" class="btn btn-default" style="margin-left:10px;">Continue Shopping</a>
    </div>
</div>

</body>
</html>
