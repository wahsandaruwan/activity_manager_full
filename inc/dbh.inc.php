<!-- DB Connection -->
<?php
    $dbServer = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $database = "activity";

    $conn = mysqli_connect($dbServer, $dbUser, $dbPass, $database);

    // Error Handling
    try{
        if(!$conn){
            throw new Exception('Cannot connect with database!');
        }
    }
    catch(Exception $e){
        header('location: ../activity/index.php?dbcon=fail');
    }
?>