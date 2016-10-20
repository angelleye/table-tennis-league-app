<?php
session_start();
include './includes/dbconfig.php';
if($con){
        $result = mysqli_query($con,"SHOW TABLES");
        $tableList=array();
        while($cRow = mysqli_fetch_array($result))
        {
            $tableList[] = $cRow[0];
        }
        if(in_array('users',$tableList) && in_array('list_for_the_day',$tableList)){
           echo "<script>window.location.href ='index.php';</script>";
           exit;
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
        <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container col-lg-offset-5 col-md-offset-5 col-sm-offset-5 col-xs-offset-4">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand myLogo" href="#"><img src="images/logo.png"></a>
            </div>
        </div>
    </nav>    
<div class="clearfix" style="margin-top: 60px"></div>        
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-lg-offset-4 col-md-3 col-md-offset-4 col-sm-4 col-sm-offset-4">
                <div id="errmsg"></div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Ready to install the app?</h3>
                    </div>
                    <div class="panel-body text-center">
                        <button class="btn btn-success btn-lg" type="button" id="goButton">GO</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>  
    
    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<script>
$(document).on('click','#goButton',function (){
    $(this).prop('disabled',true);
    $.ajax({
        url: "setTables.php",
        success:function(response){
            var response=JSON.parse(response);
            if(response.error == 'false'){
                <?php $_SESSION['success']='1'; ?>
                window.location.href='index.php';
            }
            else{
                $('#errmsg').html('<div class="alert alert-danger" role="alert"><strong>Something went wrong</strong></div>');
            }
        }
    });
});
</script>    