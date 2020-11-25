<?php
    // DB Connection
    include './inc/dbh.inc.php';
    // CRUD File
    include './inc/crud.inc.php';
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
                    <input type="text" name = "id" disabled>
                </div>

                <div class="ui">
                    <label>Activity : </label>
                    <input type="text" name = "activity">
                </div>

                <div class="ui">
                    <label>Date : </label>
                    <input type="date" name = "date">
                </div>

                <div class="ui">
                    <label>Time : </label>
                    <input type="time" name = "time">
                </div>

                <div class="ui sel">
                    <label>Status : </label>
                    <select name="status" id="">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                        <option value="pending">Pending</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                <div class="ui">
                    <button type="submit" name="save" class="sbtn">Save Activity</button>
                </div>
            </form>
            <!-- Message -->
            <div class="msg" name="message"></div>
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
                        $result = selectRecords($conn);
                        while($row = mysqli_fetch_array($result)) {?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['activity']; ?></td>
                                <td><?php echo $row['date1']; ?></td>
                                <td><?php echo $row['time1']; ?></td>
                                <td><?php echo $row['status1']; ?></td>
                                <td><a href="#" class="edit">Edit</a></td>
                                <td><a href="#" class="delete">Delete</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>