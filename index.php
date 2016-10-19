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
        <div class="container col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-3">
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
                        <a id="viewListButton"  style="cursor: pointer">View List</a>
                    </li>
                    <li>
                        <a id="addNewPlayerLink"  style="cursor: pointer">Add New User</a>
                    </li>
                    <li>
                        <a id="refreshMe"  style="cursor: pointer">Start Over</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="clearfix" style="margin-top: 60px"></div>
    <!-- Page Content -->
    <div class="container" id="importDiv">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h1>Import Players</h1>
                <div id="errorFlag"></div>
                <form name="importForm" id="importForm" enctype="multipart/form-data"> 
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputFile">Select File *</label>
                        <input type="file" id="importInputFile" name="importInputFile" />
                        <p class="help-block">.csv</p>
                    </div>
                    <div class="progress progress-sm active">
                        <div style="width:0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-primary" id="ajaxImportUpload" type="submit">Submit</button>
                        <button class="btn btn-primary" id="viewListButton" type="button" style="display: none">View List</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    <div class="clearfix" style="margin-top: 60px"></div>
    <div class="container" id="dualListDiv" style="display: none">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-check"></i>All Players</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="searchLeft" id="searchLeft" placeholder="Search by MemberId or Name or Email" />  
                    </div>
                  <ul class="source connected">                      
                  </ul>
                </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-check"></i>Today's Players</h4>
                </div>
                <div class="panel-body">
                    <div class="right">
                  <ul class="target connected">
                  </ul>
                </div>
                </div>
            </div>
          </div>              
        </div>
        <div class="row"><div class="col-lg-9"><button type="button" class="btn btn-primary pull-right btn-lg" id="processButton">Process Selected</button></div></div>
        <br>
    </div>
    
    <div class="container" id="finalListDiv" style="display: none">
        <div class="row" id="finalListrow">

        </div>
    </div>   
    
    <div class="container" id="addNewPlayerContainer" style="display: none">
        <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading"><strong>Add New Player</strong></div>
                 <div class="panel-body">
                     <form role="form" id="addUserForm" method="post" action="addNewPlayer.php">
                          <div id="messageAlert"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" name="firstname" id="firstname" type="text" autocomplete="off"/>
                            </div>
                        
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" name="lastname" id="lastname" type="text" autocomplete="off"/>
                            </div>                        
                            
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input class="form-control" name="mname" id="mname" type="text" autocomplete="off"/>
                            </div>     
                            
                            <div class="form-group">
                             <label>Birth Date</label>
                                <input type="text" class="form-control" name="bdate"  id="datetimePicker"/>
                            </div>
                            
                            <div class="form-group">
                                <label>Sex</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="emodel" id="M" value="M">Male
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="emodel" id="F" value="F">Female
                                    </label>
                                </div>
                            </div>  
                            
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email"  id="email" type="text" autocomplete="off"/>
                            </div>  
                            
                            <div class="form-group">
                                <label>League Rating</label>
                                <input class="form-control" name="rating"  id="rating" type="text" autocomplete="off"/>
                            </div>  
                            
                            <div class="form-group">
                             <label>Last Played</label>
                                <input type="text" class="form-control" name="last_played"  id="last_played"/>
                            </div>
                            
                            <div class="form-group">
                                <label>USATT Member ID</label>
                                <input class="form-control" name="usatt"  id="usatt" type="text" autocomplete="off"/>
                            </div>
                            
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <button type="reset" class="btn btn-default" id="resetForm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->
    </div>   
    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrapvalidator-master/dist/js/bootstrapValidator.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/daterangepicker.js"></script>
</body>
</html>
<script>
 
$('#addNewPlayerLink').click(function (){
    //$('#finalListrow').hide('slow').fadeOut('3000');
    $('#importDiv').hide('slow').fadeOut('3000');
    $('#dualListDiv').hide('slow').fadeOut('3000');
    $('#addNewPlayerContainer').show('slow').fadeIn('3000');
});
    
$('#importForm').submit(function(e) {
    var formData = new FormData(this);
    $.ajax({
        type:'POST',
        url: "insertPlayers.php",
        data:formData,
        beforeSend: function(){
            $('#ajaxImportUpload').prop("disabled", true);            
        },
        xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress, false);
                }
                return myXhr;
        },
        cache:false,
        contentType: false,
        processData: false,
        dataType : "json",
        success:function(response){
                if(response.error=='true'){
                     $('#importForm')[0].reset();
                     $('#progress-bar').css('width','0%');
                     $('#ajaxImportUpload').prop("disabled", false);
                     $('#errorFlag').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error! '+response.msg+'</strong></div>');
                }
                else if(response.error=='false'){
                    $('#errorFlag').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success! '+response.msg+'</strong></div>');
                    $('#viewListButton').show().fadeIn("slow");
                }
            }
    });
    e.preventDefault();
});

$('#viewListButton').click(function (){
    //$(this).hide();
    $.ajax({
        type:'POST',
        url: "getPlayers.php",
        success:function(response){
            $("ul.source").html(response);
        }
    });
    $('#importDiv').hide('slow').fadeOut('3000');
    //$('#finalListrow').hide('slow').fadeOut('3000');
    $('#addNewPlayerContainer').hide('slow').fadeOut('3000');
    $('#dualListDiv').show('slow').fadeIn('3000');
});

