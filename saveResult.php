<?php
    include './includes/dbconfig.php';
  
    $event_id=$_POST['event_id'];
    $group_id=$_POST['group_id'];
    $winner_id=$_POST['winner_id'];
    $looser_id=$_POST['looser_id'];
    $winner_game_count=$_POST['winner_game_count'];
    $looser_game_count=$_POST['looser_game_count'];
    $query="INSERT INTO `result_tt`(`event_id`, `group_id`, `winner_id`, `looser_id`, `winner_game_count`, `looser_game_count`)
                            VALUES ('$event_id','$group_id','$winner_id','$looser_id','$winner_game_count','$looser_game_count')";
    $q = mysqli_query($con, $query);
    if($q){
        echo json_encode(array('error'=>'false','message'=>'success'));
    }
    else{
        echo json_encode(array('error'=>'true','message'=>'something went wrong'));
    }
?>