<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    try {
        // Check if the username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            throw new Exception('Username is already taken. Please choose a different one.');
        }

        // Insert user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);

        echo 'Registration successful. <a href="index.php">Login here</a>';
    } catch (Exception $e) {
        echo 'Yo bro , User already exists: ' . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <!-- Additional fields for registration -->
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="regular">Regular User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Register</button>
        </form>
        <p>Already registered? <a href="index.php">Login here</a></p>
    </div>
</body>
</html>
