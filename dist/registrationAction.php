<?php
session_start();
include('connection.php');

// Define variables and set to empty values
$name = $username = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = test_input($_POST["name"]);
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $confirm_password = test_input($_POST["confirm_password"]);

    // Check for empty fields
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['errorMessage'] = "All fields are required";
        header("Location: register.php");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['errorMessage'] = "Passwords do not match";
        header("Location: register.php");
        exit();
    }

    // Check if email or username already exists
    $checkQuery = "SELECT * FROM users WHERE email='$email' OR username='$username'";
    $result = mysqli_query($db, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['errorMessage'] = "Username or email already exists";
        header("Location: register.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $insertQuery = "INSERT INTO users (name, username, email, pswd) VALUES ('$name', '$username', '$email', '$hashed_password')";
    if (mysqli_query($db, $insertQuery)) {
        $_SESSION['msg1'] = "Registration successful, please log in.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['errorMessage'] = "Error: " . mysqli_error($db);
        header("Location: register.php");
        exit();
    }
}

// Sanitize function
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
