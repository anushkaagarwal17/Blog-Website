<?php
session_start();
include 'db.php';
if (isset($_POST['Submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, name, email, password, role FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            echo "<p style='color: green;'>Logged in successfully</p> <a href='dashboard.php'>Dashboard</a>";
        } else {
            echo "<p style='color: red;'>Invalid email or password</p>";
        }
    } else {
        echo "<p style='color: red;'>Invalid email or password</p>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include 'allheader.php'; ?>
    <form action="login.php" method="post">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="Submit" value="Login">
    </form>
</body>
</html>
