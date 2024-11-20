<?php
session_start();
if (isset($_SESSION['user_id'])) {
    include('connection.php');
    include('databank.php');
    $user_id = $_SESSION['user_id'];
    $user_details = getUserDetails($db, $user_id);
    include('header.php');
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-3">
                    <div class="card-header bg-primary">
                        <h3 class="text-center text-white font-weight-light my-2">Add New Income</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['errorMessage'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['errorMessage']; unset($_SESSION['errorMessage']); ?>
                            </div>
                        <?php endif; ?>
                        <form action="addincomeAction.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="amount">Amount</label>
                                <input type="number" step="0.01" name="amount" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="source">Source</label>
                                <input type="text" name="source" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="income_date">Date</label>
                                <input type="date" name="income_date" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Add Income</button>
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
} else {
    header("Location: index.php");
    exit();
}
?>
