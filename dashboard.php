<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "allheader.php";

echo "<h1>Welcome to the Dashboard, " . htmlspecialchars($_SESSION['name']) . " and your role is " . htmlspecialchars($_SESSION['role']) . "!</h1>";
echo "<a href='logout.php'>Logout</a>";
echo "<br><a href='displaypost.php'>Posts</a>";

if ($_SESSION['role'] === 'admin') {
    echo "<br><a href='addcategory.php'>Add category</a>";
}

echo " | <a href='insertpost.php'>Add post</a>";
?>
