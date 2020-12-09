<?php
    // Start a Session
    session_start();
    // DB Connection
    include 'dbh.inc.php';

    // Sign In
    if(isset($_POST['si'])){
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        echo "dsvv";
    }

    if(isset($_POST['su'])){
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        echo "ddd";
    }
?>