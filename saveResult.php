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
    $winnerPlaceDB = $_POST['winnerPlaceDB'];
    $looserPlaceDB = $_POST['looserPlaceDB'];
    $playerPlaceIDArray=$_POST['playerPlaceIDArray'];
    $flag=FALSE;     
    
    $get_Result_tt_query="SELECT * FROM  `result_tt` WHERE `event_id`='$event_id' AND `group_id` = '$group_id' AND `winner_id`= '$winner_id' AND `looser_id` = '$looser_id'";
    $Result_tt = mysqli_query($con, $get_Result_tt_query);
    $Result_tt_count=  mysqli_num_rows($Result_tt);
    if($Result_tt_count > 0){
        $updateQuery="UPDATE `result_tt` SET `winner_game_count` ='$winner_game_count' , `looser_game_count`='$looser_game_count' WHERE `event_id`='$event_id' AND `group_id` = '$group_id' AND `winner_id`= '$winner_id' AND `looser_id` = '$looser_id'";
        $q = mysqli_query($con, $updateQuery);
        if($q){
            $flag=TRUE;
        }
    }
    else {
        $query="INSERT INTO `result_tt`(`event_id`, `group_id`, `winner_id`, `looser_id`, `winner_game_count`, `looser_game_count`)
                            VALUES ('$event_id','$group_id','$winner_id','$looser_id','$winner_game_count','$looser_game_count')";
        $q = mysqli_query($con, $query);
        if($q){
            $flag=TRUE;
        }
    }
    
    
    
    $getW="SELECT * FROM `records` WHERE `event_id`='$event_id' AND `group_id`='$group_id' AND `player_id`='$winner_id'";
    $result= mysqli_query($con,$getW);
    $count=  mysqli_num_rows($result);
    if($count > 0){
        $queryRecords="UPDATE `records` SET `game_record`='$winner_game_record',`match_rocord`='$winner_Match_Record' , `place`='$winnerPlaceDB'  WHERE `group_id`='$group_id' AND `player_id`='$winner_id' AND `event_id`='$event_id'";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    else{
        $queryRecords="INSERT INTO `records`(`event_id`, `group_id`, `player_id`, `game_record`, `match_rocord` , `place`) 
                                 VALUES ('$event_id','$group_id','$winner_id','$winner_game_record','$winner_Match_Record','$winnerPlaceDB')";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    //looser
    $getL="SELECT * FROM `records` WHERE `event_id`='$event_id' AND `group_id`='$group_id' AND `player_id`='$looser_id'";
    $result= mysqli_query($con,$getL);
    $count=  mysqli_num_rows($result);
    if($count > 0){
        $queryRecords="UPDATE `records` SET `game_record`='$looser_game_record',`match_rocord`='$looser_Match_Record' , `place`='$looserPlaceDB'  WHERE `group_id`='$group_id' AND `player_id`='$looser_id' AND `event_id`='$event_id'";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    else{
        $queryRecords="INSERT INTO `records`(`event_id`, `group_id`, `player_id`, `game_record`, `match_rocord` , `place`) 
                                 VALUES ('$event_id','$group_id','$looser_id','$looser_game_record','$looser_Match_Record','$looserPlaceDB')";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    
    foreach ($playerPlaceIDArray as $key => $value) { 
       $placequeryRecords="UPDATE `records` SET `place`='$value'  WHERE `group_id`='$group_id' AND `player_id`='$key' AND `event_id`='$event_id'";
       $q = mysqli_query($con, $placequeryRecords);
       if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    
    if($flag==TRUE){
        echo json_encode(array('error'=>'false','message'=>'success'));
    }
    else{
        echo json_encode(array('error'=>'true','message'=>'something went wrong'));
    }
   
?>