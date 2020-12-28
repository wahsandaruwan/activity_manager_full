<?php
    session_start();
    // ---Functions for Sign In and Sign Up Operations---
    // Sign up info validation function 
    function signUpValidation($conn,$user,$pass,$email,$repass){
        // Error handling
        if(!empty($user) && !empty($pass) && !empty($email) && !empty($repass)){
            $suquery1 = "SELECT * FROM users WHERE username = '$user'";
            $suquery2 = "SELECT * FROM users WHERE email = '$email'";
            $result1 = mysqli_query($conn, $suquery1);
            $result2 = mysqli_query($conn, $suquery2);

            try{
                if(!$result1 || !$result2){
                    throw new Exception('Cannot fetch data from the database!');
                }
                else{
                    // Check the availability of username and email
                    $count1 = mysqli_num_rows($result1);
                    $count2 = mysqli_num_rows($result2);
                    if($count1 >= 1){
                        header('location: ../si-su.php?sumsg=Type different username!&color=f32112');
                    }
                    else if($count2 >= 1){
                        header('location: ../si-su.php?sumsg=Type different email!&color=f32112');
                    }
                    else{
                        // Check the password
                        if($pass == $repass){
                            if(strlen($pass) > 5){
                                // Check Email
                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    // Calling SignUp Function
                                    signUp($conn,$user,$pass,$email);
                                } 
                                else {
                                    header('location: ../si-su.php?sumsg=Enter a valid email!&color=f32112');
                                }
                            }
                            else{
                                header('location: ../si-su.php?sumsg=Enter a password that has more than 5 characters!&color=f32112');
                            }
                        }
                        else{
                            header('location: ../si-su.php?sumsg=Type same password in "Re-Type Password" box!&color=f32112');
                        }
                        
                    }
                }
            }
            catch(Exception $e){
                header('location: ../si-su.php?sumsg='.$e->getMessage().'&color=f32112');
            }
        }
        else{
            header('location: ../si-su.php?sumsg=Please fill all fields!&color=f32112');
        }
    }

    // SignUp function
    function signUp($conn,$user,$pass,$email){
        // Encrypt password
        $enpass = md5($pass); 
        $iquery = "INSERT INTO users(username,email,pass) VALUES('$user','$email','$enpass')";
        
        // Error handling
        try{
            if(!mysqli_query($conn, $iquery)){
                throw new Exception('Cannot signup properly due to database issue!');
            }
            else{
                // Create a session variable
                $_SESSION['username'] = $user;
                header('location: ../index.php?user='.$_SESSION["username"].'&msg=You are now logged in!&color=0e5e0e');
            }
        } 
        catch(Exception $e){
            header('location: ../si-su.php?sumsg='.$e->getMessage().'&color=f32112');
        }
    }

    // ---Functions for Main Crud Operations---
    // Select Function
    function selectRecords($user, $conn){
        $squery = "SELECT * FROM data WHERE user='$user' ORDER BY id ASC";
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
            header('location: ../index.php?msg='.$e->getMessage().'&color=f32112');
        }
    }

    // Insert Function
    function insertRecord($activity, $date, $time, $status, $user, $conn){
        $iquery = "INSERT INTO data(activity,date1,time1,status1,user) VALUES('$activity','$date','$time','$status','$user')";
        
        // Error Handling
        if(!empty($activity) && !empty($date) && !empty($time) && !empty($status)){
            try{
                if(!mysqli_query($conn, $iquery)){
                    throw new Exception('Cannot insert the data into database!');
                }
                else{
                    header('location: ../index.php?msg=Activity Succesfully Added!&color=0e5e0e');
                }
            }
            catch(Exception $e){
                header('location: ../index.php?msg='.$e->getMessage().'&color=f32112');
            }
        }
        else{
            header('location: ../index.php?msg=Fill all given fields!&color=f32112');
        }
    }

    // Update Function
    function updateRecord($activity, $date, $time, $status, $id, $user, $conn){
        $uquery = "UPDATE data SET activity='$activity', date1='$date', time1='$time', status1='$status' WHERE id=$id AND user='$user'";
        
        // Error Handling
        if(!empty($activity) && !empty($date) && !empty($time) && !empty($status) && !empty($id)){
            try{
                if(!mysqli_query($conn, $uquery)){
                    throw new Exception('Cannot update the data of the selected record!');
                }
                else{
                    header('location: ../index.php?msg=Activity Succesfully Updated!&color=0e5e0e');
                }
            }
            catch(Exception $e){
                header('location: ../index.php?msg='.$e->getMessage().'&color=f32112');
            }
        }
        else{
            header('location: ../index.php?msg=Fill l given fields!&color=f32112');
        }
    }

    // Delete Function
    function deleteRecord($id, $user, $conn){
        $dquery = "DELETE FROM data WHERE id=$id AND user='$user'";
        
        // Error Handling
        try{
            if(!mysqli_query($conn, $dquery)){
                throw new Exception('Cannot Delete the selected record!');
            }
            else{
                // Reset ID
                resetID($conn);
                header('location: ./index.php?msg=Activity Succesfully Deleted!&color=0e5e0e');
            }
        }
        catch(Exception $e){
            header('location: ../index.php?msg='.$e->getMessage().'&color=f32112');
        }
    }

    // Search Function
    function searchRecord($search, $user, $conn){
        $sequery = "SELECT * FROM data WHERE (activity LIKE '%$search%' OR date1 LIKE '%$search%' OR time1 LIKE '%$search%' OR status1 LIKE '%$search%') AND user='$user' ORDER BY id ASC";
        $result = mysqli_query($conn, $sequery);

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
            header('location: ../index.php?msg='.$e->getMessage().'&color=f32112');
        }
    }

    // ID Resetting Function
    function resetID($conn){
        $line1 = "SET @autoid := 0";
        $line2 = "UPDATE data set id = @autoid := (@autoid+1)";
        $line3 = "ALTER TABLE data AUTO_INCREMENT = 1";

        $qarr = array($line1, $line2, $line3);

        foreach($qarr as $q){
            // Error Handling
            try{
                if(!mysqli_query($conn, $q)){
                    throw new Exception('Cannot Reset the ID!');
                }
            }
            catch(Exception $e){
                header('location: ../index.php?msg='.$e->getMessage().'&color=f32112');
            }
        }
    }

    // Status Selecting Function
    function selectdCheck($value1,$value2)
    {
        if ($value1 == $value2){
            echo 'selected="selected"';
        } 
        else {
            echo '';
        }
        return;
    }
?>