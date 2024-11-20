<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Expenses Tracking System</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Custom styles -->
    <link rel="stylesheet" href="../css/admin.css" />
    <!-- <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script> -->
    <script src="js/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
    <!-- <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">

    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <?php
    if (isset($_SESSION['msg1'])) {
        $msg = $_SESSION['msg1'];
        $msgTitle = "Welcome!";
        if (isset($_SESSION['msgTitle'])) {
            $msgTitle = $_SESSION['msgTitle'];
        }
        ?>
        <script>
            Swal.fire({
                title: "<?php echo $msgTitle ?>",
                text: "<?php echo $msg ?>",
                icon: "success",
                button: "Ok",
            })
        </script>
        <?php
    }
    if (isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
        $msgTitle = "Check Well !";
        if (isset($_SESSION['msgTitle'])) {
            $msgTitle = $_SESSION['msgTitle'];
        }
        $msgStyle = $_SESSION['msgStyle'];
        if ($msgStyle == 0) {
            ?>
            <script>
                Swal.fire({
                    title: "<?php echo $msgTitle ?>",
                    text: "<?php echo $msg ?>",
                    icon: "error",
                    button: "Ok",
                })
            </script>
            <?php

        } else {
            ?>
            <script>
                Swal.fire({
                    title: "<?php echo $msgTitle ?>",
                    text: "<?php echo $msg ?>",
                    icon: "success",
                    button: "Ok!",
                });
            </script>
            <?php
        }
    }
    unset($_SESSION['msg']);
    unset($_SESSION['msg1']);
    unset($_SESSION['msgStyle']);
    unset($_SESSION['msgTitle']);
    ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">ETSystem</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="profileupdate.php">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" onclick="submitForm()" href="logout.php">Logout</a></li>
                    <script>
                        function submitForm() {
                            var answer = window.confirm("Are you sure you want to Logout?");
                            if (answer) {
                                //logout
                                window.location = "logout.php";
                            }
                        }
                    </script>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- <a class="nav-link" href="addexpense.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
                            Add Expenses
                        </a> -->
                        <div class="sb-sidenav-menu-heading">Account Operations</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Account
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="addincome.php"><i class="fas fa-plus"></i> &nbsp; Add
                                    Income</a>
                                <a class="nav-link" href="addexpense.php"><i class="fas fa-plus"></i>&nbsp; Add
                                    Expenses</a>
                            </nav>
                        </div>

                        <div class="sb-sidenav-menu-heading">Chats & Reports</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Reports
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="informationcards.php">Information Cards</a>
                                <a class="nav-link" href="charts.php">Charts</a>
                                <a class="nav-link" href="tables.php">Tables</a>
                                <!-- <a class="nav-link" href="table.php"><i class="fas fa-plus"></i>&nbsp; Add
                                    Expenses</a> -->
                            </nav>
                        </div>
                        <!-- <div class="sb-sidenav-menu-heading">Addons</div>
                         <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a> -->
                        <!-- <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Report
                        </a> -->
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <?php 
                    // include_once("databank.php");
                    // if (isset($_SESSION['user_id'])) {
                    //    $userdetail=getUserDetails($db, $_SESSION['user_id']);
                       echo $user_details['username'];
                    // }
                    ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>