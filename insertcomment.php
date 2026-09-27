<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$post_id = (int) ($_POST['post_id'] ?? 0);
$comment = trim($_POST['comment'] ?? '');
$user_id = (int) $_SESSION['user_id'];

if ($post_id > 0 && $comment !== '') {
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name, email FROM users WHERE id='$user_id'"));
    $name = mysqli_real_escape_string($conn, $user['name']);
    $email = mysqli_real_escape_string($conn, $user['email']);
    $comment = mysqli_real_escape_string($conn, $comment);
    $next_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(MAX(id), -1) + 1 AS id FROM comments"))['id'];

    $sql = "INSERT INTO comments (id, post_id, user_name, email, comment)
            VALUES ('$next_id', '$post_id', '$name', '$email', '$comment')";
    mysqli_query($conn, $sql);
}

header("Location: displaypost.php");
exit();
?>
