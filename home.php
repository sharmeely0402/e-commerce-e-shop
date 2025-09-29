<?php


include 'dbConfig.php';
include 'Cart.php';

$cart = new Cart;

// Check login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your profile!";
    header("location: error.php");
    exit();
}

// User info
$first_name = $_SESSION['first_name'];
$last_name  = $_SESSION['last_name'];

// Search
$search_query = '';
$sql = "SELECT * FROM products";
$params = [];

if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
    $search_query = "%" . trim($_POST['search']) . "%";
    $sql .= " WHERE description LIKE ? OR name LIKE ?";
    $params = [$search_query, $search_query];
}

$sql .= " ORDER BY id ASC";

$stmt = $db->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}

if (!empty($params)) {
    $stmt->bind_param("ss", $params[0], $params[1]);
}

$stmt->execute();
$query = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>E-Shop</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap + jQuery -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="./js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body { font-family: 'Helvetica Neue', sans-serif; background:#fff; }
.navbar { border:none; margin-bottom:0; }
.navbar-brand { font-weight:bold; color:#ff3e6c !important; font-size:24px; }
.navbar-nav>li>a { color:#333 !important; font-size:16px; }
.navbar-form { margin:0; }
.navbar .btn { background:#ff3e6c; color:white; }
.navbar .btn:hover { background:#e62e5c; }

.hero { margin:0 auto; max-width:1200px; }
.hero img { width:100%; border-radius:12px; }

.section-title { text-align:center; padding:20px; }
.section-title h2 { color:#ff3e6c; font-weight:700; }

.product-card { border:1px solid #eee; border-radius:12px; padding:15px; text-align:center; transition:.3s; }
.product-card:hover { box-shadow:0 4px 15px rgba(0,0,0,0.1); transform:translateY(-5px); }
.product-card img { width:100%; height:200px; object-fit:cover; border-radius:8px; }
.product-card h4 { margin:10px 0; font-size:18px; font-weight:600; }
.product-card p { font-size:14px; color:#555; min-height:40px; }
.product-card .price { font-size:16px; font-weight:bold; color:#e62e5c; }
.product-card .btn { margin-top:10px; background:#ff3e6c; color:white; border-radius:20px; }
.product-card .btn:hover { background:#e62e5c; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">E-Shop</a>
    </div>
    
    <form class="navbar-form navbar-right" method="post">
      <div class="input-group">
        <input style="margin:5%" type="text" name="search" class="form-control"
               placeholder="Search products..."
               value="<?= htmlspecialchars($_POST['search'] ?? '') ?>">
        <span class="input-group-btn">
          <button type="submit" class="btn"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="profile.php"><i class="fa fa-user"></i> <?= htmlspecialchars($first_name) ?></a></li>
      <li><a href="viewCart.php"><i class="fa fa-shopping-cart"></i> Cart (<?= $cart->total_items(); ?>)</a></li>
      <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </div>
</nav>

<!-- Hero Section -->
<div class="container hero">
  <div id="heroCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#heroCarousel" data-slide-to="1"></li>
      <li data-target="#heroCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="item active"><img src="uploads/hero1.avif" alt="Sale"></div>
      <div class="item"><img src="uploads/hero2.avif" alt="Offer"></div>
      <div class="item"><img src="uploads/hero3.avif" alt="New Launch"></div>
    </div>
    <a class="left carousel-control" href="#heroCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#heroCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
  </div>
</div>

<!-- Products -->
<div class="container">
  <div class="section-title">
    <h2>Our Products</h2>
    <p>Find the best items for you</p>
  </div>

  <div class="row">
    <?php if ($query->num_rows > 0): ?>
      <?php while ($row = $query->fetch_assoc()): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="product-card">
            <img src="uploads/<?= !empty($row['Image']) ? htmlspecialchars($row['Image']) : 'default.jpg'; ?>" 
                 alt="<?= htmlspecialchars($row['name']) ?>">
            <h4><?= htmlspecialchars($row['name']); ?></h4>
            <p><?= htmlspecialchars($row['description']); ?></p>
            <div class="price">Rs. <?= htmlspecialchars($row['price']); ?></div>
            <a href="cartAction.php?action=addToCart&id=<?= $row['id']; ?>" class="btn btn-block">Add to Cart</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center; color:#555;">No products found.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
