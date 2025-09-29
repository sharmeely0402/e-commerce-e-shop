<?php
session_start();
include 'dbConfig.php';
include 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['email'] !== 'admin@gmail.com') {
    $_SESSION['message'] = "You must log in as an admin to view this page!";
    header("location: error.php");
    exit();
}

// Admin info
$first_name = $_SESSION['first_name'];
$last_name  = $_SESSION['last_name'];
$email      = $_SESSION['email'];
$address    = $_SESSION['address'];
$phone      = $_SESSION['phone'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - E-Shop</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="./js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
/* General styles */
body { font-family: 'Arial', sans-serif; background-color: #fff0f2; }
a { text-decoration: none; color: #ff3e6c; transition: 0.3s; }
a:hover { color: #e62e5c; }
.container { padding: 30px; }

/* Navbar */
.navbar { border-radius:0; font-size: 17px; background-color: white; }
.navbar a { color:#ff3e6c; }
.navbar a:hover { color:#e62e5c; }
.badge { background-color:#ff3e6c; color:white; font-size:17px; }

/* Tabs */
.nav-tabs > li > a { color: #ff3e6c; font-weight: 600; }
.nav-tabs > li.active > a { background-color: #ff3e6c; color: white; }
.nav-tabs > li > a:hover { background-color:#e62e5c; color:white; }

/* Tables */
table { border-collapse: collapse; width: 100%; background: #fff; border-radius: 8px; }
th, td { padding: 12px; text-align: center; border: 1px solid #ddd; }
th { background-color: #ff3e6c; color: white; }

/* Buttons */
.btn-custom { background-color: #ff3e6c; color: white; border-radius: 6px; }
.btn-custom:hover { background-color: #e62e5c; }

/* Product cards */
.thumbnail { border-radius:8px; overflow:hidden; margin-bottom:20px; background:#fff0f2; transition: 0.2s; }
.thumbnail:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
.thumbnail img { width:100%; height:150px; object-fit:cover; }
.caption h4 { color: #ff3e6c; font-weight:600; }
.caption p { color: #555; font-size:14px; }
</style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="#">E-Shop Admin</a></div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= htmlspecialchars($first_name); ?></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <a class="btn btn-custom" href="product.php">Add New Product</a>
  <br><br>

  <!-- Tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
    <li><a data-toggle="tab" href="#customers">Customers</a></li>
    <li><a data-toggle="tab" href="#orders">Orders</a></li>
    <li><a data-toggle="tab" href="#products">Products</a></li>
    <li><a data-toggle="tab" href="#reviews">Reviews</a></li>
  </ul>

  <div class="tab-content" style="margin-top:20px;">
    <!-- Dashboard Tab -->
    <div id="dashboard" class="tab-pane fade in active">
     <h3>Dashboard Analytics</h3>
<div class="row">
  <div class="col-md-6">
    <canvas id="salesChart"></canvas>
  </div>
  <div class="col-md-6">
    <canvas id="ratingChart"></canvas>
  </div>
  // Most purchased products
  <?php
$salesData = $mysqli->query("
    SELECT p.name, SUM(oi.quantity) AS total_sold 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    GROUP BY oi.product_id
    ORDER BY total_sold DESC
    LIMIT 10
");

$productNames = [];
$productSales = [];
while($row = $salesData->fetch_assoc()){
    $productNames[] = $row['name'];
    $productSales[] = $row['total_sold'];
}

// Average rating per product
$ratingData = $mysqli->query("
    SELECT p.name, AVG(r.score) AS avg_rating
    FROM rating r
    JOIN products p ON r.p_id = p.id
    GROUP BY r.p_id
    ORDER BY avg_rating DESC
    LIMIT 10
");

$ratingNames = [];
$ratingScores = [];
while($row = $ratingData->fetch_assoc()){
    $ratingNames[] = $row['name'];
    $ratingScores[] = round($row['avg_rating'], 2);
}
?>
</div>

    </div>

    <!-- Customers Tab -->
    <div id="customers" class="tab-pane fade">
      <h3>Customers</h3>
      <?php
      $customers = $mysqli->query("SELECT * FROM customers");
      if($customers->num_rows > 0):
      ?>
      <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th></tr>
        <?php while($row = $customers->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id']; ?></td>
          <td><?= $row['first_name'].' '.$row['last_name']; ?></td>
          <td><?= $row['email']; ?></td>
          <td><?= $row['phone']; ?></td>
          <td><?= $row['address']; ?></td>
        </tr>
        <?php endwhile; ?>
      </table>
      <?php else: ?>
        <p>No customers found.</p>
      <?php endif; ?>
    </div>

    <!-- Orders Tab -->
    <div id="orders" class="tab-pane fade">
      <h3>Orders</h3>
      <?php
      $orders = $mysqli->query("SELECT o.id, c.first_name, c.last_name, o.total_price, o.created 
                                FROM orders o
                                JOIN customers c ON o.customer_id = c.id
                                ORDER BY o.created DESC");
      if($orders->num_rows > 0):
      ?>
      <table>
        <tr><th>Order ID</th><th>Customer</th><th>Total Price</th><th>Date</th></tr>
        <?php while($row = $orders->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id']; ?></td>
          <td><?= $row['first_name'].' '.$row['last_name']; ?></td>
          <td>Rs. <?= $row['total_price']; ?></td>
          <td><?= $row['created']; ?></td>
        </tr>
        <?php endwhile; ?>
      </table>
      <?php else: ?>
        <p>No orders found.</p>
      <?php endif; ?>
    </div>

    <!-- Products Tab -->
    <div id="products" class="tab-pane fade">
      <h3>Products</h3>
      <div class="row">
      <?php
      $products = $mysqli->query("SELECT * FROM products ORDER BY id DESC");
      if($products->num_rows > 0):
        while($row = $products->fetch_assoc()):
          $avgRatingQuery = $mysqli->query("SELECT AVG(score) as avgScore FROM rating WHERE p_id = ".$row['id']);
          $avgRating = $avgRatingQuery ? $avgRatingQuery->fetch_assoc()['avgScore'] : null;
      ?>
        <div class="col-lg-4 col-md-6">
          <div class="thumbnail">
            <img src="uploads/<?= !empty($row['Image']) ? $row['Image'] : 'default.jpg'; ?>" alt="<?= $row['name']; ?>">
            <div class="caption">
              <h4><?= htmlspecialchars($row['name']); ?></h4>
              <p style="height:50px; overflow:hidden;"><?= htmlspecialchars($row['description']); ?></p>
              <p>Price: Rs. <?= $row['price']; ?></p>
              <p>Rating: <?= $avgRating ? round($avgRating,2) : "NA"; ?></p>
              <a href="a.php?id=<?= $row['id']; ?>" class="btn btn-custom btn-sm">Update</a>
              <a href="deleteProduct.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
            </div>
          </div>
        </div>
      <?php endwhile; else: ?>
        <p>No products found.</p>
      <?php endif; ?>
      </div>
    </div>

    <!-- Reviews Tab -->
    <div id="reviews" class="tab-pane fade">
      <h3>Product Reviews</h3>
      <?php
      $reviews = $mysqli->query("SELECT r.*, p.name as product_name FROM rating r 
                                 JOIN products p ON r.p_id = p.id ORDER BY r.id DESC");
      if($reviews->num_rows > 0):
      ?>
      <table>
        <tr><th>ID</th><th>Product</th><th>Customer ID</th><th>Rating</th></tr>
        <?php while($row = $reviews->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id']; ?></td>
          <td><?= htmlspecialchars($row['product_name']); ?></td>
          <td><?= $row['id']; ?></td>
          <td><?= $row['score']; ?></td>
         
        </tr>
        <?php endwhile; ?>
      </table>
      <?php else: ?>
        <p>No reviews found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(salesCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($productNames); ?>,
        datasets: [{
            label: 'Units Sold',
            data: <?= json_encode($productSales); ?>,
            backgroundColor: '#ff3e6c'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});

const ratingCtx = document.getElementById('ratingChart').getContext('2d');
const ratingChart = new Chart(ratingCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($ratingNames); ?>,
        datasets: [{
            label: 'Average Rating',
            data: <?= json_encode($ratingScores); ?>,
            backgroundColor: '#34a853'
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true, max: 5 } }
    }
});
</script>
