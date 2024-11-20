<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - ETSystem</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Custom styles -->
    <link rel="stylesheet" href="../css/admin.css" />
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
    <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js"></script>
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
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>