<?php

include './includes/dbconfig.php';
$firstname = $_POST['firstname'];
$lastname  = $_POST['lastname'];
$mname     = $_POST['mname'];
$bdate     = $_POST['bdate'];
$sex       = $_POST['emodel'];
$rating    = $_POST['rating'];
$expiration= $_POST['expiration'];
$email     = $_POST['email'];
$usatt     = $_POST['usatt'];

$query = mysqli_query($con, 'INSERT INTO users (member_id, fname,lname,mname,sex,rating,expiration,last_played,email) 
               VALUES ("' . $usatt . '","' . $firstname . '","' . $lastname . '","'.$mname.'","'.$sex.'","'.$rating.'","'.$expiration.'","'.$last_played.'","'.$email.'")');

if($query){
    echo json_encode(array('error' => 'false', 'msg' => 'New Player Added Successfully'));
    die();
}
else{
    echo json_encode(array('error' => 'true', 'msg' => 'Doh! Something went wrong.'));
    die();
}
?>

