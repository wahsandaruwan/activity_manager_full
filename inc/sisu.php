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

    // Sign Up
    if(isset($_POST['su'])){
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $repass = mysqli_real_escape_string($conn, $_POST['repass']);

        // Validate Sign Up Information
        signUpValidation($conn,$user,$pass,$email,$repass);
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
                        $_SESSION['sumsg'] = "Type different username!";
                        $_SESSION['color'] = "#f32112";
                        header('location: ../si-su.php');
                    }
                    else if($count2 >= 1){
                        $_SESSION['sumsg'] = "Type different email!";
                        $_SESSION['color'] = "#f32112";
                        header('location: ../si-su.php');
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
                                    $_SESSION['sumsg'] = "Enter a valid email!";
                                    $_SESSION['color'] = "#f32112";
                                    header('location: ../si-su.php');
                                }
                            }
                            else{
                                $_SESSION['sumsg'] = "Enter a password that has more than 5 characters";
                                $_SESSION['color'] = "#f32112";
                                header('location: ../si-su.php');
                            }
                        }
                        else{
                            $_SESSION['sumsg'] = "Type same password in 'Re-Type Password' box!";
                            $_SESSION['color'] = "#f32112";
                            header('location: ../si-su.php');
                        }
                        
                    }
                }
            }
            catch(Exception $e){
                $_SESSION['sumsg'] = $e->getMessage();
                $_SESSION['color'] = "#f32112";
                header('location: ../si-su.php');
            }
        }
        else{
            $_SESSION['sumsg'] = "Please fill all fields!";
            $_SESSION['color'] = "#f32112";
            header('location: ../si-su.php');
        }
    }

    // Sign Up Function
    function signUp($conn,$user,$pass,$email){
        $iquery = "INSERT INTO users(username,email,pass) VALUES('$user','$email','$pass')";
        
        // Error Handling
        try{
            if(!mysqli_query($conn, $iquery)){
                throw new Exception('Cannot signup properly due to database issue!');
            }
            else{
                header('location: ../index.php');
            }
        }
        catch(Exception $e){
            $_SESSION['sumsg'] = $e->getMessage();
            $_SESSION['color'] = "#f32112";
            header('location: ../si-su.php');
        }
    }
?>