<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
</head>
<body>
<?php include 'navbar.php'; ?>

    <h2>Create Category</h2>
    <form action="../controllers/controllers.php?action=create_category" method="post">
        <label for="category_name">Category Name</label>
        <input id="category_name" name="category_name" type="text" required>
        <button type="submit">Create Category</button>
    </form>
</body>
</html>
