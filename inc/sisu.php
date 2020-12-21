<?php
    // Start a Session
    session_start();
    // DB Connection
    require_once 'dbh.inc.php';

    // Sign In
    if(isset($_POST['si'])){
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        echo "dsvv";
    }

    // Sign Up
    if(isset($_POST['su'])){
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $repass = mysqli_real_escape_string($conn, $_POST['repass']);

        // Validate Sign Up Information
        signUpValidation($conn,$user,$pass,$email,$repass);
    }

    // Sign Out
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        header('location: ./index.php?msg=You are now logged out!&color=0e5e0e');
    }

    // Sign up info validation Function 
    function signUpValidation($conn,$user,$pass,$email,$repass){
        // Check If Inputs are Empty
        if(!empty($user) && !empty($pass) && !empty($email) && !empty($repass)){
            $suquery1 = "SELECT * FROM users WHERE username = '$user'";
            $suquery2 = "SELECT * FROM users WHERE email = '$email'";
            $result1 = mysqli_query($conn, $suquery1);
            $result2 = mysqli_query($conn, $suquery2);

            // Error Handling
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

    // SignUp Function
    function signUp($conn,$user,$pass,$email){
        // Encrypt password
        $enpass = md5($pass); 
        $iquery = "INSERT INTO users(username,email,pass) VALUES('$user','$email','$enpass')";
        
        // Error Handling
        try{
            if(!mysqli_query($conn, $iquery)){
                throw new Exception('Cannot signup properly due to database issue!');
            }
            else{
                $_SESSION['username'] = $user;
                header('location: ../index.php?user='.$_SESSION["username"].'&msg=You are now logged in!&color=0e5e0e');
            }
        } 
        catch(Exception $e){
            header('location: ../si-su.php?sumsg='.$e->getMessage().'&color=f32112');
        }
    }

    
?>