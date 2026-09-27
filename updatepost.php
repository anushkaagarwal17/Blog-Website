<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
} else {
    die("Post id is missing.");
}

$sql = "SELECT * FROM posts WHERE id='$post_id'";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);
$categories = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name");

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_id = (int) $_POST['category_id'];

    $sql = "UPDATE posts SET title='$title', content='$content', category_id='$category_id' WHERE id='$post_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Post updated successfully.<br>";
        $post['title'] = $_POST['title'];
        $post['content'] = $_POST['content'];
    } else {
        echo "Error updating post.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Post</title>
</head>
<body>
    <?php include 'allheader.php'; ?>
    <form action="updatepost.php?post_id=<?php echo $post_id; ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Give The post Title here!" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>
        <textarea name="content" rows="2" cols="25" placeholder="Write the post here!" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>

        <select name="category_id" required>
            <option value="">Select category</option>
            <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $post['category_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <input type="file" name="image"><br>
        <input type="submit" name="submit" value="update post">
    </form>
</body>
</html>
