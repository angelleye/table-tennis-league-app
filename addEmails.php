<?php
    session_start();
    include './includes/dbconfig.php';
    $flag=FALSE;
    $string = rtrim($_POST['emails'], ',');
    $query="SELECT * FROM `directoremails`";
    $result= mysqli_query($con,$query);
    $count=  mysqli_num_rows($result);
    if($count > 0){
        $queryRecords="UPDATE `directoremails` SET `emails`='$string' WHERE  `id`='1'";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    else {
        $queryRecords="INSERT INTO `directoremails`(`emails`) VALUES ('$string')";
        $q = mysqli_query($con, $queryRecords);
        if($q){ $flag=TRUE; } else { $flag=FALSE; }
    }
    if($flag==TRUE){
        echo json_encode(array('error'=>'false','message'=>'League Director Email(s) Set Successfully','data'=>$string));
    }
    else {
         echo json_encode(array('error'=>'true','message'=>'something went wrong'));
    }
?>