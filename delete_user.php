<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameToDelete = $_POST['usernameToDelete'];

    // Perform user deletion only for regular users
    $stmt = $pdo->prepare("DELETE FROM users WHERE username = ? AND role = 'regular'");
    $stmt->execute([$usernameToDelete]);

    echo 'User deleted successfully. <a href="admin_dashboard.php">Back to Admin Dashboard</a>';
    exit(); // Exit here to prevent the header() function below from executing.
}

// Redirect back to admin dashboard
header('Location: admin_dashboard.php');
exit();
?>
