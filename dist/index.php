<?php
include('headerNoLayout.php');
?>
<div class="container">
    <div class="row justify-content-center">
        <h3 class="pt-4 text-center text-white bold card-header"><strong>Expenses Tracking
                System</strong></h3>
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-3">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-2">Login</h3>
                </div>
                <div class="card-body">
                    <form role="form" method="post" action="loginAction.php">
                        <?php
                        if (isset($_SESSION["errorMessage"])) {
                            ?>
                            <div class="text-danger"><?php echo $_SESSION["errorMessage"]; ?></div>
                            <?php
                            unset($_SESSION["errorMessage"]);
                        }
                        ?>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="inputEmail" name="email" type="email"
                                placeholder="name@example.com" />
                            <label for="inputEmail">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="password" id="inputPassword" type="password"
                                placeholder="Password" />
                            <label for="inputPassword">Password</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                            <label class="form-check-label" for="inputRememberPassword">Remember
                                Password</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-success mb-4 form-control">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footerNoLayout.php');
?>