<?php

require '../models/database.php';

session_start();

$model = new Model();

if (!isset($_SESSION['email'])) {
    header("Location: login.view.php");
    exit();
}

$is_admin = $_SESSION['is_admin'];
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($is_admin && isset($_GET['action']) && $_GET['action'] == 'create_category') {
        if (!empty($_POST['category_name'])) {
            $category_name = htmlspecialchars($_POST['category_name']); // Sanitize input
            try {
                $model->createCategory($category_name);
                header("Location: ../view/category.view.php");
                exit();
            } catch (PDOException $e) {
                $error = "Error creating category: " . $e->getMessage();
            }
        } else {
            $error = "Category name cannot be empty.";
        }
    }
    
    if ($is_admin && isset($_GET['action']) && $_GET['action'] == 'create_post') {
        if (!empty($_POST['post_title']) && !empty($_POST['post_content']) && isset($_POST['category_id'])) {
            $post_title = htmlspecialchars($_POST['post_title']); // Sanitize input
            $post_content = htmlspecialchars($_POST['post_content']); // Sanitize input
            $category_id = (int)$_POST['category_id'];

            try {
                $model->createPost($category_id, $post_title, $post_content);
                header("Location: ../view/home.view.php");
                exit();
            } catch (PDOException $e) {
                $error = "Error creating post: " . $e->getMessage();
            }
        } else {
            $error = "Please fill out all required fields.";
        }
    }
}

// Fetch categories and posts
try {
    $categories_result = $model->getCategories();
    $page = 1; 
    $limit = 10;
    $posts = $model->getPosts($page, $limit);
} catch (PDOException $e) {
    $error = "Error fetching data: " . $e->getMessage();
    $categories_result = [];
    $posts_result = [];
}

require_once '../view/home.view.php';
