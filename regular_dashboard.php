<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'regular') {
    header('Location: index.php');
    exit();
}

include 'config.php';

// Logout Logic
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... your HTML head content ... -->
  
</head>
<body>
    <h2>Welcome, Regular User!</h2>

    <!-- Logout link -->
    <form action="regular_dashboard.php" method="post">
        <input type="hidden" name="logout">
        <button type="submit">Logout</button>
    </form>

    <!-- ... rest of your regular user dashboard content ... -->
</body>
</html>
