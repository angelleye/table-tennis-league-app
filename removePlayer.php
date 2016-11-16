<?php
    session_start();
    include './includes/dbconfig.php';
    $event_id=$_POST['event_id'];
    $removePlayerId = !empty($_POST['removePlayerId']) ? $_POST['removePlayerId'] : '';
    $removeGroupId = !empty($_POST['removeGroupId']) ? $_POST['removeGroupId'] : '';
    
    $number=$removePlayerId;
    $getQuery=  mysqli_query($con, "SELECT `player_list`,`total_players` FROM `event` WHERE event_id='$event_id'");
    $result=  mysqli_fetch_row($getQuery);
    $str=$result[0];
    $group=$removeGroupId;
    $groupNo=substr($group,1);
    $array=explode('|',$str);
    $temp = explode(',', $array[($groupNo-1)]);
    if (($key = array_search($number, $temp)) !== false) {
      unset($temp[$key]);
    }
    $sub_str = implode(',', $temp);
    $array[($groupNo-1)]=$sub_str;
    $finalStr=implode('|',$array);
    $total_players=($result[1]-1);
    
    $updateQuery=mysqli_query($con, "UPDATE `event` SET `player_list`='$finalStr',`total_players`='$total_players' WHERE event_id='$event_id'");
   
    echo json_encode(array('error' => 'false','msg'=>'Removed successfully'));
    die();
?>