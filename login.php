<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // User credentials are correct, proceed with login
        session_start();
        $_SESSION['user'] = $user;
        
        if ($user['role'] === 'admin') {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: regular_dashboard.php');
        }
        exit();
    } else {
        echo 'Invalid username or password';
    }
}
?>

<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the user (this is a basic example, in a real app you should use a database)
    if ($username === 'admin' && $password === 'adminpass') {
        $_SESSION['user'] = 'admin';
        header('Location: admin_dashboard.php');
        exit();
    } elseif ($username === 'user' && $password === 'userpass') {
        $_SESSION['user'] = 'regular';
        header('Location: regular_dashboard.php');
        exit();
    } else {
        echo 'Invalid username or password';
    }
}
?>
