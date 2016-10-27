<?php

    require './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    include './includes/dbconfig.php';
    require_once './vendor/dompdf/dompdf/autoload.inc.php';           
    use Dompdf\Dompdf;
    $date=date('Y-m-d');
    $finalHtml=$_POST['finalHtml'];    
    $i=1;
    $css='<style>
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
    
   $header='<div class="absolute" style="top: 40px; left: 150px;">
                <img src="images/logo.png"/>
            </div>
            <div class="absolute" style="top: 80px; right: 100px;">
                Event Date : '.$date.'
            </div>
            <div class="absolute" style="top: 50px; left: 40px; right: 40px;">
                <h1>www.kansascitytabletennis.com</h1>
            </div><br/><br/><br/><br/><br/><br/><br/><br/><br/>'; 
   foreach ($finalHtml as $value) {
        $dompdf = new DOMPDF();
        $dompdf->load_html($css.$header.'<div class="absolute" style="top: 160px; left: 160px; right: 160px; bottom: 160px; ">'.$value.'</div>');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("result/".$date."/".$i.".pdf", $output);
        $i++;
    }
    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.zoho.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'tejasm@itpathsolutions.co.in';                 // SMTP username
    $mail->Password = 'ips12345';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('tejasm@itpathsolutions.co.in', 'TJ');
    $mail->addAddress('khushbus@itpathsolutions.co.in','Khushbu');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('tejasm@itpathsolutions.co.in', 'Reply name');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
//
//    foreach($attachArray as $image){
//                    $mail->addAttachment("taskPhotos/".$image);         // Add attachments
//    }
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Event';
    $mail->Body    = 'this is message';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail';

    if(!$mail->send()) {

            return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
            return 'Message has been sent';
    }
?>