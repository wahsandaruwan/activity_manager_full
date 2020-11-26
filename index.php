<?php
    // DB Connection
    include './inc/dbh.inc.php';
    // CRUD File
    include './inc/crud.inc.php';

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

                $_SESSION['id'] = $record['id'];
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
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">Activity <span>Manager</span></div>
            <ul class="menu">
                <li><a href="#">Help</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- Container -->
    <div class="container">
        <!-- Form Section -->
        <div class="inputfrm">
            <form action="./inc/crud.inc.php" method = "POST">
                <div class="ui">
                    <label>ID : </label>
                    <input type="text" name = "id" value = "<?php echo $id; ?>" disabled>
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
                    <?php if($edit_state ==  false){ ?>
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
                    if(isset($_SESSION['msg'])){ 
                        echo '<p style = "background:#fff; font-weight: 500; color:'.$_SESSION['color'].'; padding: 8px 12px;">'.$_SESSION['msg'].'</p>';
                        session_unset();
                    }
                ?>
            </div>
        </div>

        <!-- Table Secion -->
        <div class="tab">
            <!-- Search -->
            <div class="search">
                <input type="text" placeholder = "Search...">
                <a href="#">Search</a>
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
                        // Populate Table
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
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>