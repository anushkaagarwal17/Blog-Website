<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    die("You are not an admin.");
}

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);

    if ($name === '') {
        echo "Category name is required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        try {
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Category added successfully</p> ";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                echo "<p style='color: red;'>This category already exists.</p>";
            } else {
                echo "Database error: " . htmlspecialchars($e->getMessage());
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>
    <?php include 'allheader.php'; ?>
    <h1>Add Category</h1>
    <form action="addcategory.php" method="POST">
        <input type="text" name="name" required>
        <input type="submit" name="submit" value="Add category">
        <a href='dashboard.php'>Dashboard</a>
    </form>
</body>
</html>
