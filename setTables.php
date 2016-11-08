<?php
    include './includes/dbconfig.php';
    $errors=array();
    
    $directorTable="CREATE TABLE `directoremails` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `emails` text NOT NULL , PRIMARY KEY (id)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    $query=  mysqli_query($con, $directorTable);
    if(!empty(mysqli_error_list($con))){
        $errors[0]=mysqli_error_list($con);
    }
    
    $eventTable="CREATE TABLE event(event_id int(11) NOT NULL AUTO_INCREMENT,
                   event_date varchar(25) NOT NULL, 
                   group_list text NOT NULL, 
                   player_list text NOT NULL, 
                   total_players int(11) NOT NULL,
                   total_groups int(11) NOT NULL,
                   PRIMARY KEY (event_id),INDEX(event_id) )
                ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $query=  mysqli_query($con, $eventTable);
    if(!empty(mysqli_error_list($con))){
        $errors[1]=mysqli_error_list($con);
    }    
    
    $resultTable="CREATE TABLE `result_tt` ( `result_id` int(11) NOT NULL AUTO_INCREMENT,`event_id` int(11) NOT NULL,`group_id` varchar(255) NOT NULL,`winner_id` int(11) NOT NULL,
                               `looser_id` int(11) NOT NULL,`winner_game_count` varchar(255) NOT NULL,`looser_game_count` varchar(255) NOT NULL, PRIMARY KEY (result_id),INDEX(event_id)
                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $query=  mysqli_query($con, $resultTable);
    if(!empty(mysqli_error_list($con))){
        $errors[2]=mysqli_error_list($con);
    }
    
    
    $recordTable="CREATE TABLE `records` (
                        `records_id` int(11) NOT NULL AUTO_INCREMENT,
                        `event_id` int(11) NOT NULL,
                        `group_id` varchar(255) NOT NULL,
                        `player_id` int(11) NOT NULL,
                        `game_record` varchar(255) NOT NULL,
                        `match_rocord` varchar(255) NOT NULL,
                        `place` varchar(255) NOT NULL, PRIMARY KEY (`records_id`)
                         ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $query=  mysqli_query($con, $recordTable);
    if(!empty(mysqli_error_list($con))){
        $errors[3]=mysqli_error_list($con);
    }
    
    $userTable="CREATE TABLE `users` (
                `user_id` int(11) NOT NULL AUTO_INCREMENT,
                `member_id` int(11) NOT NULL,
                `fname` varchar(100) NOT NULL,
                `lname` varchar(100) NOT NULL,
                `mname` varchar(100) NOT NULL,
                `sex` varchar(50) NOT NULL,
                `rating` int(11) NOT NULL,
                `expiration` varchar(25) NOT NULL,
                `last_played` varchar(25) NOT NULL,
                `email` varchar(255) NOT NULL,PRIMARY KEY (user_id)
              ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    $query=  mysqli_query($con, $userTable);
    if(!empty(mysqli_error_list($con))){
        $errors[4]=mysqli_error_list($con);
    }           
    if(empty($errors)){
        echo json_encode(array('error'=>'false','message'=>'Success'));
    }
    else{
        echo json_encode(array('error'=>'true','message'=>$errors));
    }
?>

