<!-- Crud Operations -->
<?php
    // Start a Session
    session_start();
    // DB Connection
    include 'dbh.inc.php';

    // Initialize Variables
    $activity = "";
    $date = "";
    $time = "";
    $status = "";
    $id = 0;
    $edit_state = false;

    // When Form Submit Button Clicked for Save Activity
    if(isset($_POST['save'])){
        // Define Variables
        $activity = mysqli_real_escape_string($conn, $_POST['activity']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Insert Record
        insertRecord($activity, $date, $time, $status, $conn);
    }

    // When Form Submit Button Clicked for Update Activity
    if(isset($_POST['update'])){
        // Define Variables
        $activity = mysqli_real_escape_string($conn, $_POST['activity']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $id = $_SESSION['id'];

        // Update Record
        updateRecord($activity, $date, $time, $status, $id, $conn);
    }

    // Insert Function
    function insertRecord($activity, $date, $time, $status, $conn){
        $iquery = "INSERT INTO data(activity,date1,time1,status1) VALUES('$activity','$date','$time','$status')";
        
        // Error Handling
        try{
            if(!mysqli_query($conn, $iquery)){
                throw new Exception('Cannot insert the data into database!');
            }
            else{
                $_SESSION['msg'] = "Activity Succesfully Added!";
                $_SESSION['color'] = "#0e5e0e";
                header('location: ../index.php');
            }
        }
        catch(Exception $e){
            echo "\nException Caught : ".$e->getMessage();
        }
    }

    // Select Function
    function selectRecords($conn){
        $squery = "SELECT * FROM data";
        $result = mysqli_query($conn, $squery);
        // Error Handling
        try{
            if(!$result){
                throw new Exception('Cannot select data from the database!');
            }
            else{
                return $result;
            }
        }
        catch(Exception $e){
            echo "\nException Caught : ".$e->getMessage();
        }
    }

    // Update Function
    function updateRecord($activity, $date, $time, $status, $id, $conn){
        echo '$id';
        $uquery = "UPDATE data SET activity='$activity', date1='$date', time1='$time', status1='$status' WHERE id=$id";
        
        // Error Handling
        try{
            if(!mysqli_query($conn, $uquery)){
                throw new Exception('Cannot update the data of the selected record!');
            }
            else{
                $_SESSION['msg'] = "Activity Succesfully Updated!";
                $_SESSION['color'] = "#0e5e0e";
                header('location: ../index.php');
            }
        }
        catch(Exception $e){
            echo "\nException Caught : ".$e->getMessage();
        }
    }
?>