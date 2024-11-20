<?php
session_start();
if (isset($_SESSION['user_id'])) {
    include('connection.php');
    include('databank.php');
    $user_id = $_SESSION['user_id'];
    $user_details = getUserDetails($db, $user_id);
    $incomes = $incomes = getAllIncomes($db, $user_id);
    // Fetch user expenses
    $expenses = getExpenses($db, $user_id);
    include('header.php');
    // Fetch monthly expenses data for the area chart
    $monthlyExpenses = getMonthlyExpenses($db, $user_id);
    $months = [];
    $totals = [];

    foreach ($monthlyExpenses as $expense) {
        $months[] = date("F", mktime(0, 0, 0, $expense['month'], 1));
        $totals[] = $expense['total'];
    }

    $json_data = json_encode([
        'months' => $months,
        'totals' => $totals
    ]);

    $category_data = getExpensesByCategory($db, $user_id);
    $category_labels_json = json_encode($category_data['labels']);
    $category_expenses_json = json_encode($category_data['data']);

    ?>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?php echo "Welcome " . strtoupper($user_details['username']) ?></h4>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"> Dashboard </li>
            </ol>

            <!-- Table income  -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Income history
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <?php if ($incomes) { ?>
                                    <tr>
                                        <th>Income Amount</th>
                                        <th>Source</th>
                                        <th>Description</th>
                                        <th>Income Date</th>
                                    </tr>
                            <?php } ?>
                        </thead>
                        <tfoot>
                            <?php if ($incomes) { ?>
                                    <tr>
                                        <th>Income Amount</th>
                                        <th>Source</th>
                                        <th>Description</th>
                                        <th>Income Date</th>
                                    </tr>
                            <?php } ?>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($incomes)): ?>
                                    <?php foreach ($incomes as $income): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($income['amount']); ?></td>
                                                <td><?php echo htmlspecialchars($income['source']); ?></td>
                                                <td><?php echo htmlspecialchars($income['description']); ?></td>
                                                <td><?php echo htmlspecialchars($income['income_date']); ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                            <?php else: ?>
                                    <tr>
                                        <td colspan="4">No income records found.</td>
                                    </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="mt3">

            <!-- Table expense -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Expenses History
                </div>
                <div class="card-body">
                    <table id="datatablesSimple1">
                        <thead>
                            <?php if ($expenses) { ?>
                                    <tr>
                                        <th>Expense Amount</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Expense Date</th>
                                    </tr>
                            <?php } ?>
                        </thead>
                        <tfoot>
                            <?php if ($expenses) { ?>
                                    <tr>
                                        <th>Expense Amount</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Expense Date</th>
                                    </tr>
                            <?php } ?>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($expenses)): ?>
                                    <?php foreach ($expenses as $expense): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($expense['amount']); ?></td>
                                                <td><?php echo htmlspecialchars($expense['category_name']); ?></td>
                                                <td><?php echo htmlspecialchars($expense['description']); ?></td>
                                                <td><?php echo htmlspecialchars($expense['expense_date']); ?></td>
                                            </tr>
                                    <?php endforeach; ?>
                            <?php else: ?>
                                    <tr>
                                        <td colspan="4">No expense records found.</td>
                                    </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <script>
            window.addEventListener('DOMContentLoaded', event => {
                const datatablesSimple = document.getElementById('datatablesSimple1');
                if (datatablesSimple) {
                    new simpleDatatables.DataTable(datatablesSimple);
                }
            });
        </script>
        <?php
}
include('footer.php');
?>