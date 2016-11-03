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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form id="gamePlayForm" role="form" method="post" action="">
                <input type="hidden" name="inputrowno" id="inputrowno" />
                <input type="hidden" name="inputcolno" id="inputcolno" />
                <input type="hidden" name="inputgroupno" id="inputgroupno" />
                <input type="hidden" name="inputrowPlayerId" id="inputrowPlayerId" />
                <input type="hidden" name="inputcolPlayerId" id="inputcolPlayerId" />
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Game Play</h4>
                  </div>
                  <div class="modal-body">
                      
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveTd">Save changes</button>
                  </div>
                </div>
            </form>
        </div>
    </div>
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
                for($i=0;$i<count($group_list);$i++){
                    if($i==0){
                        echo '<div id="G'.($i+1).'" class="tab-pane fade in active">';
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
                                                        echo "<td class='tdclass' data-i='{$i}' data-j='{$j} data-k='{$k}' data-tdplayerid='{$u}' data-player='{$playerName}'  data-group='G".($i+1)."' data-rowno='".chr(($j+65))."'  data-colno='".chr(($k+65))."'  data-combination='G".($i+1)."-".chr(($j+65))."-".chr(($k+65))."'></td>";
                                                    }       
                                                } 
                                        echo    "<td data-playeridGamerecord='{$u}'></td> 
                                                <td  data-playeridmatchrecord='{$u}'></td> 
                                                <td data-playeridplace='{$u}' data-groupPlace='G".($i+1)."' playerplace='Tie'>Tie</td> 
                                              </tr>";
                                    }
                              }  
                        echo '</table>';
                        echo '</div>';
                    }
                    else{
                        echo '<div id="G'.($i+1).'" class="tab-pane">';
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
                                                <th scope="row">'.chr(($j+65)).'</th> ';
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
                                                        echo "<td class='tdclass' data-i='{$i}' data-j='{$j} data-k='{$k}' data-tdplayerid='{$u}' data-player='{$playerName}'  data-group='G".($i+1)."' data-rowno='".chr(($j+65))."'  data-colno='".chr(($k+65))."'  data-combination='G".($i+1)."-".chr(($j+65))."-".chr(($k+65))."'></td>";
                                                    }
                                                }        

                                        echo    "<td data-playeridGamerecord='{$u}'></td> 
                                                <td  data-playeridmatchrecord='{$u}'></td> 
                                                <td data-playeridplace='{$u}' data-groupPlace='G".($i+1)."' playerplace='Tie'>Tie</td> 
                                              </tr> ";
                                    }
                              }  
                        echo '</table>';
                        echo '</div>';
                    }                    
                }
                ?>
            </div>
           
        </div>
        <div class="row"><div class="container"> <button class="btn btn-primary btn-lg" id="submitResult">Submit & E-mail All Results</button>  </div></div>
    </div>
</body>
    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrapvalidator-master/dist/js/bootstrapValidator.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/daterangepicker.js"></script>
</html>

