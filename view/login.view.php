<?php
session_start();
$path = __DIR__ . '/../models/database.php';
if (file_exists($path)) {
    require($path);
} else {
    die("Error: Required file '$path' not found.");
}

$model = new Model();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $model->registration(['email' => $email, 'password' => $password]);

    if ($user) {
        $_SESSION['email'] = $user->email;
        $_SESSION['is_admin'] = $user->is_admin;
        header("Location: home.view.php");
        exit();
    } else {
        echo "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
<style>
    body {
    width: 100%;
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100vh;
    background-color: #f8d7da;
}

.container {
    max-width: 600px;
    width: 100%;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    box-sizing: border-box;
}

.content {
    text-align: center;
}

.content h2 {
    margin-bottom: 20px;
    font-size: 20px;
    color: #333333;
}

form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

label {
    margin-top: 10px;
    font-size: 14px;
    color: #333333;
}

input {
    width: calc(100% - 20px);
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.login-button {
    background-color: #ff9933;
    border: none;
    padding: 10px 20px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
    margin-top: 20px;
    align-self: center;
}

.login-button:hover {
    background-color: #e6891e;
}

.forgot-password {
    margin-top: 10px;
    font-size: 12px;
    color: #00796b;
    text-align: center;
    width: 100%;
}

.forgot-password a {
    color: #00796b;
    text-decoration: none;
}

.forgot-password a:hover {
    text-decoration: underline;
}
</style></head>
<body>
    <form action="/view/login.view.php" method="post">
        <div class="container">
            <h2>Sign in to your account</h2>
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>

            <button type="submit">Sign In</button>
        </div>
    </form>
</body>
</html>
