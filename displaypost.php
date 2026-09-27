<?php
session_start();
include "db.php";
include "allheader.php";
$sql = "SELECT id, title, content, image FROM posts";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Could not load posts: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo htmlspecialchars($row['title']) . "<br>";
    echo nl2br(htmlspecialchars($row['content'])) . "<br>";

    if (!empty($row['image'])) {
        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Post image" width="300"><br>';
    }

   
    $post_id = (int) $row['id'];
    echo "<a href='updatepost.php?post_id=$post_id'>update</a> ";
    echo "<a href='deletepost.php?post_id=$post_id'>delete</a><br>";
    echo "<form action='insertcomment.php' method='post'>";
    echo "<input type='hidden' name='post_id' value='$post_id'>";
    echo '<textarea name="comment" rows="2" cols="25" placeholder="write your comment" required></textarea><br>';
    echo "<input type='submit' value='comment'>";
    echo "</form>";

    $comments = mysqli_query($conn, "SELECT user_name, comment FROM comments WHERE post_id='$post_id' ORDER BY id DESC");
    while ($comment = mysqli_fetch_assoc($comments)) {
        echo "<p><b>" . htmlspecialchars($comment['user_name']) . ":</b> ";
        echo htmlspecialchars($comment['comment']) . "</p>";
    }

    echo "<hr>";
}
