<?php
session_start();
include 'db.php';
include 'dbConfig.php';

// Only admin access
if (!isset($_SESSION['logged_in']) || $_SESSION['email'] !== 'admin@gmail.com') {
    $_SESSION['message'] = "You must log in as an admin to delete products!";
    header("location: error.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Product deleted successfully!";
    } else {
        $_SESSION['message'] = "❌ Error deleting product: " . $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "❌ Invalid product ID!";
}

header("Location: admin.php");
exit();
?>
