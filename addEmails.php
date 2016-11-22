<?php
    session_start();
    include './includes/dbconfig.php';
    $flag=FALSE;
    $string = rtrim($_POST['emails'], ',');
    if(trim($_POST['rosterUrl'])==''){
        $insertSubstr="INSERT INTO `settings`(`emails`) VALUES ('$string')";
    }
    else{;
        $insertSubstr="INSERT INTO `settings`(`emails`,`roster_urls`) VALUES ('$string','{$_POST['rosterUrl']}')";
    }
    $query="SELECT * FROM `settings`";
    $result= mysqli_query($con,$query);
    $count=  mysqli_num_rows($result);
    if($count > 0){
        $queryRecords="UPDATE `settings` SET `emails`='$string'  , `roster_urls` = '{$_POST['rosterUrl']}' WHERE  `id`='1'";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    else {
        $queryRecords=$insertSubstr;
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    if($flag==TRUE){
        echo json_encode(array('error'=>'false','message'=>'Settings saved Successfully','data'=>$string,'urlData'=>$_POST['rosterUrl']));
    }
    else {
         echo json_encode(array('error'=>'true','message'=>'something went wrong'));
    }
?>