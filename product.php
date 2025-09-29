<?php
session_start();
include 'db.php';
include 'dbConfig.php';
// Only admin can access
if (!isset($_SESSION['logged_in']) || $_SESSION['email'] !== 'admin@gmail.com') {
    $_SESSION['message'] = "You must log in as an admin to add products!";
    header("location: error.php");
    exit();
}

// Admin info
$first_name = $_SESSION['first_name'] ?? 'Admin';

// Messages
$successMsg = $errorMsg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize input
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = floatval($_POST['price']);
    $image       = trim($_POST['Image']);

    // Default values
    $created  = date("Y-m-d H:i:s");
    $modified = date("Y-m-d H:i:s");
    $status   = 1; // active

    // Prepare insert statement
    $stmt = $db->prepare("
        INSERT INTO products (name, description, price, created, modified, status, Image)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    if ($stmt) {
        $stmt->bind_param("ssdssis", $name, $description, $price, $created, $modified, $status, $image);

        if ($stmt->execute()) {
            $successMsg = "✅ Product added successfully!";
        } else {
            $errorMsg = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $errorMsg = "❌ Prepare failed: " . $db->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Product - E-Shop Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="./js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
body { font-family:'Arial', sans-serif; background:#fff0f2; }
.navbar { border-radius:0; background:white; font-size:17px; }
.navbar a { color:#ff3e6c; }
.navbar a:hover { color:#e62e5c; }
.container { padding:30px; }
.btn-custom { background:#ff3e6c; color:white; border-radius:6px; }
.btn-custom:hover { background:#e62e5c; }
.msg { margin:20px 0; font-weight:bold; }
.success { color:green; }
.error { color:red; }
.form-horizontal .form-group { margin-bottom:20px; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
<div class="navbar-header">
  <a class="navbar-brand" href="admin.php">E-Shop Admin</a>
</div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= htmlspecialchars($first_name); ?></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <h2>Add New Product</h2>
  <?php if($successMsg): ?>
    <div class="msg success"><?= htmlspecialchars($successMsg); ?></div>
  <?php elseif($errorMsg): ?>
    <div class="msg error"><?= htmlspecialchars($errorMsg); ?></div>
  <?php endif; ?>

  <form class="form-horizontal" method="post" action="">
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Product Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" id="name" required placeholder="Enter product name">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="description">Description:</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="description" id="description" rows="3" required placeholder="Enter product description"></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="price">Price:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" name="price" id="price" step="any" required placeholder="Enter price">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="Image">Image URL:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="Image" id="Image" required placeholder="Enter image URL">
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-custom"><i class="fa fa-plus"></i> Add Product</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>