$('#processButton').click(function (){
    //get target list
    var items = [];
    $("ul.target").children().each(function() {
        var item = $(this).attr('data-id');
        items.push(item);
    });
    var jsonData = JSON.stringify(items);
    $.ajax({
        type:'POST',
        url: "selectedPlayers.php",
        data: {
            user_id : jsonData
        },
        success:function(response){
            $('#dualListDiv').hide('slow').fadeOut('3000');
            $('#finalListDiv').show('slow').fadeIn('3000');
            $('#finalListrow').html(response);
            $( ".sortable_list" ).sortable({
                connectWith: ".connectedSortable",
                placeholder: "placeholder",
                start: function (event, ui) {
                    ui.item.toggleClass("placeholder");
                },
                stop: function (event, ui) {
                    ui.item.toggleClass("placeholder");
                }
            }).disableSelection(); 
        }
    });
});


function progress(e){

    if(e.lengthComputable){
        var max = e.total;
        var current = e.loaded;
        var Percentage = (current * 100)/max;
        $('#progress-bar').css('width',Percentage+'%');
        $('.sr-only').html(Percentage+'%');
        if(Percentage >= 100)
        {
           // process completed  
        }
    }  
 }
 
  $('#searchLeft').keyup(function(){        
        var searchText = $(this).val().toLowerCase();        
        $('.source > li').each(function(){            
            var currentLiText = $(this).text().toLowerCase(),
                showCurrentLi = currentLiText.indexOf(searchText) !== -1;            
            $(this).toggle(showCurrentLi);            
        });     
    });
    
</script>
<script type="text/javascript">
  $(function () {
    $(".source, .target").sortable({
      connectWith: ".connected",
       placeholder: "placeholder",
        start: function (event, ui) {
                ui.item.toggleClass("placeholder");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("placeholder");
        }
    }).disableSelection().on('click', '.click_area', function(){
            $(this).appendTo($(".source, .target").not($(this).closest("ul")));
    });    
  });
</script>
<script type="text/javascript">
$(function() {
$( ".sortable_list" ).sortable({
    connectWith: ".connectedSortable",
    /*stop: function(event, ui) {
        var item_sortable_list_id = $(this).attr('id');
        console.log(ui);
        //alert($(ui.sender).attr('id'))
    },*/
    receive: function(event, ui) {
        alert("dropped on = "+this.id); // Where the item is dropped
          alert("sender = "+ui.sender[0].id); // Where it came from
          alert("item = "+ui.item[0].innerHTML); //Which item (or ui.item[0].id)
    }         
}).disableSelection();   
});

$(function() {
    $('#datetimePicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    });
    $('#expiration').daterangepicker({
        singleDatePicker: true
    });
    $('#last_played').daterangepicker({
        singleDatePicker: true
    });
});

$('#resetForm').click(function(){
    var $form = $('#addUserForm');
    $form.bootstrapValidator('resetForm', true);
});
    
    $('#addUserForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                firstname: {
                    message: 'The Firstname is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The firstname is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 2,
                            max: 30,
                            message: 'The Firstname must be more than 2 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z]+$/,
                            message: 'The Firstname can only consist of alphabetical'
                        }
                    }
                },
                lastname: {
                    validators: {
                        notEmpty: {
                            message: 'The Lastname is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 2,
                            max: 30,
                            message: 'The Lastname must be more than 2 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z]+$/,
                            message: 'The Lastname can only consist of alphabetical'
                        }
                    }
                },
                bdate: {
                    validators: {
                        notEmpty: {
                            message: 'The date is required and cannot be empty'
                        }
                    }
                },
                emodel:{
                    validators: {
                        notEmpty: {
                            message: 'This field is required and can\'t be empty'
                        }
                    }
                },
                usatt:{
                     validators: {
                        notEmpty: {
                            message: 'This field is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 1,
                            max: 30,
                            message: 'The MemberId must be more than 1 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'The MemberId can only consist of number'
                        }   
                     }
                },
                email:{
                    validators:{
                        notEmpty :{
                            message: 'This field is required and can\'t be empty'
                        },
                        emailAddress : {
                            message: 'Please Enter Valid email ID'
                        }
                    }
                },
                rating :{
                    validators:{
                        notEmpty :{
                            message: 'This field is required and can\'t be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'The rating can only consist of number'
                        }  
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
           e.preventDefault();
            // Get the form instance
            var $form = $(e.target);
           // Get the BootstrapValidator instance
           var bv = $form.data('bootstrapValidator');
            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                 if(result.error=="false"){
                     $('#messageAlert').html('<div class="alert alert-success" role="alert"><strong>'+result.msg+'.</strong></div>');
                     $form.bootstrapValidator('resetForm', true);
                 }
                 else{
                    $('#messageAlert').html('<div class="alert alert-danger" role="alert"> <strong>Something Went Wrong</strong></div>'); 
                     $form.bootstrapValidator('resetForm', true);
                 }
            }, 'json');
        });
        
        $('#refreshMe').click(function (){
            location.reload();
        });
</script>
