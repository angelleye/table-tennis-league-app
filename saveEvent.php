<?php
    session_start();
    include './includes/dbconfig.php';
    $array = array();
    $player_list  = json_decode($_POST['player_list']);
    $player_list=array_filter(array_map('array_filter', $player_list));
    $totalPlayers = $_POST['totalPlayers'];
    $totalGroups  = $_POST['totalGroups'];
    $temp=array();
    foreach ($player_list as $value){
        array_push($temp,implode(',', $value));
    }    
    for($i=1;$i<=$totalGroups;$i++){
        $array[] = 'G'.$i;
    }
    $group_list=implode('|',$array);
    $player_list=implode('|', $temp);
    $eventDate=$_POST['event_date'];
    $query="INSERT INTO `event`(`event_date`, `group_list`, `player_list`, `total_players`, `total_groups`) 
                        VALUES ('$eventDate','$group_list','$player_list','$totalPlayers','$totalGroups')";
    $q = mysqli_query($con, $query);
    if($q){
        $_SESSION['event_id']= mysqli_insert_id($con);
        echo json_encode(array('error'=>'false','message'=>'success'));
    }
    else{
        echo json_encode(array('error'=>'true','message'=>'something went wrong'));
    }
    
?>