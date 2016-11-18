<?php
session_start();
require './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
include './includes/dbconfig.php';

$date = date("Y-m-d", strtotime($_POST['edate']));
$finalHtml = $_POST['finalHtml'];

$attachArray = find_all_files("result/".$date);
    $query="SELECT `emails` FROM `directoremails`";
    $result= mysqli_query($con,$query);
    $count=  mysqli_num_rows($result);
    if($count > 0){
        $emails=mysqli_fetch_row($result);
        $emailArray= explode(',', $emails[0]);
    }
    else
    {
        $emailArray= FALSE;
    }
    
    
    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->CharSet = 'UTF-8';    

    $mail->setFrom('noreply@kansascitytabletennis.com', 'No Reply');
    if(!empty($emailArray)){
       foreach($emailArray as $value){
            $mail->addAddress($value);     // Add a recipient
        } 
    }
    
    foreach($attachArray as $image){
        $mail->addAttachment($image);         // Add attachments
    }

    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'League Results';
    $mail->Body    = 'Final Result';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail';

    if(!$mail->send()) {
        echo json_encode(array('error'=>'true','message'=>$mail->ErrorInfo));
    } else {
        echo json_encode(array('error'=>'false','message'=>'Email sent successfully to League Directors'));
    }
    

function find_all_files($dir) 
    { 
        $root = scandir($dir); 
        foreach($root as $value) 
        { 
            if($value === '.' || $value === '..') {continue;} 
            if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;} 
            foreach(find_all_files("$dir/$value") as $value) 
            { 
                $result[]=$value; 
            } 
        } 
        return $result; 
    }
?>