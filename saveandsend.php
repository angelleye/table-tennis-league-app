<?php
session_start();
include './includes/dbconfig.php';
require_once './vendor/dompdf/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$date = date('Y-m-d');
$finalHtml = $_POST['finalHtml'];
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
    file_put_contents("result/" . $date . "/Group" . $i . "-".$_SESSION['event_id'].".pdf", $output);
    $i++;
}


?>