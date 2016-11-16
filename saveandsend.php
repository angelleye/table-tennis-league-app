<?php
session_start();
require './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
include './includes/dbconfig.php';
require_once './vendor/dompdf/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$date = $_POST['event_date'];
$finalHtml = $_POST['finalHtml'];
$event_id  = $_POST['event_id'];
$i = 1;
$css = '<style>
        div.absolute {
	position: absolute;
	padding: 0.5em;
	text-align: center;
	vertical-align: middle;
       }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border-bottom-width: 2px;
    }
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #ddd;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
    }
</style>';

$header = '<div class="absolute" style="top: 40px; left: 150px;">
                <img src="images/logo.png"/>
            </div>
            <div class="absolute" style="top: 80px; right: 100px;">
                Event Date : ' . $date . '
            </div>
            <div class="absolute" style="top: 50px; left: 40px; right: 40px;">
                <h1>www.kansascitytabletennis.com</h1>
            </div><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
foreach ($finalHtml as $value) {
    $dompdf = new DOMPDF();
    $dompdf->load_html($css . $header . '<div class="absolute" style="top: 160px; left: 160px; right: 160px; bottom: 160px; ">' . $value . '</div>');
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $output = $dompdf->output();
    if (!file_exists("result/" . $date)) {
        mkdir("result/" . $date, 0777, true);
    }
    file_put_contents("result/".$date."/Group".$i."-".$event_id.".pdf", $output);
    $i++;
}
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
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'testfirstlastname009@gmail.com';                 // SMTP username
    $mail->Password = 'itpath@009';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('testfirstlastname009@gmail.com', 'TJ');
    if(!empty($emailArray)){
       foreach($emailArray as $value){
            $mail->addAddress($value);     // Add a recipient
        } 
    }
    $mail->addReplyTo('tejasm@itpathsolutions.co.in', 'Reply name');
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
        echo json_encode(array('error'=>'false','message'=>'Success'));
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