<?php
session_start();
include('connection.php');
// define variables and set to empty values
 $email = $password = $user_id = "";
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
 }
if (empty($email) || empty($password)) {
    $_SESSION['errorMessage'] = "Both email and password is required";
    header("Location: index.php");
}
$query = "SELECT * FROM users WHERE email ='$email'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
    $email = $row['email'];
    $dbpass = $row['pswd'];
    if (password_verify($password, $dbpass)) {
    // if ($dbpass == $password) {
        $_SESSION['msg1'] = "Login Successfully";
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: dashboard.php");
    } else {
        $_SESSION['errorMessage'] = "Wrong username or password";
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
// }
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>