<script type="text/javascript">
    $(document).on('click','.tdclass',function(){
        var group         = $(this).data('group');
        var combination   = $(this).data('combination');
        var colno         = $(this).data('colno');
        var rowno         = $(this).data('rowno');
        var rowPlayerName = $(this).data('player');
        var colPlayerName = $('.'+group+'PlayerCol'+colno).text();
        var rowPlayerId   = $(this).data('tdplayerid');
        var colPlayerId   = $('.'+group+'PlayerCol'+colno).data('playerid');
        $('#inputrowno').val(rowno);
        $('#inputcolno').val(colno);
        $('#inputgroupno').val(group);
        $('#inputrowPlayerId').val(rowPlayerId);
        $('#inputcolPlayerId').val(colPlayerId);
        var htmlStr='<div class="form-group"><label><span class="label label-success">'+ rowPlayerName +'</span> Plays with <span class="label label-success">'+ colPlayerName +'</span></label> </div> <div class="form-group"> <label>Winner</label> <div class="radio"> <label> <input type="radio" name="wr" id="w1" checked value="'+rowno+'">'+rowPlayerName+'</label> </div> <div class="radio"> <label> <input type="radio" name="wr" id="w2" value="'+colno+'">'+colPlayerName+' </label> </div> </div> <div class="form-group"> <label>Games</label> <input class="form-control" name="games" id="inputGames" autocomplete="off"/><i id="modalItag"></i><small id="modalSmalltag"></small></div>';
        
        $('#myModal')
                .find('.modal-body').html(htmlStr).end()
                .modal('show');
         $('#gamePlayForm').bootstrapValidator('addField', $('#inputGames'));
         //$('#gamePlayForm').bootstrapValidator('addField', $("input[name='wr']"));
    });
    function getGetOrdinal(n) {
        var s=["th","st","nd","rd"],
        v=n%100;
        return n+(s[(v-20)%10]||s[v]||s[0]);
    }
    function saveToTable(){
         var winner  =  $('input[name=wr]:checked').val();
         var looser  =  $('input[name=wr]:not(:checked)').val();
         var games   =  $('input[name=games]').val();
         var getrowno=  $('#inputrowno').val();
         var getcolno=  $('#inputcolno').val();
         var getgroupno=  $('#inputgroupno').val();
         var rowPlayerId= $('#inputrowPlayerId').val();
         var colPlayerId= $('#inputcolPlayerId').val();
         
         if(winner==getrowno && looser ==getcolno){
             var wcmb = getgroupno+'-'+getrowno+'-'+getcolno;
             var lcmb = getgroupno+'-'+getcolno+'-'+getrowno;
             $('*[data-combination="'+wcmb+'"]').text('W ' + games);
             var backway = games.split("").reverse().join("");
             $('*[data-combination="'+lcmb+'"]').text('L ' + backway);
             var winner_id=rowPlayerId;
             var looser_id=colPlayerId;
             var winner_left_sum=0;
             var winner_right_sum=0;
             var looser_left_sum=0;
             var looser_right_sum=0;
             var winner_match_record_left=0;
             var winner_match_record_right=0;
             var looser_match_record_left=0;
             var looser_match_record_right=0;
             var winnerPercentage=0;
             var names = [];
             var names2 = [];
             $('*[data-tdplayerid="'+rowPlayerId+'"]').each(function() {  
                 if($.trim($(this).html()).length > 0 || $.trim($(this).html()).length > '0'){
                     winner_left_sum += parseInt($.trim($(this).html()).substring(1,3));      
                     winner_right_sum += parseInt($.trim($(this).html()).substring(4));
                     if($.trim($(this).html()).substring(0,1)=='W'){
                         winner_match_record_left++;
                     }
                     else if ($.trim($(this).html()).substring(0,1)=='L'){
                         winner_match_record_right++;
                     }
                 }        
             });
             var winner_Match_Record = winner_match_record_left + '-' + winner_match_record_right;
             $('*[data-playeridmatchrecord="'+rowPlayerId+'"]').html('').html(winner_Match_Record);
             
             var winner_game_record= winner_left_sum +'-'+  winner_right_sum;
             $('*[data-playeridgamerecord="'+rowPlayerId+'"]').html('').html(winner_game_record);
             
             var winnerPercentage = ((parseInt(winner_match_record_left)*100)/parseInt(winner_match_record_left+winner_match_record_right)).toFixed();
             var winnerGameRecordPer = ((parseInt(winner_left_sum)*100)/parseInt(winner_left_sum+winner_right_sum)).toFixed();
             var winplayerPlace=winnerPercentage.toString()+winnerGameRecordPer.toString();
             $('*[data-playeridplace="'+rowPlayerId+'"]').attr('playerplace',winplayerPlace);
             
             
             //======col player
             $('*[data-tdplayerid="'+colPlayerId+'"]').each(function() {  
                 if($.trim($(this).html()).length > 0 || $.trim($(this).html()).length > '0'){
                     looser_left_sum += parseInt($.trim($(this).html()).substring(1,3));      
                     looser_right_sum += parseInt($.trim($(this).html()).substring(4));      
                     if($.trim($(this).html()).substring(0,1)=='W'){
                         looser_match_record_left++;
                     }
                     else if ($.trim($(this).html()).substring(0,1)=='L'){
                         looser_match_record_right++;
                     }
                 }        
             });
             
             var looser_Match_Record = looser_match_record_left + '-' + looser_match_record_right;
             $('*[data-playeridmatchrecord="'+colPlayerId+'"]').html('').html(looser_Match_Record);
             
             var looser_game_record= looser_left_sum +'-'+  looser_right_sum;
             $('*[data-playeridgamerecord="'+colPlayerId+'"]').html('').html(looser_game_record);
             
             var looserPercentage = ((parseInt(looser_match_record_left)*100)/parseInt(looser_match_record_left+looser_match_record_right)).toFixed();
             var looserGameRecordPer = ((parseInt(looser_left_sum)*100)/parseInt(looser_left_sum+looser_right_sum)).toFixed();
             var looserplayerPlace=looserPercentage.toString()+looserGameRecordPer.toString();
             
             $('*[data-playeridplace="'+colPlayerId+'"]').attr('playerplace',looserplayerPlace);
             
             $('*[data-groupPlace="'+getgroupno+'"]').each(function() {
                if($(this).attr('playerplace') != 'Tie'){
                      names.push(parseFloat($(this).attr('playerplace')));
                      $(this).addClass('gotPer'+getgroupno);
                }
             });
             var i=0;  
             var tempA = [];
            names.sort(function(a, b){
              if (isNaN(a) || isNaN(b)) {
                if (b > a) return -1;
                    else return 1;
              }
              return b - a;
            });  
             $.each(names, function (key,value) {
              if($.inArray(value, tempA) === -1) {
                   tempA.push(value);
               }else{
                  var indx=names.indexOf(value);
                  //console.log(value+" is a duplicate value");
                  names[key]='Tie';
                  names[indx]='Tie';
               }
            });            
            names.sort(function(a, b){
              if (isNaN(a) || isNaN(b)) {
                if (b > a) return -1;
                    else return 1;
              }
              return b - a;
            });
             $('.gotPer'+getgroupno).each(function() {
                 if($.inArray( parseFloat($(this).attr('playerplace')), names) === -1){
                     $(this).html('Tie');
                 }
                 else{
                     
                     $(this).html(getGetOrdinal((($.inArray( parseFloat($(this).attr('playerplace')), names ))+1)));
                 }                 
             });   
             var winnerPlaceDB= $('*[data-playeridplace="'+winner_id+'"]').text();
             var looserPlaceDB= $('*[data-playeridplace="'+looser_id+'"]').text();
            $.ajax({
                type:'POST',
                url: "saveResult.php",
                data:{
                    event_id  : <?php echo $_SESSION['event_id']; ?>,
                    group_id  : getgroupno,
                    winner_id : winner_id,
                    looser_id : looser_id,
                    winner_game_count : games,
                    looser_game_count : backway,
                    winner_Match_Record : winner_Match_Record,
                    winner_game_record : winner_game_record,
                    looser_Match_Record : looser_Match_Record,
                    looser_game_record : looser_game_record,
                    winnerPlaceDB : winnerPlaceDB,
                    looserPlaceDB : looserPlaceDB
                },
                dataType : "json",
                success:function(response){
                    if(response.error=='false'){
                       $('#myModal').modal('hide');  
                    }
                    else{
                        alert(response.message);
                    }
                    
                }
            });                      
         }
         else{
             var wcmb = getgroupno+'-'+getcolno+'-'+getrowno;
             var lcmb = getgroupno+'-'+getrowno+'-'+getcolno;
             $('*[data-combination="'+wcmb+'"]').text('W ' + games);
             var backway = games.split("").reverse().join("");
             $('*[data-combination="'+lcmb+'"]').text('L ' + backway);   
             var winner_id=colPlayerId;
             var looser_id=rowPlayerId;
             var winner_left_sum=0;
             var winner_right_sum=0;
             var looser_left_sum=0;
             var looser_right_sum=0;
             var winner_match_record_left=0;
             var winner_match_record_right=0;
             var looser_match_record_left=0;
             var looser_match_record_right=0;
             var names = [];
             $('*[data-tdplayerid="'+colPlayerId+'"]').each(function() {  
                 if($.trim($(this).html()).length > 0 || $.trim($(this).html()).length > '0'){
                     winner_left_sum += parseInt($.trim($(this).html()).substring(1,3));      
                     winner_right_sum += parseInt($.trim($(this).html()).substring(4));
                     if($.trim($(this).html()).substring(0,1)=='W'){
                         winner_match_record_left++;
                     }
                     else if ($.trim($(this).html()).substring(0,1)=='L'){
                         winner_match_record_right++;
                     }
                 }        
             });
             var winner_Match_Record = winner_match_record_left + '-' + winner_match_record_right;
             $('*[data-playeridmatchrecord="'+colPlayerId+'"]').html('').html(winner_Match_Record);
             
             var winner_game_record= winner_left_sum +'-'+  winner_right_sum;
             $('*[data-playeridgamerecord="'+colPlayerId+'"]').html('').html(winner_game_record);
             
             var winnerPercentage = ((parseInt(winner_match_record_left)*100)/parseInt(winner_match_record_left+winner_match_record_right)).toFixed();
             var winnerGameRecordPer = ((parseInt(winner_left_sum)*100)/parseInt(winner_left_sum+winner_right_sum)).toFixed();
             var winplayerPlace=winnerPercentage.toString()+winnerGameRecordPer.toString();
             $('*[data-playeridplace="'+colPlayerId+'"]').attr('playerplace',winplayerPlace);
             
             //======col player
             $('*[data-tdplayerid="'+rowPlayerId+'"]').each(function() {  
                 if($.trim($(this).html()).length > 0 || $.trim($(this).html()).length > '0'){
                     looser_left_sum += parseInt($.trim($(this).html()).substring(1,3));      
                     looser_right_sum += parseInt($.trim($(this).html()).substring(4));      
                     if($.trim($(this).html()).substring(0,1)=='W'){
                         looser_match_record_left++;
                     }
                     else if ($.trim($(this).html()).substring(0,1)=='L'){
                         looser_match_record_right++;
                     }
                 }        
             });
             
             var looser_Match_Record = looser_match_record_left + '-' + looser_match_record_right;
             $('*[data-playeridmatchrecord="'+rowPlayerId+'"]').html('').html(looser_Match_Record);
             
             var looser_game_record= looser_left_sum +'-'+  looser_right_sum;
             $('*[data-playeridgamerecord="'+rowPlayerId+'"]').html('').html(looser_game_record);
             
             var looserPercentage = ((parseInt(looser_match_record_left)*100)/parseInt(looser_match_record_left+looser_match_record_right)).toFixed();
             var looserGameRecordPer = ((parseInt(looser_left_sum)*100)/parseInt(looser_left_sum+looser_right_sum)).toFixed();
             var looserplayerPlace=looserPercentage.toString()+looserGameRecordPer.toString();
             $('*[data-playeridplace="'+rowPlayerId+'"]').attr('playerplace',looserplayerPlace);
             
             $('*[data-groupPlace="'+getgroupno+'"]').each(function() {
                if($(this).attr('playerplace') != 'Tie'){
                      names.push(parseFloat($(this).attr('playerplace')));
                      $(this).addClass('gotPer'+getgroupno);
                }
             });
             var i=0;  
             var tempA = [];
             names.sort(function(a, b){
              if (isNaN(a) || isNaN(b)) {
                if (b > a) return -1;
                    else return 1;
              }
              return b - a;
            });  
             $.each(names, function (key,value) {
              if($.inArray(value, tempA) === -1) {
                   tempA.push(value);
               }else{
                  var indx=names.indexOf(value);
                  //console.log(value+" is a duplicate value");
                  names[key]='Tie';
                  names[indx]='Tie';
               }
            });            
            names.sort(function(a, b){
              if (isNaN(a) || isNaN(b)) {
                if (b > a) return -1;
                    else return 1;
              }
              return b - a;
            });   
             $('.gotPer'+getgroupno).each(function() {
                if($.inArray( parseFloat($(this).attr('playerplace')), names) === -1){
                     $(this).html('Tie');
                 }
                 else{
                     $(this).html(getGetOrdinal((($.inArray( parseFloat($(this).attr('playerplace')), names ))+1)));
                 } 
             });  
             var winnerPlaceDB= $('*[data-playeridplace="'+winner_id+'"]').text();
             var looserPlaceDB= $('*[data-playeridplace="'+looser_id+'"]').text();
             $.ajax({
                type:'POST',
                url: "saveResult.php",
                data:{
                    event_id  : <?php echo $_SESSION['event_id']; ?>,
                    group_id  : getgroupno,
                    winner_id : winner_id,
                    looser_id : looser_id,
                    winner_game_count : games,
                    looser_game_count : backway,
                    winner_Match_Record : winner_Match_Record,
                    winner_game_record : winner_game_record,
                    looser_Match_Record : looser_Match_Record,
                    looser_game_record : looser_game_record,
                    winnerPlaceDB : winnerPlaceDB,
                    looserPlaceDB : looserPlaceDB
                },
                dataType : "json",
                success:function(response){
                    if(response.error=='false'){
                       $('#myModal').modal('hide');  
                    }
                    else{
                        alert(response.message);
                    }                    
                }
            });
         }  
         return true;
    }
    
    $(document).on('click','#submitResult', function(){
        var finalHtml = [];
        $('.tab-content').children().each(function(){
          finalHtml.push($(this).html());
        });
        $.ajax({
                type:'POST',
                url: "saveandsend.php",
                data:{
                    finalHtml  : finalHtml,
                },
                success:function(response){
                    
                }
            });
    });   
    
    $('#gamePlayForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                games: {
                    message: 'The Games Field entered is not valid.',
                    validators: {
                        notEmpty: {
                            message: 'The Games Field is required and can\'t be empty.'
                        },
                        regexp: {
                            regexp: /\b^[0-9]{1,2}[-][0-9]{1,2}$\b/,
                            message: 'Please Enter Valid Games score'
                        },
                        callback :{
                            callback: function (value, validator, $field) {
                                var firstSub=value.split('-')[0];
                                var lastSub= value.split('-')[1];
                                if(parseInt(firstSub) < parseInt(lastSub)){
                                    return {
                                        valid: false,    
                                        message: 'Winner Games Scores Must be Greater'
                                    }
                                }
                                else{
                                    return {
                                        valid: true,    
                                        message: 'Correct Score Entered'
                                    }
                                }                                
                            }
                        }
                    }
                }/*,
                wr :{
                    validators: {
                        notEmpty: {
                            message: 'Please select Winnner'
                        }
                    }                    
                } */
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            saveToTable();
            $(e.target).bootstrapValidator('resetForm', true);
        });
</script>