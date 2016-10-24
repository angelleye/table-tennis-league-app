<?php
    session_start();
    include './includes/dbconfig.php';    
    $query="SELECT * FROM `event` where event_id='".$_SESSION['event_id']."'";
    $result= mysqli_query($con, $query);
    while($records=mysqli_fetch_array($result)){
       $total_groups = $records['total_groups'];
       $total_players = $records['total_players'];
       $group_list=explode('|',$records['group_list']);
       $player_list=$records['player_list'];
    }
    $players_array=explode('|',$player_list);
    $finalArray=array();
    foreach ($players_array as $value){
        array_push($finalArray, explode(',', $value));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <title>KCTT League App</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="js/bootstrapvalidator-master/dist/css/bootstrapValidator.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
       <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container col-lg-offset-5 col-md-offset-5 col-sm-offset-5 col-xs-offset-4">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand myLogo" href="#"><img src="images/logo.png"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php"  style="cursor: pointer">Start Over</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="clearfix" style="margin-top: 60px"></div>
    <div class="container">
        <div class="row">
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
                for($i=0;$i<=count($group_list);$i++){
                    if($i==0){
                        echo '<div id="G'.($i+1).'" class="tab-pane fade in active">';
                        echo '<h1>G'.($i+1).'</h1>';
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
                                                $qu="SELECT CONCAT(fname,lname) as Name FROM `users` where user_id='$u'";
                                                $res=mysqli_query($con, $qu);
                                                while ($row = mysqli_fetch_array($res)) {
                                                    echo "<td>{$row['Name']}</td>";
                                                }
                                                for ($k=0; $k<count($finalArray[$i]); $k++) {  
                                                    if($k==$j){
                                                        echo "<td data-i='{$i}' data-j='{$j} data-k='{$k}' style='cursor: not-allowed;background-color: #f5f5f5;'></td>";
                                                    }
                                                    else{
                                                        echo "<td data-i='{$i}' data-j='{$j} data-k='{$k}'></td>";
                                                    }       
                                                } 
                                        echo    '<td></td> 
                                                <td></td> 
                                                <td></td> 
                                              </tr> ';
                                    }
                              }  
                        echo '</table>';
                        echo '</div>';
                    }
                    else{
                        echo '<div id="G'.($i+1).'" class="tab-pane">';
                        echo '<h1>G'.($i+1).'</h1>';
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
                                                <th scope="row">'.chr(($j+65)).'</th> ';
                                                $u=$finalArray[$i][($j)];
                                                $qu="SELECT CONCAT(fname,lname) as Name FROM `users` where user_id='$u'";
                                                $res=mysqli_query($con, $qu);
                                                while ($row = mysqli_fetch_array($res)) {
                                                    echo "<td>{$row['Name']}</td>";
                                                }
                                                for ($k=0; $k<count($finalArray[$i]); $k++) {  
                                                    if($k==$j){
                                                        echo "<td data-i='{$i}' data-j='{$j} data-k='{$k}' style='cursor: not-allowed;background-color: #f5f5f5;'></td>";
                                                    }
                                                    else{
                                                        echo "<td data-i='{$i}' data-j='{$j} data-k='{$k}'></td>";
                                                    }
                                                }        

                                        echo    '<td></td> 
                                                <td></td> 
                                                <td></td> 
                                              </tr> ';
                                    }
                              }  
                        echo '</table>';
                        echo '</div>';
                    }                    
                }
                ?>
<!--                <div id="G1" class="tab-pane fade in active">
                    <h1>G1</h1>
                    <table class="table table-hover table-bordered table-responsive"> 
                <thead>
                        <tr> 
                        <th>#</th> 
                        <th>Player</th> 
                        <th>A</th> 
                        <th>B</th> 
                        <th>C</th> 
                        <th>D</th> 
                        <th>E</th> 
                        <th>F</th> 
                        <th>Game Record</th> 
                        <th>Match Record</th> 
                        <th>Place</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <tr> 
                        <th scope="row">A</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr> 
                    <tr> 
                        <th scope="row">B</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td>  
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr> 
                    <tr> 
                        <th scope="row">C</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">D</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td>  
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">E</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">F</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                </tbody> 
            </table>
                </div>
                <div id="G2" class="tab-pane fade">
                    <h1>G2</h1>
                    <table class="table table-hover table-bordered table-responsive"> 
                <thead>
                    <tr> 
                        <th>#</th> 
                        <th>Player</th> 
                        <th>A</th> 
                        <th>B</th> 
                        <th>C</th> 
                        <th>D</th> 
                        <th>E</th> 
                        <th>F</th> 
                        <th>Game Record</th> 
                        <th>Match Record</th> 
                        <th>Place</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <tr> 
                        <th scope="row">A</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr> 
                    <tr> 
                        <th scope="row">B</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td>  
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr> 
                    <tr> 
                        <th scope="row">C</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">D</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td>  
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">E</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">F</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                </tbody> 
            </table>
                </div>
                <div id="G3" class="tab-pane fade">
                    <h1>G3</h1>
                  <table class="table table-hover table-bordered table-responsive"> 
                <thead>
                    <tr> 
                        <th>#</th> 
                        <th>Player</th> 
                        <th>A</th> 
                        <th>B</th> 
                        <th>C</th> 
                        <th>D</th> 
                        <th>E</th> 
                        <th>F</th> 
                        <th>Game Record</th> 
                        <th>Match Record</th> 
                        <th>Place</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <tr> 
                        <th scope="row">A</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr> 
                    <tr> 
                        <th scope="row">B</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td>  
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr> 
                    <tr> 
                        <th scope="row">C</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">D</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td>  
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">E</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">F</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                </tbody> 
            </table>
                </div>
                <div id="G4" class="tab-pane fade">
                    <h1>G4</h1>
                  <table class="table table-hover table-bordered table-responsive"> 
                <thead>
                    <tr> 
                        <th>#</th> 
                        <th>Player</th> 
                        <th>A</th> 
                        <th>B</th> 
                        <th>C</th> 
                        <th>D</th> 
                        <th>E</th> 
                        <th>F</th> 
                        <th>Game Record</th> 
                        <th>Match Record</th> 
                        <th>Place</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <tr> 
                        <th scope="row">A</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr> 
                    <tr> 
                        <th scope="row">B</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td>  
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr> 
                    <tr> 
                        <th scope="row">C</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">D</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td>  
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">E</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                    <tr> 
                        <th scope="row">F</th> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                    </tr>
                </tbody> 
            </table>
                </div>-->
            </div>
           
        </div>
    </div>
</body>
    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrapvalidator-master/dist/js/bootstrapValidator.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/daterangepicker.js"></script>
</html>
