<?php
include('headerNoLayout.php');
?>
<div class="container">
    <div class="row justify-content-center">
    <h3 class="pt-4 text-center text-white bold card-header"><strong>Expenses Tracking
    System</strong></h3>
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-3">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-2">Create Account</h3>
                </div>
                <div class="card-body">
                <form role="form" method="post" action="registrationAction.php">
                        <?php
                        if (isset($_SESSION["errorMessage"])) {
                            ?>
                            <div class="text-danger"><?php echo $_SESSION["errorMessage"]; ?></div>
                            <?php
                            unset($_SESSION["errorMessage"]);
                        }
                        ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputName" name="name" type="text"
                                        placeholder="Enter your fullname" />
                                    <label for="inputFirstName">Names</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="inputusername" name="username" type="text"
                                        placeholder="Enter your username" />
                                    <label for="inputLastName">Username</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
                            <label for="inputEmail">Email address</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputPassword" type="password" name="password"
                                        placeholder="Create a password" />
                                    <label for="inputPassword">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputPasswordConfirm" type="password" name="confirm_password"
                                        placeholder="Confirm password" />
                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 mb-0">
                            <button type="submit" class="d-grid btn btn-primary btn-block">Create
                                    Account</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="index.php">Have an account? Go to login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footerNoLayout.php');
?>