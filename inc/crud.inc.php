<!-- Crud Operations -->
<?php
    // ---Include Neccessary Files---
    // DB Connection
    require_once 'dbh.inc.php';
    // Functions
    require_once 'functions.inc.php';

    // Initialize Variables
    $activity = "";
    $date = "";
    $time = "";
    $status = "";
    $id = 0;
    $edit_state = false;
    $username = "";

    // When Insert button clicked, insert an cctivity
    if(isset($_POST['save'])){
        // Define Variables
        $activity = mysqli_real_escape_string($conn, $_POST['activity']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $username = $_POST['un'];

        // Insert Record
        insertRecord($activity, $date, $time, $status, $username, $conn);
    }

    // When Update button clicked, update an activity
    if(isset($_POST['update'])){
        // Define Variables
        $activity = mysqli_real_escape_string($conn, $_POST['activity']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $username = $_POST['un'];

        // Update Record
        updateRecord($activity, $date, $time, $status, $id, $username, $conn);
    }

    // When Delete button clicked, delete an dctivity
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $username = $_GET['user'];

        // Delete Record
        deleteRecord($id, $username, $conn);
    }

?>