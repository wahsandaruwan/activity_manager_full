<?php
    // DB Connection
    include './inc/dbh.inc.php';
    // CRUD File
    include './inc/crud.inc.php';
    // Sign In Sign Up File
    include './inc/sisu.php';

    // Fetch the Record to be Updated
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $edit_state = true;

        $rec = mysqli_query($conn, "SELECT * FROM data WHERE id = $id");

         // Error Handling
         try{
            if(!$rec){
                throw new Exception('Cannot Fetch the Record!');
            }
            else{
                $record = mysqli_fetch_array($rec);
                $id = $record['id'];
                $activity = $record['activity'];
                $date = $record['date1'];
                $time = $record['time1'];
                $status = $record['status1'];
            }
        }
        catch(Exception $e){
            $_SESSION['msg'] = $e->getMessage();
            $_SESSION['color'] = "#f32112";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Management</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">Activity <span>Manager</span></div>
            <ul class="menu">
                <?php
                    if(isset($_SESSION['username'])){ ?>
                        <li><a href="./index.php?logout='1'">Sign Out</a></li>
                        <li><a href="#">Get CSV</a></li>
                        <li class="ref"><a href="./index.php"><i class="fas fa-sync"></i></a></li>
                <?php
                    }
                    else{ ?>
                        <li><a href="./si-su.php">SigIn / SignUp</a></li>
                <?php
                    }
                ?>
            </ul>
        </nav>
    </header>

    <!-- Container -->
    <div class="container<?php if(!isset($_SESSION['username'])) echo ' diselement';?>">
        <!-- Form Section -->
        <div class="inputfrm">
            <form action="./inc/crud.inc.php" method = "POST">
                <div class="ui">
                    <label>ID : </label>
                    <input type="text" name = "id" value = "<?php echo $id; ?>" class="diselement">
                </div>

                <div class="ui">
                    <label>Activity : </label>
                    <input type="text" name = "activity" value = "<?php echo $activity ?>">
                </div>

                <div class="ui">
                    <label>Date : </label>
                    <input type="date" name = "date" value = "<?php echo $date ?>">
                </div>

                <div class="ui">
                    <label>Time : </label>
                    <input type="time" name = "time" value = "<?php echo $time ?>">
                </div>

                <div class="ui sel">
                    <label>Status : </label>
                    <select name="status" id="">
                        <option <?php selectdCheck($status,'no'); ?> value="no">No</option>
                        <option <?php selectdCheck($status,'yes'); ?> value="yes">Yes</option>
                        <option <?php selectdCheck($status,'pending'); ?> value="pending">Pending</option>
                        <option <?php selectdCheck($status,'expired'); ?> value="expired">Expired</option>
                    </select>
                </div>

                <div class="ui">
                    <?php
                        if($edit_state ==  false){ ?>
                            <button type="submit" name="save" class="sbtn">Save Activity</button>
                    <?php }
                        else{ ?>
                            <button type="submit" name="update" class="sbtn">Update Activity</button>
                    <?php } ?>
                </div>
            </form>

            <!-- Message -->
            <div class="msg" name="message">
                <?php 
                    if(isset($_GET['msg']) && isset($_GET['color'])){
                        echo '<p style = "background:#fff; font-weight: 500; color:#'.$_GET['color'].'; padding: 8px 12px;">'.$_GET['msg'].'</p>';
                       //  unset($_SESSION['sumsg']);
                    }
                ?>
            </div>
        </div>

        <!-- Table Secion -->
        <div class="tab">
            <!-- Search -->
            <div class="search">
                <input type="text" placeholder = "Search...">
                <button>Search</button>
            </div>
            <!-- Actual Table -->
            <div class = "main">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>

                    <tbody>
                        <?php 
                            // Populate table if user logged in
                            if(isset($_SESSION['username'])){
                                $result = selectRecords($conn);
                                while($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['activity']; ?></td>
                                        <td><?php echo $row['date1']; ?></td>
                                        <td><?php echo $row['time1']; ?></td>
                                        <td><?php echo $row['status1']; ?></td>
                                        <td><a href="index.php?edit=<?php echo $row['id']; ?>" class="edit">Edit</a></td>
                                        <td><a href="index.php?delete=<?php echo $row['id']; ?>" class="delete">Delete</a></td>
                                    </tr>                                    
                                <?php } 
                            }
                            else{ ?>
                                <tr>
                                    <td colspan="7"><p class="sisunot">Sign In or Sign Up to use the App</p></td>
                                </tr>
                            <?php }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- User Name -->
            <div class="user">
                <?php if(isset($_SESSION['username'])) echo '<p>Username : '.$_SESSION['username'].'</p>' ?>
            </div>
        </div>
    </div>
</body>
</html>