<?php
// Enable error reporting and display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check database connection
$path = __DIR__ . '/../models/database.php';
if (file_exists($path)) {
    require($path);
} else {
    die("Error: Required file '$path' not found.");
}

$model = new Model();
if (!$model->db) {
    die("Database connection failed: " . $model->db->errorInfo());
}

// Check if categories can be fetched
$stmt = $model->db->query("SELECT * FROM category");
if (!$stmt) {
    die("Error fetching categories: " . $model->db->errorInfo());
}
$categories_result = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="./styles/navbar.style.css">
</head>
<body>
    <?php include(__DIR__ . '/navbar.php'); ?>
    <h2>Create Post</h2>
    <?php if (!empty($_SESSION['error'])): ?>
        <p class="error"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form action="../controllers/controllers.php?action=create_post" method="post">
        <label for="post_title">Post Title</label>
        <input id="post_title" name="post_title" type="text" required>

        <label for="post_content">Post Content</label>
        <textarea id="post_content" name="post_content" required></textarea>

        <label for="category_id">Category</label>
        <select id="category_id" name="category_id" required>
            <?php foreach ($categories_result as $category): ?>
                <option value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Create Post</button>
    </form>
    
</body>
</html>
