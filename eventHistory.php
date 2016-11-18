<?php
    session_start();
    error_reporting(0);
    include './includes/dbconfig.php';
    include './checkSetting.php';  
    if($con){
        $result = mysqli_query($con,"SHOW TABLES");
        $tableList=array();
        while($cRow = mysqli_fetch_array($result))
        {
            $tableList[] = $cRow[0];
        }
        if(in_array('users',$tableList) && in_array('directoremails',$tableList) && in_array('event',$tableList) && in_array('records',$tableList) && in_array('result_tt',$tableList)){
            $test=checkEmailSetting();
            if($test=='false'){
                echo "<script>window.location.href ='settings.php';</script>";
                die();
            }
        }
        else{
            echo "<script>window.location.href ='install.php';</script>";
            die();
        }       
    }
    else{
        echo "<h1>Please update Database configuration</h1>";
        exit;
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
    <div id="overlay" style=" background: #f6f6f6;opacity: 0.7;width: 100%;float: left;height: 100%;position: fixed;top: 0;z-index: 1031;text-align: center; display: none">
                <img src="images/loading_tt.gif"  style=" position: relative;top: 20%;"/>
                <div><h2>Loading...</h2></div>
    </div>
    <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="index.php"><img class="center-block" src="images/logo.png"></a>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-left">
                                <li>
                                   <a href="index.php"  style="cursor: pointer">Back</a>
                                </li>
                            </ul>
                        </div><!-- /.navbar-collapse --> 
                    </div>
                </div>
            </div> 
        </nav>          
    <div class="clearfix" style="margin-top: 60px"></div>
    <div class="container">
        <div class="row">
            <form class="form-inline" role="form" id="historyForm" method="post" action="getHistory.php" >
                <div class="form-group">
                  <label for="eventDate">Event Date</label>
                  <input type="text" class="form-control" name="edate"  id="datetimePicker"/>
                </div>                
                <button type="submit" class="btn btn-primary" id="ajxButton">Show</button>
            </form>
        </div>
    </div>
    <div class="clearfix" style="margin-top: 60px"></div>
    <div id="ajaxContainer">
        
    </div>
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrapvalidator-master/dist/js/bootstrapValidator.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/daterangepicker.js"></script>
</body>
</html>
<script type="text/javascript">
$(function() {
    $('#datetimePicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    });    
});

$('#historyForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            edate: {
                    validators: {
                        notEmpty: {
                            message: 'Event Date is required and cannot be empty.'
                        }
                   }
            }
        }
    })
    .on('success.form.bv', function(e) {
        e.preventDefault();
        var $form = $(e.target);
        var bv = $form.data('bootstrapValidator');
        $.post($form.attr('action'), $form.serialize(), function(result) {
            $('#ajaxContainer').html('').html(result);
             $form.bootstrapValidator('disableSubmitButtons', false); 
        });
    });
    
    $(document).on('click','#submitResult', function(){
        var finalHtml = [];
        $('.tab-content').children().each(function(){
          finalHtml.push($(this).html());
        });
        $.ajax({
                type:'POST',
                url: "sendHistory.php",
                data:{
                    finalHtml  : finalHtml,
                    edate      : $('#datetimePicker').val()
                },
                beforeSend: function(){
                    $('#overlay').show();
                },
                complete: function(){
                    $('#overlay').hide();
                },
                dataType : "json",
                success:function(response){
                    if(response.error==='false'){
                        $('#myModal')
                                .find('.modal-title').html('').html('Success').end()
                                .find('.modal-body').html('').html(response.message).end()
                                .modal('show'); 
                    }
                    else{
                        alert(response.message);
                        $('#myModal')
                                .find('.modal-title').html('').html('Something went wrong').end()
                                .find('.modal-body').html('').html(response.message).end()
                                .modal('show'); 
                    }
                }
            });
    });  
</script>


