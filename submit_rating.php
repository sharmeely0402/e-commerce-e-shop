<?php
include 'db.php';
session_start();

// Check login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before submitting ratings!";
    header("location: error.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
    $ratings = $_POST['rating'];

    $mysqli->begin_transaction();

    try {
        // Insert rating into score column
        $stmt = $mysqli->prepare("INSERT INTO rating (p_id, score) VALUES (?, ?)
                                  ON DUPLICATE KEY UPDATE score = VALUES(score)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $mysqli->error);
        }

        foreach ($ratings as $product_id => $rate) {
            $stmt->bind_param("ii", $product_id, $rate);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        }

        $mysqli->commit();
        $stmt->close();

        $_SESSION['message'] = "Ratings submitted successfully!";
        header("Location: home.php");
        exit();

    } catch (Exception $e) {
        $mysqli->rollback();
        echo "Error submitting ratings: " . $e->getMessage();
    }

} else {
    header("Location: home.php");
    exit();
}
?>
