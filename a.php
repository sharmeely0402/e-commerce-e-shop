<?php
session_start();
include 'db.php';
include 'dbConfig.php';

// Only admin access
if (!isset($_SESSION['logged_in']) || $_SESSION['email'] !== 'admin@gmail.com') {
    $_SESSION['message'] = "You must log in as an admin to update products!";
    header("location: error.php");
    exit();
}

$first_name = $_SESSION['first_name'] ?? 'Admin';

$id = intval($_GET['id'] ?? 0);
$successMsg = $errorMsg = "";

// Fetch product data
$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("❌ Product not found.");
}

// Handle update form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = floatval($_POST['price']);
    $image       = trim($_POST['Image']);
    $modified    = date("Y-m-d H:i:s");

    $stmt = $db->prepare("UPDATE products SET name=?, description=?, price=?, modified=?, Image=? WHERE id=?");
    $stmt->bind_param("ssdssi", $name, $description, $price, $modified, $image, $id);

    if ($stmt->execute()) {
        $successMsg = "✅ Product updated successfully!";
        $product['name'] = $name;
        $product['description'] = $description;
        $product['price'] = $price;
        $product['Image'] = $image;
    } else {
        $errorMsg = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Product - E-Shop Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <div class="navbar-header"><a class="navbar-brand" href="admin.php">E-Shop Admin</a></div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= htmlspecialchars($first_name); ?></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <h2>Update Product</h2>
  <?php if($successMsg): ?>
    <div class="msg success"><?= htmlspecialchars($successMsg); ?></div>
  <?php elseif($errorMsg): ?>
    <div class="msg error"><?= htmlspecialchars($errorMsg); ?></div>
  <?php endif; ?>

  <form class="form-horizontal" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2">Product Name:</label>
      <div class="col-sm-10">
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']); ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Description:</label>
      <div class="col-sm-10">
        <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($product['description']); ?></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Price:</label>
      <div class="col-sm-10">
        <input type="number" step="any" name="price" class="form-control" value="<?= htmlspecialchars($product['price']); ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Image URL:</label>
      <div class="col-sm-10">
        <input type="text" name="Image" class="form-control" value="<?= htmlspecialchars($product['Image']); ?>" required>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-custom"><i class="fa fa-save"></i> Save Changes</button>
        <a href="admin.php" class="btn btn-default">Cancel</a>
      </div>
    </div>
  </form>
</div>

</body>
</html>
