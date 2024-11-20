<?php
session_start();
include('connection.php');

if (isset($_SESSION['user_id']) && isset($_POST['income_date']) && isset($_POST['amount'])) {
    $user_id = $_SESSION['user_id'];
    $income_date = mysqli_real_escape_string($db, $_POST['income_date']);
    $amount = floatval($_POST['amount']);
    $source = mysqli_real_escape_string($db, $_POST['source']);
    $description = mysqli_real_escape_string($db, $_POST['description']);

    // Insert the income record
    $query = "INSERT INTO income (user_id, income_date, amount, source, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "isdss", $user_id, $income_date, $amount, $source, $description);
    
    if (mysqli_stmt_execute($stmt)) {
        // Update the balance
        $balanceQuery = "INSERT INTO balance (user_id, balance_amount, updated_at)
                         VALUES (?, ?, NOW())
                         ON DUPLICATE KEY UPDATE balance_amount = balance_amount + VALUES(balance_amount), updated_at = NOW()";
        $balanceStmt = mysqli_prepare($db, $balanceQuery);
        mysqli_stmt_bind_param($balanceStmt, "id", $user_id, $amount);
        mysqli_stmt_execute($balanceStmt);

        $_SESSION['msg1'] = "Income added successfully.";
        $_SESSION['msgTitle'] = "Good Job!";
        $_SESSION['msgStyle'] = 1;
        header("Location: dashboard.php");
    } else {
        $_SESSION['errorMessage'] = "Failed to add income.";
        header("Location: addincome.php");
    }
} else {
    $_SESSION['errorMessage'] = "All fields are required.";
    header("Location: addincome.php");
}
