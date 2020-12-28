<!-- Crud Operations -->
<?php
    // ---Include Neccessary Files---
    // DB connection
    require_once 'dbh.inc.php';
    // Functions
    require_once 'functions.inc.php';

    // ---Initialize Variables---
    // For sign in and sign up
    $user = "";
    $pass = "";
    $email = "";
    $repass = "";
    // For main crud
    $activity = "";
    $date = "";
    $time = "";
    $status = "";
    $id = 0;
    $edit_state = false;
    $username = "";

    // ---For Sign In and Sign Up Operations---
    // For sign in
    if(isset($_POST['si'])){
        // Define variables
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        echo "dsvv";
    }

    // For sign up
    if(isset($_POST['su'])){
        // Define variables
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $repass = mysqli_real_escape_string($conn, $_POST['repass']);

        // Validate sign up information
        signUpValidation($conn,$user,$pass,$email,$repass);
    }

    // For sign out
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        header('location: ./index.php?msg=You are now logged out!&color=0e5e0e');
    }

    // ---For Main Crud Operations---
    // For insert an activity
    if(isset($_POST['save'])){
        // Define variables
        $activity = mysqli_real_escape_string($conn, $_POST['activity']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Insert record by calling the function
        insertRecord($activity, $date, $time, $status, $_SESSION['username'], $conn);
    }

    // For update an activity
    if(isset($_POST['update'])){
        // Define variables
        $activity = mysqli_real_escape_string($conn, $_POST['activity']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        // Update record by calling the function
        updateRecord($activity, $date, $time, $status, $id, $_SESSION['username'], $conn);
    }

    // For delete an activity
    if(isset($_GET['delete'])){
        // Define variables
        $id = $_GET['delete'];
        $username = $_GET['user'];

        // Delete record by calling the function
        deleteRecord($id, $username, $conn);
    }

?>