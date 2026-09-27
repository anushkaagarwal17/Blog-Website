<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$categories = $conn->query('SELECT id, name FROM categories ORDER BY name');
$message = '';

if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = (int) $_POST['category_id'];
    $image = '';
    $author_id = (int) $_SESSION['user_id'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $message = "The image could not be uploaded.";
        } else {
            $allowed_types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            $file_type = mime_content_type($_FILES['image']['tmp_name']);

            if (!isset($allowed_types[$file_type])) {
                $message = "Please upload a JPG, PNG, GIF, or WebP image.";
            } else {
                $upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $filename = bin2hex(random_bytes(16)) . '.' . $allowed_types[$file_type];
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . DIRECTORY_SEPARATOR . $filename)) {
                    $image = 'uploads/' . $filename;
                } else {
                    $message = "The image could not be saved.";
                }
            }
        }
    }

    if ($message === '') {
        if ($title === '' || $content === '' || $category_id < 1) {
            $message = "Please fill all required fields.";
        } else {
        $stmt = $conn->prepare('INSERT INTO posts (title, content, author_id, category_id, image) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('ssiis', $title, $content, $author_id, $category_id, $image);

        try {
            if ($stmt->execute()) {
            $message = "Post added successfully.";
            }
        } catch (mysqli_sql_exception $e) {
            $message = "Database error: " . $e->getMessage();
        }

        $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
</head>
<body>
    <?php include 'allheader.php'; ?>
    <?php if ($message !== ''): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="insertpost.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Give The post Title here!" required><br>
        <textarea name="content" rows="2" cols="25" placeholder="Write the post here!" required></textarea><br>
        <select name="category_id" required>
            <option value="">Select category</option>
            <?php while ($category = $categories->fetch_assoc()): ?>
                <option value="<?php echo $category['id']; ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp"><br>

        <input type="submit" name="submit" value="add post">
    </form>
</body>
</html>
