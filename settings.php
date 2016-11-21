<?php
session_start();
error_reporting(0);
include './includes/dbconfig.php';
if ($con) {
    $result = mysqli_query($con, "SHOW TABLES");
    $tableList = array();
    while ($cRow = mysqli_fetch_array($result)) {
        $tableList[] = $cRow[0];
    }
    if (in_array('users', $tableList) && in_array('settings', $tableList) && in_array('event', $tableList) && in_array('records', $tableList) && in_array('result_tt', $tableList)) {
        
    } else {
        echo "<script>window.location.href ='install.php';</script>";
        die();
    }
} else {
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
        <title>Setting | KCTT League App</title>
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
                                    <a href="index.php" id='HomePage' style="cursor: pointer;display: none">Home</a>
                                </li>
                            </ul>
                        </div><!-- /.navbar-collapse --> 
                    </div>
                </div>    
            </div> 
        </nav>   
        <div class="clearfix" style="margin-top: 60px"></div>
        <div class="container" id="importDiv">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success" role="alert" id="alrt_success"><strong>Install completed successfully!  Ready for CSV import</strong></div>';
                        unset($_SESSION['success']);
                    }
                    ?>
                    <div class="panel panel-info">
                        <div class="panel-heading"><strong>League Director Email(s)</strong></div>
                        <div class="panel-body">
                            <?php
                            $query = "SELECT `emails`,`roster_urls` FROM `settings`";
                            $result = mysqli_query($con, $query);
                            $count = mysqli_num_rows($result);
                            if ($count > 0) {
                                $emails = mysqli_fetch_row($result);
                                $style = '';
                            } else {
                                $style = 'style="display: none"';
                            }
                            ?>
                            <form role="form" id="settingForm" method="post" action="addEmails.php">
                                <div id="messageAlert"></div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Enter Comma Separated Email(s) Here</label>
                                        <textarea class="form-control" id="demails" rows="3" name="emails" placeholder="For example : abc@email.com,Xyz@host.in"><?php echo $emails[0]; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Roster File URL</label>
                                        <input type="text" name="rosterUrl" class="form-control" id="rosterUrl" value="<?php echo $emails[1]; ?>"/>    
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info" id="saveEmail">Save</button>
                                        <a href="index.php" class="btn btn-success" id="HomePagebtn" <?php echo $style; ?>>Home Page</a>
                                    </div>
                                </div>
                            </form>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrapvalidator-master/dist/js/bootstrapValidator.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/jquery.ui.touch-punch.min.js"></script>
        <script src="js/moment.min.js"></script>
        <script src="js/daterangepicker.js"></script>
    </body>
</html>

<script>
    $('#settingForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            emails: {
                message: 'Please Provide Valid Input',
                validators: {
                    notEmpty: {
                        message: 'This Field is required and can\'t be empty.'
                    },
                    regexp: {
                        regexp: /^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$/,
                        message: 'Please Provide Valid Input'
                    }
                }
            },
            rosterUrl: {
                message: 'Please Provide Valid Input',
                validators: {
                    uri: {
                        allowLocal: true,
                        message: 'Please Provide Valid Input'
                    }
                }
            }
        }
    })
            .on('success.form.bv', function (e) {
                // Prevent form submission
                e.preventDefault();
                // Get the form instance
                var $form = $(e.target);
                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');
                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function (result) {
                    if (result.error == "false") {
                        $('#messageAlert').html('<div class="alert alert-warning" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>' + result.message + '.</strong></div>');
                        $form.bootstrapValidator('resetForm', true);
                        $('#HomePage').show();
                        $('#HomePagebtn').show();
                        $('textarea#demails').val(result.data);
                        $('#rosterUrl').val(result.urlData);
                    } else {
                        $('#messageAlert').html('<div class="alert alert-danger" role="alert"> <strong>Something Went Wrong</strong></div>');
                        $form.bootstrapValidator('resetForm', true);
                    }
                }, 'json');
            });
    setTimeout(function () {
        $("#alrt_success").hide('blind', {}, 500)
    }, 5000);
</script>