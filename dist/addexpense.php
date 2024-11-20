<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include('connection.php');
include('databank.php');
$user_id = $_SESSION['user_id'];
$user_details = getUserDetails($db, $user_id);
include('header.php');

// Fetch default categories (user_id = 2) and user-specific categories
$categoryQuery = "SELECT category_id, category_name FROM categories WHERE user_id = 2 OR user_id = $user_id";
$categoryResult = mysqli_query($db, $categoryQuery);

// Handle adding new categories
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_category_name'])) {
    $newCategoryName = mysqli_real_escape_string($db, $_POST['new_category_name']);
    $insertCategoryQuery = "INSERT INTO categories (user_id, category_name, created_at) VALUES ($user_id, '$newCategoryName', NOW())";

    if (mysqli_query($db, $insertCategoryQuery)) {
        // Refresh categories after adding a new one
        $categoryResult = mysqli_query($db, $categoryQuery);
        $_SESSION['msg1'] = "Category added successfully.";
        $_SESSION['msgTitle'] = "Good Job!";
        $_SESSION['msgStyle'] = 1;
    } else {
        $_SESSION['errorMessage'] = "Failed to add new category.";
    }
    // Redirect to avoid resubmission
    header("Location: addexpense.php");
    exit();
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-3">
                <div class="card-header bg-primary">
                    <h4 class="text-center text-white font-weight-light my-2">Add New Expense</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['errorMessage'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['errorMessage']; unset($_SESSION['errorMessage']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['msg1'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['msg1']; unset($_SESSION['msg1']); ?>
                        </div>
                    <?php endif; ?>
                    <!-- Form to add new expense -->
                    <form action="addexpenseAction.php" method="post">
                        <div class="form-group mb-3">
                            <label for="amount">Amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <select name="category_id" class="form-control" required>
                                <?php while ($row = mysqli_fetch_assoc($categoryResult)): ?>
                                    <option value="<?php echo $row['category_id']; ?>">
                                        <?php echo htmlspecialchars($row['category_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense_date">Date</label>
                            <input type="date" name="expense_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Add Expense</button>
                    </form>
                    <hr>
                    <!-- Form to add a new category -->
                    <form action="addexpense.php" method="POST" class="mt-4">
                        <div class="form-group mb-3">
                            <p class="small text-warning">If you wish to create new category or you want to customize category</p>
                            <label for="new_category_name">Add New Category</label>
                            <input type="text" name="new_category_name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-secondary mt-2">Add Category</button>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <!-- Optional footer content -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
