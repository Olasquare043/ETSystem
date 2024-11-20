<?php
session_start();
include('connection.php');
include('databank.php');
$user_id = $_SESSION['user_id'];
$user_details = getUserDetails($db, $user_id);
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $category_id = $_POST['category'];

    // Build the SQL query based on input
    $query = "SELECT * FROM expenses WHERE user_id = ? AND expense_date BETWEEN ? AND ?";
    if ($category_id) {
        $query .= " AND category_id = ?";
    }

    $stmt = mysqli_prepare($db, $query);
    if ($category_id) {
        mysqli_stmt_bind_param($stmt, "issi", $_SESSION['user_id'], $start_date, $end_date, $category_id);
    } else {
        mysqli_stmt_bind_param($stmt, "iss", $_SESSION['user_id'], $start_date, $end_date);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if any records found
    if (mysqli_num_rows($result) > 0) {
        echo "<table id='dataTable' class='table table-bordered display'>
                <thead>
                    <tr>
                        <th>Expense Date</th>
                        <th>Amount</th>
                        <th>Category ID</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['expense_date']) . "</td>
                    <td>" . htmlspecialchars($row['amount']) . "</td>
                    <td>" . htmlspecialchars($row['category_id']) . "</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'>No expenses found for the selected criteria.</div>";
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: index.php");
    exit();
}
?>
