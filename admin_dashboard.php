<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'config.php';

// Delete User Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUser'])) {
    $usernameToDelete = $_POST['deleteUser'];

    // Perform user deletion only for regular users
    $stmt = $pdo->prepare("DELETE FROM users WHERE username = ? AND role = 'regular'");
    $stmt->execute([$usernameToDelete]);

    echo 'User deleted successfully.';
}

// Logout Logic
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}

// Fetch all users
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... your HTML head content ... -->
</head>
<body>
    <h2>Welcome, Admin!</h2>

    <h3>User List:</h3>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo $user['username']; ?> (Role: <?php echo $user['role']; ?>)
                <?php if ($user['role'] === 'regular'): ?>
                    <form action="admin_dashboard.php" method="post" style="display:inline;">
                        <input type="hidden" name="deleteUser" value="<?php echo $user['username']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Logout link -->
    <form action="admin_dashboard.php" method="post">
        <input type="hidden" name="logout">
        <button type="submit">Logout</button>
    </form>

    <!-- ... rest of your admin dashboard content ... -->
</body>
</html>
