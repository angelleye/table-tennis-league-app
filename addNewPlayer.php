<?php

include './includes/dbconfig.php';
$firstname = !empty($_POST['firstname']) ? $_POST['firstname'] : '';
$lastname  = !empty($_POST['lastname']) ? $_POST['lastname'] : '';
$mname     = !empty($_POST['mname']) ? $_POST['mname'] : '';
$bdate     = !empty($_POST['bdate']) ? $_POST['bdate'] : '';
$sex       = !empty($_POST['emodel']) ? $_POST['emodel'] : '';
$rating    = !empty($_POST['rating']) ? $_POST['rating'] : '';
$email     = !empty($_POST['email']) ? $_POST['email'] : '';
$usatt     = !empty($_POST['usatt']) ? $_POST['usatt'] : '';

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

