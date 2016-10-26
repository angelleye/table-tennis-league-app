<?php
    include './includes/dbconfig.php';
  
    $event_id=$_POST['event_id'];
    $group_id=$_POST['group_id'];
    $winner_id=$_POST['winner_id'];
    $looser_id=$_POST['looser_id'];
    $winner_game_count=$_POST['winner_game_count'];
    $looser_game_count=$_POST['looser_game_count'];    
    $winner_Match_Record = $_POST['winner_Match_Record'];
    $winner_game_record = $_POST['winner_game_record'];
    $looser_Match_Record = $_POST['looser_Match_Record'];
    $looser_game_record = $_POST['looser_game_record'];
    $flag=FALSE;     
         
    $query="INSERT INTO `result_tt`(`event_id`, `group_id`, `winner_id`, `looser_id`, `winner_game_count`, `looser_game_count`)
                            VALUES ('$event_id','$group_id','$winner_id','$looser_id','$winner_game_count','$looser_game_count')";
    $q = mysqli_query($con, $query);
    if($q){
        $flag=TRUE;
    }
    
    $getW="SELECT * FROM `records` WHERE `event_id`='$event_id' AND `group_id`='$group_id' AND `player_id`='$winner_id'";
    $result= mysqli_query($con,$getW);
    $count=  mysqli_num_rows($result);
    if($count > 0){
        $queryRecords="UPDATE `records` SET `game_record`='$winner_game_record',`match_rocord`='$winner_Match_Record' WHERE `group_id`='$group_id' AND `player_id`='$winner_id' AND `group_id`='$group_id'";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    else{
        $queryRecords="INSERT INTO `records`(`event_id`, `group_id`, `player_id`, `game_record`, `match_rocord`) 
                                 VALUES ('$event_id','$group_id','$winner_id','$winner_game_record','$winner_Match_Record')";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    //looser
    $getL="SELECT * FROM `records` WHERE `event_id`='$event_id' AND `group_id`='$group_id' AND `player_id`='$looser_id'";
    $result= mysqli_query($con,$getL);
    $count=  mysqli_num_rows($result);
    if($count > 0){
        $queryRecords="UPDATE `records` SET `game_record`='$looser_game_record',`match_rocord`='$looser_Match_Record' WHERE `group_id`='$group_id' AND `player_id`='$looser_id' AND `group_id`='$group_id'";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    else{
        $queryRecords="INSERT INTO `records`(`event_id`, `group_id`, `player_id`, `game_record`, `match_rocord`) 
                                 VALUES ('$event_id','$group_id','$looser_id','$looser_game_record','$looser_Match_Record')";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    
    if($flag==TRUE){
        echo json_encode(array('error'=>'false','message'=>'success'));
    }
    else{
        echo json_encode(array('error'=>'true','message'=>'something went wrong'));
    }
   
?>