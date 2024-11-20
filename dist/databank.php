<?php 
function getUserDetails($db, $user_id)
{
    $query = "SELECT * FROM users WHERE user_id='" . $user_id . "'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    $row = mysqli_fetch_assoc($result);
    return $row;
}
function getBalance($db, $user_id) {
    $query = "SELECT balance_amount FROM balance WHERE user_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $balance_amount);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // If no balance record is found, return 0 as the default balance
    return $balance_amount ?? 0;
}
function getLastIncome($db, $user_id) {
    $query = "SELECT amount, income_date, source FROM income WHERE user_id = ? ORDER BY income_date DESC LIMIT 1";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt); // Store the result
    mysqli_stmt_bind_result($stmt, $amount, $income_date, $source);
    $result = mysqli_stmt_fetch($stmt); // Fetch the result
    
    if ($result) {
        // Return as an associative array
        return [
            'amount' => $amount,
            'date' => $income_date,
            'source' => $source
        ];
    } else {
        return null;
    }
    
    // Close the statement here
    mysqli_stmt_close($stmt);
}
function getLastExpense($db, $user_id) {
    $query = "SELECT amount, expense_date, category_id FROM expenses WHERE user_id = ? ORDER BY expense_date DESC LIMIT 1";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $amount, $expense_date, $category_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Return as an associative array
    return $amount && $expense_date ? ['amount' => $amount, 'date' => $expense_date, 'category_id' => $category_id] : null;
}
function getCategoryName($db, $category_id) {
    $query = "SELECT category_name FROM categories WHERE category_id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $category_name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $category_name ? $category_name : null; // Return the category name or null if not found
}
// Function to get total expenses by month
function getTotalExpensesByMonth($db, $user_id) {
    $query = "SELECT DATE_FORMAT(expense_date, '%Y-%m') as month, SUM(amount) as total_expense 
              FROM expenses 
              WHERE user_id = ? 
              GROUP BY month 
              ORDER BY month";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $expenses = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $expenses[$row['month']] = $row['total_expense'];
    }
    mysqli_stmt_close($stmt);
    return $expenses;
}
// Function to get total expenses by category
function getTotalExpensesByCategory($db, $user_id) {
    $query = "SELECT category_id, SUM(amount) as total_expense 
              FROM expenses 
              WHERE user_id = ? 
              GROUP BY category_id";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $expenses = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $expenses[$row['category_id']] = $row['total_expense'];
    }
    mysqli_stmt_close($stmt);
    return $expenses;
}
function format_currency($amount) {
    // Convert to float
    $amount = (float)$amount;
    
    // Format the number
    $formatted_amount = number_format($amount, 2);
    
    // Add currency symbol
    $currency_symbol = '#'; // Adjust this based on your desired currency
    
    return $currency_symbol . $formatted_amount;
}
function getAllIncomes($db, $user_id) {
    $query = "SELECT income_id, amount, income_date, source, description FROM income WHERE user_id = ? ORDER BY income_date DESC";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $incomes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $incomes[] = $row;  // Add each income record to the array
    }

    mysqli_stmt_close($stmt);
    return $incomes; // Returns an array of all income records
}
function getMonthlyExpenses($db, $user_id) {
    $query = "SELECT MONTH(expense_date) AS month, SUM(amount) AS total
              FROM expenses
              WHERE user_id = ?
              GROUP BY MONTH(expense_date)
              ORDER BY month";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getExpensesByCategory($db, $user_id) {
    $query = "SELECT c.category_name, SUM(e.amount) AS total_amount
              FROM expenses e
              JOIN categories c ON e.category_id = c.category_id
              WHERE e.user_id = ?
              GROUP BY c.category_name";

    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $categories = [];
    $amounts = [];

    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category_name'];
        $amounts[] = $row['total_amount'];
    }

    return ['labels' => $categories, 'data' => $amounts];
    
}
function getExpenses($db, $user_id) {
    $query = "SELECT e.amount, c.category_name, e.description, e.expense_date
              FROM expenses e
              JOIN categories c ON e.category_id = c.category_id
              WHERE e.user_id = ?
              ORDER BY e.expense_date DESC";

    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getTotalIncomeForCurrentMonth($db, $user_id) {
    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // SQL query to get the sum of income for the current month and year for the specific user
    $incomeQuery = "SELECT SUM(amount) AS total_income 
                    FROM income 
                    WHERE user_id = ? 
                    AND MONTH(income_date) = ? 
                    AND YEAR(income_date) = ?";
                    
    // Prepare and execute the query
    $stmt = mysqli_prepare($db, $incomeQuery);
    mysqli_stmt_bind_param($stmt, 'iii', $user_id, $currentMonth, $currentYear);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total_income);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Return the total income (if null, return 0)
    return $total_income ? $total_income : 0;
}

function getTotalExpenseForCurrentMonth($db, $user_id) {
    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // SQL query to get the sum of expenses for the current month and year for the specific user
    $expenseQuery = "SELECT SUM(amount) AS total_expense 
                     FROM expenses 
                     WHERE user_id = ? 
                     AND MONTH(expense_date) = ? 
                     AND YEAR(expense_date) = ?";
                     
    // Prepare and execute the query
    $stmt = mysqli_prepare($db, $expenseQuery);
    mysqli_stmt_bind_param($stmt, 'iii', $user_id, $currentMonth, $currentYear);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total_expense);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Return the total expense (if null, return 0)
    return $total_expense ? $total_expense : 0;
}
