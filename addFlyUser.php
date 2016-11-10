<?php
    session_start();
    include './includes/dbconfig.php';
    $event_id=$_SESSION['event_id'];
    $firstname = !empty($_POST['fname']) ? $_POST['fname'] : '';
    $lastname  = !empty($_POST['lname']) ? $_POST['lname'] : '';
    $groupId  = !empty($_POST['groupId']) ? $_POST['groupId'] : '';
    $query = mysqli_query($con, 'INSERT INTO users (fname,lname) 
               VALUES ("'.$firstname .'","'.$lastname.'")');
    $last=mysqli_insert_id($con);
    
    $number=$last;
    $getQuery=  mysqli_query($con, "SELECT `player_list`,`total_players` FROM `event` WHERE event_id='$event_id'");
    $result=  mysqli_fetch_row($getQuery);
    $str=$result[0];
    $group=$groupId;
    $groupNo=substr($group,1);
    $array=explode('|',$str);
    $temp = explode(',', $array[($groupNo-1)]);
    array_push($temp,$number);
    $sub_str = implode(',', $temp);
    $array[($groupNo-1)]=$sub_str;
    $finalStr=implode('|',$array);
    $total_players=($result[1]+1);

    $updateQuery=mysqli_query($con, "UPDATE `event` SET `player_list`='$finalStr',`total_players`='$total_players' WHERE event_id='$event_id'");
    
    if($query){
        echo json_encode(array('error' => 'false','fullname'=>$firstname.' '.$lastname,'groupId'=>$groupId, 'msg' => 'New Player Added Successfully','last_inserted_id'=>$last));
        die();
    }
    else{
        echo json_encode(array('error' => 'true', 'msg' => 'Doh! Something went wrong.'));
        die();
    }
    
?>