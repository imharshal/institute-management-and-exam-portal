<?php
session_start();

if (isset($_SESSION['logged_in'])) {

    // unset($_SESSION["logged_in"]);
    unset($_SESSION["admin"]);
    // echo "logout successfully";
    header("Location:/");
}
