<?php
    include './includes/dbconfig.php';
    $array=json_decode($_POST['user_id']);
    $array=  implode(',', $array);
    $date=date('Y-m-d h:i:s');
    $query=mysqli_query($con,'INSERT INTO list_for_the_day (day_date,user_list) VALUES ("'.$date.'","'.$array.'")');
    if($query){        
        $records=mysqli_query($con,'SELECT * from users WHERE users.user_id IN ('.$array.') ORDER BY users.rating DESC');
        $temp=array();
        while ($row = mysqli_fetch_assoc($records)) {             
               array_push($temp, $row);
        }
        $j=0;
        for($i=0;$i<count($temp);$i=$i+6){
            $output[$j] = array_slice($temp, $i, 6);
            $j++;
        }
        $k=1;
        foreach ($output as $value) {
            echo '<div class="col-md-4 col-sm-4">
                    <div class="panel panel-success">
                      <div class="panel-heading"><h4><i class="fa fa-fw fa-check"></i>Group '.$k.'</h4></div>
                          <div class="panel-body">
                            <ul id="sortable'.$k.'" class="sortable_list connectedSortable ">';
            foreach ($value as $v) {
                echo '<li>
                      <span class="label label-success">'.$v['member_id'].'</span>
                      <span class="label label-info">'.$v['fname'].' '.$v['lname'].'</span>
                      <span class="label label-warning">'.$v['rating'].'</span>
                      </li>';
            }
            echo '</ul></div></div></div>';
            $k++;
        }
    }    
?>