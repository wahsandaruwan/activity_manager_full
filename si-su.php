<?php
    // Sign In Sign Up File
    include './inc/sisu.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In or Sign Up</title>
    <link rel="stylesheet" href="./css/style2.css">
</head>
<body>
    <div class="container">
        <div class="si">
            <h3>Sign In</h3>
            <form action="./inc/sisu.php" method="POST">
                <div class="inputs">
                    <input type="text" name="user" placeholder="Username">
                    <input type="password" name="pass" placeholder="Password">
                </div>
                <div class="re">
                    <input type="checkbox" name="check">
                    <label for="">Remember Me</label>
                </div>
                <button type="submit" name="si">Sign In</button>
            </form>
            <!-- Message -->
            <?php 
                if(isset($_SESSION['lrmsg'])){ 
                    echo '<p style = "background:#fff; font-weight: 500; color:'.$_SESSION['color'].'; padding: 8px 12px;">'.$_SESSION['lrmsg'].'</p>';
                    // session_unset();
                }
            ?>
        </div>

        <div class="su">
            <h3>Sign Up</h3>
            <form action="./inc/sisu.php" method="POST">
                <div class="inputs">
                    <input type="text" name="user" placeholder="Username">
                    <input type="text" name="email" placeholder="Email">
                    <input type="password" name="pass" placeholder="Password">
                    <input type="password" name="repass" placeholder="Retype Password">
                </div>
                <button type="submit" name="su">Sign Up</button>
            </form>
            <!-- Message -->
            <?php 
                if(isset($_GET['sumsg']) && isset($_GET['color'])){
                     echo '<p style = "background:#fff; font-weight: 500; color:#'.$_GET['color'].'; padding: 8px 12px;">'.$_GET['sumsg'].'</p>';
                    //  unset($_SESSION['sumsg']);
                }
            ?>
        </div>
    </div>
</body>
</html>