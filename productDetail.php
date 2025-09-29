<?php
session_start();
include 'dbConfig.php';
include 'Cart.php';
$cart = new Cart;

// Check login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in to view product details!";
    header("location: error.php");
    exit();
}

$product_id = $_GET['id'] ?? null;
$customer_id = $_SESSION['customer_id'];

if (!$product_id) {
    header("location: home.php");
    exit();
}

// Fetch product info
$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Product not found!";
    exit();
}

// Fetch reviews
$reviewsQuery = $db->prepare("
    SELECT r.rating, r.review, r.created_at, c.first_name, c.last_name
    FROM reviews r
    JOIN customers c ON r.user_id = c.id
    WHERE r.product_id = ?
    ORDER BY r.created_at DESC
");
$reviewsQuery->bind_param("i", $product_id);
$reviewsQuery->execute();
$reviews = $reviewsQuery->get_result();

// Check if customer purchased this product
$purchaseCheck = $db->prepare("
    SELECT COUNT(*) as bought
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    WHERE o.customer_id = ? AND oi.product_id = ?
");
$purchaseCheck->bind_param("ii", $customer_id, $product_id);
$purchaseCheck->execute();
$purchaseResult = $purchaseCheck->get_result()->fetch_assoc();
$can_review = ($purchaseResult['bought'] > 0);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($product['name']); ?> - E-Shop</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="./js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
body { font-family: Arial, sans-serif; background:#fff0f2; }
.navbar { font-size: 17px; border-radius:0; background:white; }
.navbar a { color:#ff3e6c; }
.navbar a:hover { color:#e62e5c; }
.badge { background-color:#ff3e6c; color:white; }

.product-detail { display:flex; flex-wrap:wrap; gap:30px; margin:30px; }
.product-detail img { max-width:400px; width:100%; border-radius:12px; object-fit:cover; }
.product-info { max-width:600px; }
.product-info h2 { color:#ff3e6c; margin-bottom:20px; }
.product-info .price { font-size:22px; font-weight:bold; color:#e62e5c; margin-bottom:10px; }
.btn-eshop { background-color: #ff3e6c; color:white; border:none; padding:10px 20px; border-radius:8px; }
.btn-eshop:hover { background-color:#e62e5c; }

.review-section { margin-top:40px; }
.review { border-bottom:1px solid #ddd; padding:10px 0; }
.review .reviewer { font-weight:bold; }
.review .rating { color:#e62e5c; }
textarea.form-control { resize:none; }
</style>
</head>
<body>

<nav class="navbar navbar-inverse">
<div class="container-fluid">
  <div class="navbar-header">
    <a class="navbar-brand" style="color:#ff3e6c;" href="home.php">E-Shop</a>
  </div>
  <ul class="nav navbar-nav navbar-right">
    <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?= htmlspecialchars($_SESSION['first_name']); ?></a></li>
    <li><a href="viewCart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart: <span class="badge"><?= $cart->total_items(); ?></span></a></li>
    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
  </ul>
</div>
</nav>

<div class="container product-detail">
    <img src="uploads/<?= !empty($product['Image']) ? $product['Image'] : 'default.jpg'; ?>" alt="<?= htmlspecialchars($product['name']); ?>">
    
    <div class="product-info">
        <h2><?= htmlspecialchars($product['name']); ?></h2>
        <div class="price">Rs. <?= htmlspecialchars($product['price']); ?></div>
        <p><?= htmlspecialchars($product['description']); ?></p>
        <a href="cartAction.php?action=addToCart&id=<?= $product['id']; ?>" class="btn btn-eshop">Add to Cart</a>
    </div>
</div>

<div class="container review-section">
    <h3>Reviews</h3>
    
    <?php if ($reviews->num_rows > 0): ?>
        <?php while ($r = $reviews->fetch_assoc()): ?>
            <div class="review">
                <span class="reviewer"><?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']); ?></span> 
                <span class="rating">Rating: <?= $r['rating']; ?>/5</span>
                <p><?= htmlspecialchars($r['review']); ?></p>
                <small><?= $r['created_at']; ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No reviews yet.</p>
    <?php endif; ?>

    <?php if ($can_review): ?>
        <h4>Write a Review</h4>
        <form method="post" action="submit_review.php">
            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
            <div class="form-group">
                <label>Rating</label>
                <select name="rating" class="form-control" required>
                    <option value="">Select Rating</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
            <div class="form-group">
                <label>Review</label>
                <textarea name="comment" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-eshop">Submit Review</button>
        </form>
    <?php else: ?>
        <p><em>You must purchase this product to submit a review.</em></p>
    <?php endif; ?>
</div>

</body>
</html>
