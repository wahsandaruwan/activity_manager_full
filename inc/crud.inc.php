<!-- Crud Operations -->
<?php
    // DB Connection
    include 'dbh.inc.php';

    // Initialize Variables
    $activity = "";
    $date = "";
    $time = "";
    $status = "";
    $id = 0;

    // When Form Submit Button Clicked
    if(isset($_POST['save'])){
        // Define Variables
        $activity = mysqli_real_escape_string($conn, $_POST['activity']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Insert Query
        $iquery = "INSERT INTO data(activity,date1,time1,status1) VALUES('$activity','$date','$time','$status')";
        
        // Error Handling
        try{
            if(!mysqli_query($conn, $iquery)){
                throw new Exception('Cannot insert the data into database!');
            }
            else{
                header('location: ../index.php');
            }
        }
        catch(Exception $e){
            echo "\nException Caught : ".$e->getMessage();
        }
        
    }
?>