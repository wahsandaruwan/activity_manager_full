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
        </div>

        <div class="su">
            <h3>Sign Up</h3>
            <form action="./inc/sisu.php" method="POST">
                <div class="inputs">
                    <input type="text" name="user" placeholder="Username">
                    <input type="email" name="email" placeholder="Email">
                    <input type="password" name="user" placeholder="Password">
                    <input type="password" name="user" placeholder="Retype Password">
                </div>
                <button type="submit" name="su">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>