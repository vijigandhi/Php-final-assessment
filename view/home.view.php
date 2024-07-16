<?php
// Enable error reporting and display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$path = __DIR__ . '/../models/database.php';
if (file_exists($path)) {
    require($path);
} else {
    die("Error: Required file '$path' not found.");
}

$model = new Model();

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Number of posts per page

// Initialize search term
$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';

// If search term is provided, fetch filtered posts
if (!empty($searchTerm)) {
    $total_posts = $model->getTotalSearchPosts($searchTerm);
    $posts_result = $model->searchPosts($searchTerm, $page, $limit);
} else {
    // Fetch default posts list
    $total_posts = $model->getTotalPosts();
    $posts_result = $model->getPosts($page, $limit);
}

// Calculate total pages for pagination
$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Posts</title>
    <link rel="stylesheet" href="./styles/home.css">
    <link rel="stylesheet" href="./styles/navbar.style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
}
.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}
h2 {
    margin-top: 0;
}
.post {
    border-bottom: 1px solid #ccc;
    padding: 10px 0;
}
.pagination {
    margin-top: 20px;
}
.pagination a {
    margin: 0 5px;
    text-decoration: none;
    color: #333;
}
.pagination a.active {
    font-weight: bold;
    color: #000;
}

        </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>List of Posts</h2>

        <!-- Display Posts -->
        <?php if (!empty($posts_result)): ?>
            <?php foreach ($posts_result as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($post['category_name']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No posts found.</p>
        <?php endif; ?>

        <!-- Pagination -->
        <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php if ($page == $i) echo 'active'; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>

  
    </div>
</body>
</html>
