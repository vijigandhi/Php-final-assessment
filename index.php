<?php
$request_uri = $_SERVER['REQUEST_URI'];
$query_string = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';

// Parse query string parameters
parse_str($query_string, $query_params);

$page = isset($query_params['page']) ? intval($query_params['page']) : 1;
$searchTerm = isset($query_params['query']) ? htmlspecialchars($query_params['query']) : '';

switch ($request_uri) {
    case '/':
    case '/home':
        require './view/home.view.php'; 
        break;

    case '/category':
        require './view/category.view.php';
        break;

    case '/posts':
        require './view/post.view.php'; 
        break;

        case '/login':
            require './view/login.view.php'; 
            break;

    default:
        break;
}
?>

