<?php
session_start();
include './includes/dbconfig.php';
$edate=$_POST['edate'];
$edate=date("Y-m-d", strtotime($edate));
?>
<div class="container">
        <div class="row">
            <?php
                $query="SELECT * FROM `event` where event_date='".$edate."'";
                $result= mysqli_query($con, $query);
                $count=mysqli_num_rows($result);
                if($count <= 0 ){
                    echo "<div class='alert alert-danger' role='alert'>No Records Found For That EventDate</div>";
                    echo "</div></div>";
                    exit;
                }
                while($records=mysqli_fetch_array($result)){
                   $total_groups = $records['total_groups'];
                   $total_players = $records['total_players'];
                   $group_list=explode('|',$records['group_list']);
                   $player_list=$records['player_list'];
                   $event_id=$records['event_id'];
                }
                $players_array=explode('|',$player_list);
                $finalArray=array();
                foreach ($players_array as $value){
                    array_push($finalArray, explode(',', $value));
                }
            ?>
            <ul class="nav nav-tabs">
                <?php
                    for($i=1;$i<=count($group_list);$i++){
                        if($i==1){
                            echo '<li class="active"><a data-toggle="tab" href="#G'.$i.'">G'.$i.'</a></li>';
                        }
                        else{
                            echo '<li><a data-toggle="tab" href="#G'.$i.'">G'.$i.'</a></li>';
                        }
                    }
                ?>
            </ul>
            <div class="tab-content">
                <?php   
                for($i=0;$i<count($group_list);$i++){
                    if($i==0){
                        $active='active';
                    }
                    else{
                        $active='';
                    }
                    echo "<div id='G".($i+1)."' class='tab-pane fade in {$active}'>";
                    echo '<h1>Group '.($i+1).'</h1>';
                    echo '<table class="table table-hover table-bordered table-responsive">';
                        for($j=-1;$j<count($finalArray[$i]);$j++){
                            if($j==-1){
                                echo '<thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Player</th>';      
                                            for ($k=65; $k<(65+count($finalArray[$i])); $k++) {  
                                                   echo "<th>";
                                                   echo $letter = chr($k);
                                                   echo "</th>";     
                                            }       
                                echo        '<th>Game Record</th>
                                            <th>Match Record</th>
                                            <th>Place</th>
                                        </tr>
                                      </thead>';
                            }
                            else{
                                echo '<tr> 
                                        <th scope="row">'.chr(($j+65)).'</th>'; 
                                        $u=$finalArray[$i][($j)];
                                        $qu="SELECT CONCAT(fname,' ',lname) as Name FROM `users` where user_id='$u'";
                                        $res=mysqli_query($con, $qu);
                                        while ($row = mysqli_fetch_array($res)) {
                                            $playerName=$row['Name'];
                                            echo "<td data-playerId='{$u}' class='G".($i+1)."PlayerCol".chr(($j+65))."'>{$row['Name']}</td>";
                                        }
                                        for ($k=0; $k<count($finalArray[$i]); $k++) {  
                                            if($k==$j){
                                                echo "<td data-i='{$i}' data-j='{$j} data-k='{$k}' style='cursor: not-allowed;background-color: #f5f5f5;'></td>";
                                            }
                                            else{
                                                $getrecordsQuery="SELECT `winner_game_count`,`looser_game_count`,winner_id,looser_id FROM `result_tt` WHERE `event_id`='".$event_id."' AND `group_id`='G".($i+1)."' AND (`winner_id`='{$u}' OR `looser_id`='{$u}') AND (`winner_id`='{$finalArray[$i][$k]}' OR `looser_id`='{$finalArray[$i][$k]}')";
                                                $res_get_rec=mysqli_query($con, $getrecordsQuery);
                                                $countRec=  mysqli_num_rows($res_get_rec);
                                                if($countRec >0 ){
                                                    $row=mysqli_fetch_row($res_get_rec);
                                                    if($row[2]==$u){
                                                        $dataTD='W '.$row[0];
                                                    }
                                                    else{
                                                        $dataTD='L '.$row[1];
                                                    }
                                                }
                                                else{
                                                    $dataTD='';
                                                }
                                                echo "<td class='tdclass' data-i='{$i}' data-j='{$j} data-k='{$k}' data-tdplayerid='{$u}' data-player='{$playerName}'  data-group='G".($i+1)."' data-rowno='".chr(($j+65))."'  data-colno='".chr(($k+65))."'  data-combination='G".($i+1)."-".chr(($j+65))."-".chr(($k+65))."'>{$dataTD}</td>";
                                            }       
                                        }
                                        $query_tt="SELECT `records`.`game_record` , `records`.`match_rocord`,`records`.`place` 
                                             FROM `users` 
                                             JOIN records ON records.player_id=users.user_id 
                                             where users.user_id='$u' AND records.group_id='G".($i+1)."' AND records.event_id='".$event_id."'";
                                        
                                        $res_tt=mysqli_query($con, $query_tt);
                                        $data_tt=mysqli_fetch_row($res_tt);
                                echo    "<td data-playeridGamerecord='{$u}'>$data_tt[0]</td> 
                                        <td  data-playeridmatchrecord='{$u}'>$data_tt[1]</td> 
                                        <td data-playeridplace='{$u}' data-groupPlace='G".($i+1)."' playerplace='Tie'>$data_tt[2]</td> 
                                      </tr>";
                            }
                      }  
                    echo '</table>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    <div class="row"><div class="container"> <button class="btn btn-primary btn-lg" id="submitResult"> E-mail To League Direcotrs</button>  </div></div>
    </div>