<?php
session_start();
include('connection.php');
include('databank.php');
$user_id = $_SESSION['user_id'];
$user_details = getUserDetails($db, $user_id);
include('header.php');

$user_id = $_SESSION['user_id'];
$expensesByCategory = getTotalExpensesByCategory($db, $user_id);
$expensesByMonth = getTotalExpensesByMonth($db, $user_id);

// Prepare data for charts
$categoryLabels = [];
$categoryData = [];
foreach ($expensesByCategory as $category_id => $total) {
    // Fetch category name
    $categoryQuery = "SELECT category_name FROM categories WHERE category_id = ?";
    $catStmt = mysqli_prepare($db, $categoryQuery);
    mysqli_stmt_bind_param($catStmt, "i", $category_id);
    mysqli_stmt_execute($catStmt);
    mysqli_stmt_bind_result($catStmt, $category_name);
    mysqli_stmt_fetch($catStmt);
    mysqli_stmt_close($catStmt);
    
    $categoryLabels[] = $category_name;
    $categoryData[] = $total;
}

$monthLabels = array_keys($expensesByMonth);
$monthData = array_values($expensesByMonth);

// Convert data to JSON format for JavaScript
$chartData = [
    'categories' => ['labels' => $categoryLabels, 'data' => $categoryData],
    'months' => ['labels' => $monthLabels, 'data' => $monthData]
];

echo json_encode($chartData);
?>
