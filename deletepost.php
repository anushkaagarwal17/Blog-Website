<?php
session_start();
include "db.php";

$post_id = (int) ($_GET['post_id'] ?? 0);

if ($post_id > 0) {
    // Delete comments first because comments use the post id.
    mysqli_query($conn, "DELETE FROM comments WHERE post_id='$post_id'");
    mysqli_query($conn, "DELETE FROM posts WHERE id='$post_id'");
}

header("Location: displaypost.php");
exit();
?>
