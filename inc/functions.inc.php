<?php
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