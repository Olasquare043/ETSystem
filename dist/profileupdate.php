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
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-2">Update Profile</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['errorMessage'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['errorMessage'];
                                unset($_SESSION['errorMessage']); ?></div>
                        <?php endif; ?>
                        <form action="profileupdateAction.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    value="<?php echo htmlspecialchars($user_details['name']); ?>" class="form-control"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" name="username"
                                    value="<?php echo htmlspecialchars($user_details['username']); ?>" class="form-control"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email"
                                    value="<?php echo htmlspecialchars($user_details['email']); ?>" class="form-control"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">New Password (Leave blank if you don't want to change)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <!-- <div class="small"><a href="index.php">Have an account? Go to login</a></div> -->
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