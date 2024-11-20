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
        <!-- information cards -->
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <!-- get balance -->
                    <?php $balance = getBalance($db, $user_id);
                    ?>
                    <div class="card-header">
                        <h4 class="text-center font-weight-light my-2"><?php echo format_currency($balance) ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="small"><strong>Amount:</strong><?php echo " " . format_currency($balance) ?></div>
                        <div class="small"><strong>Remain </strong></div>

                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                        <strong>
                            <!-- <div class="small text-white stretched-link">Balance</div> -->
                            <h5 class="justify-content-center"><strong>Balance </strong></h5>

                        </strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-secondary text-white mb-4">
                    <!-- get last income -->
                    <?php $lastIncome = getLastIncome($db, $user_id);
                    $amount = 0;
                    $income_date = "";
                    $source = "";
                    if ($lastIncome) {
                        $amount = $lastIncome['amount'];
                        $income_date = $lastIncome['date'];
                        $source = $lastIncome['source'];
                    }
                    ?>
                    <div class="card-header">
                        <h4 class="text-center font-weight-light my-2"><?php echo format_currency($amount) ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="small"><strong>Date: </strong><?php echo $income_date ?></div>
                        <div class="small"><strong>Source: </strong><?php echo $source ?></div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                    <h5 class="justify-content-center"><strong>Last Income </strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <!-- get last Expense -->
                    <?php $lastExpense = getLastExpense($db, $user_id);
                    $amount = 0;
                    $income_date = "";
                    $category = "";
                    if ($lastExpense) {
                        $amount = $lastExpense['amount'];
                        $expense_date = $lastExpense['date'];
                        $category = getCategoryName($db, $lastExpense['category_id']);
                    }
                    ?>
                    <div class="card-header">
                        <h4 class="text-center font-weight-light my-2"><?php echo format_currency($amount) ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="small"><strong>Date: </strong><?php echo $expense_date ?></div>
                        <div class="small"><strong>Category: </strong><?php echo $category ?></div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                    <h5 class="justify-content-center"><strong>Last Expense </strong></h5>
                    </div>
                </div>
            </div>
        </div>
        </script>
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card bg-warning text-dark mb-4">
                    <!-- get balance -->
                    <?php $totIncome = getTotalIncomeForCurrentMonth($db, $user_id)
                    ?>
                    <div class="card-header">
                        <h4 class="text-center font-weight-light my-2"><?php echo format_currency($totIncome) ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="small"><strong>Amount:</strong><?php echo " " . format_currency($totIncome) ?></div>
                        <div class="small"><strong>in total </strong></div>

                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                        <strong>
                            <!-- <div class="small text-white stretched-link">Balance</div> -->
                            <h5 class="justify-content-center"><strong>Total Income for <?php echo Date('F')?> </strong></h5>

                        </strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <!-- get balance -->
                    <?php $totexpense = getTotalExpenseForCurrentMonth($db, $user_id)
                    ?>
                    <div class="card-header">
                        <h4 class="text-center font-weight-light my-2"><?php echo format_currency($totexpense) ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="small"><strong>Amount:</strong><?php echo " " . format_currency($totexpense) ?></div>
                        <div class="small"><strong>in total </strong></div>

                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                        <strong>
                            <!-- <div class="small text-white stretched-link">Balance</div> -->
                            <h5 class="justify-content-center"><strong>Total Expenses for <?php echo Date('F')?> </strong></h5>

                        </strong>
                    </div>
                </div>
            </div>
        </div>
        </script>
        </script>
    </div>
    <?php
}
include('footer.php');
?>