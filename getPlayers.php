<?php
    include './includes/dbconfig.php';
    $result=mysqli_query($con,"SELECT * FROM `users`");
    while($row= mysqli_fetch_assoc($result)){
        echo '<li class="click_area" data-value='.json_encode($row).' data-id='.$row['user_id'].'><span class="label label-success">'.$row['member_id'].'</span>
                  <span class="label label-info">'.$row['fname'].' '.$row['lname'].'</span>
                  <span class="label label-warning">'.$row['rating'].'</span></li>';        
    }
?>
