<?php
include 'db.php';
include 'Cart.php';
$cart = new Cart;

// Check login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before rating products!";
    header("location: error.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit();
}

$orderID = $_GET['id'];

// Fetch products in the order
$productsQuery = $mysqli->query("SELECT p.id, p.name, p.Image 
    FROM products p
    JOIN order_items oi ON p.id = oi.product_id
    WHERE oi.order_id = '$orderID'");

$first_name = $_SESSION['first_name'];
$last_name  = $_SESSION['last_name'];
$email      = $_SESSION['email'];
$address    = $_SESSION['address'];
$phone      = $_SESSION['phone'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rate Your Order</title>
    <meta charset="utf-8">
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
        h2 { color:#ff3e6c; margin-bottom:30px; text-align:center; }

        .card { border-radius:12px; overflow:hidden; transition: transform 0.2s ease, box-shadow 0.2s ease; background:#fff; margin-bottom:20px; width:250px; }
        .card:hover { transform: translateY(-5px); box-shadow: 0px 8px 20px rgba(0,0,0,0.15); }
        .card img { width:100%; height:150px; object-fit:cover; }
        .card-title { font-size:18px; font-weight:600; margin-bottom:10px; color:#ff3e6c; }
        .card-text { font-size:14px; color:#555; margin-bottom:5px; }
        .btn-eshop { background-color: #ff3e6c; color:white; }
        .btn-eshop:hover { background-color:#e62e5c; }

        select.form-control { border-radius:6px; border:1px solid #ddd; }
    </style>
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
    <h2>Rate Your Order #<?= htmlspecialchars($orderID); ?></h2>
    <form method="post" action="submit_rating.php">
        <div class="row" style="display:flex; flex-wrap:wrap; justify-content:center; gap:20px;">
        <?php if ($productsQuery->num_rows > 0): ?>
            <?php while ($product = $productsQuery->fetch_assoc()): ?>
                <div class="card">
                    <img src="uploads/<?= !empty($product['Image']) ? $product['Image'] : 'default.jpg'; ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    <div class="caption" style="padding:15px;">
                        <h4 class="card-title"><?= htmlspecialchars($product['name']); ?></h4>
                        <label>Rate this product:</label>
                        <select name="rating[<?= $product['id']; ?>]" class="form-control" required>
                            <option value="">Select Rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; color:#555; font-size:18px;">No products found in this order.</p>
        <?php endif; ?>
        </div>
        <div style="text-align:center; margin-top:20px;">
            <button type="submit" class="btn btn-eshop" style="padding:10px 30px; font-size:18px;">Submit Ratings</button>
        </div>
    </form>
</div>

</body>
</html>
