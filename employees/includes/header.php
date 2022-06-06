<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Employees-SSDIT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <link rel="stylesheet" href="assets/ionic-icons/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.css">
  <link rel="stylesheet" href="../assets/datetimepicker/daterangepicker.css">
 
  <!-- <link rel="stylesheet" href="assets/css/courses.css"> -->
  <!-- <link rel="stylesheet" href="assets/css/dashboard.css"> -->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php
  session_start();
  if (!isset($_SESSION['employee'])) {
    header("Location: ../login.php?user=employee");
  }
  ?>
