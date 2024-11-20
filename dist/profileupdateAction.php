<?php
session_start();
include('connection.php');

$user_id = $_SESSION['user_id'];
$name = test_input($_POST["name"]);
$username = test_input($_POST["username"]);
$email = test_input($_POST["email"]);
$password = isset($_POST["password"]) ? test_input($_POST["password"]) : "";

// Check if username or email is already taken by another user
$checkQuery = "SELECT * FROM users WHERE (email = '$email' OR username = '$username') AND user_id != '$user_id'";
$result = mysqli_query($db, $checkQuery);
if (mysqli_num_rows($result) > 0) {
    $_SESSION['errorMessage'] = "Username or email already exists";
    header("Location: profileupdate.php");
    exit();
}

// Prepare the update query
$updateQuery = "UPDATE users SET name = '$name', username = '$username', email = '$email'";

// If password is not empty, hash and update it
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $updateQuery .= ", pswd = '$hashed_password'";
}

$updateQuery .= " WHERE user_id = '$user_id'";

if (mysqli_query($db, $updateQuery)) {
    $_SESSION['msg1'] = "Profile updated successfully";
    $_SESSION['msgTitle'] = "Good Job!";
    $_SESSION['msgStyle'] = 1;
    header("Location: dashboard.php");
    exit();
} else {
    $_SESSION['errorMessage'] = "Error: " . mysqli_error($db);
    header("Location: profileupdate.php");
    exit();
}

// Sanitize function
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
