<?php
    include './includes/dbconfig.php';
    $firstname = !empty($_POST['fname']) ? $_POST['fname'] : '';
    $lastname  = !empty($_POST['lname']) ? $_POST['lname'] : '';
    $groupId  = !empty($_POST['groupId']) ? $_POST['groupId'] : '';
    $query = mysqli_query($con, 'INSERT INTO users (fname,lname) 
               VALUES ("'.$firstname .'","'.$lastname.'")');

    if($query){
        echo json_encode(array('error' => 'false','groupId'=>$groupId, 'msg' => 'New Player Added Successfully','last_inserted_id'=>mysqli_insert_id($con)));
        die();
    }
    else{
        echo json_encode(array('error' => 'true', 'msg' => 'Doh! Something went wrong.'));
        die();
    }
    
?>