<?php
session_start(); // Ensure session is started

$is_logged_in = isset($_SESSION['email']);
$is_admin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .navbar {
    background-color: #333;
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
}

.navbar a {
    color: #fff;
    text-decoration: none;
    padding: 10px;
}

.navbar a:hover {
    background-color: #555;
}

.search-form {
    display: flex;
    margin-right: 10px; /* Adjust margin as needed */
}

.search-form input[type="text"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
    outline: none;
    font-size: 14px;
}

.search-form button {
    padding: 8px 15px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 14px;
}

.login a {
    color: #fff;
    text-decoration: none;
    padding: 10px;
}

.login a:hover {
    background-color: #555;
}

    </style>
</head>
<body>
<div class="navbar">
    <a href="home.view.php">Home</a>
    <?php if ($is_admin): ?>
        <a href="./category.view.php">Create Category</a>
        <a href="./post.view.php">Create Post</a>
    <?php endif; ?>
    <form class="search-form" action="./home.view.php" method="GET">
        <input type="text" name="query" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    <div class="login">
        <?php if (!$is_logged_in): ?>
            <a href="login.view.php">Login</a>
        <?php else: ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

