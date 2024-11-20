<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include('connection.php');

// Handle adding new expense
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = mysqli_real_escape_string($db, $_POST['amount']);
    $category_id = mysqli_real_escape_string($db, $_POST['category_id']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $expense_date = mysqli_real_escape_string($db, $_POST['expense_date']);

    // Insert the new expense
    $insertExpenseQuery = "INSERT INTO expenses (user_id, amount, category_id, description, expense_date) VALUES ('$user_id', '$amount', '$category_id', '$description', '$expense_date')";

    // Check if the query executes successfully
    if (mysqli_query($db, $insertExpenseQuery)) {
        // Update the user's balance
        // First, fetch the current balance
        $balanceQuery = "SELECT balance_amount FROM balance WHERE user_id = '$user_id'";
        $balanceResult = mysqli_query($db, $balanceQuery);
        
        if (mysqli_num_rows($balanceResult) > 0) {
            $balanceRow = mysqli_fetch_assoc($balanceResult);
            $currentBalance = $balanceRow['balance_amount'];

            // Subtract the expense amount from the current balance
            $newBalance = $currentBalance - $amount;

            // Update the balance in the database
            $updateBalanceQuery = "UPDATE balance SET balance_amount = '$newBalance', updated_at = NOW() WHERE user_id = '$user_id'";
            mysqli_query($db, $updateBalanceQuery);
        } else {
            // If no balance record exists, you may choose to create one (optional)
            // mysqli_query($db, "INSERT INTO balance (user_id, balance_amount, updated_at) VALUES ('$user_id', '-$amount', NOW())");
        }

        // Set success message
        $_SESSION['msg1'] = "Expense added successfully.";
        $_SESSION['msgTitle'] = "Good Job!";
        $_SESSION['msgStyle'] = 1;
    } else {
        // If the insertion fails, log the error for debugging
        error_log("Expense insertion failed: " . mysqli_error($db));
        $_SESSION['errorMessage'] = "Failed to add new expense: " . mysqli_error($db);
    }

    // Redirect to avoid resubmission
    header("Location: addexpense.php");
    exit();
}
?>
