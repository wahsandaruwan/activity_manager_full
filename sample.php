<?php
    session_start();
    
    if(isset($_SESSION['username'])){
        echo $_SESSION['username'];
    }
    else{
        echo "No session variable";
    }
?>