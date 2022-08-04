<?php 
require_once "vendor/autoload.php";

use Dompdf\Dompdf;


$dompdf = new Dompdf();

$html = "
<h1>Hello world</h1>
";

$dompdf->loadHtml($html); 
 
$dompdf->setPaper('A4', 'portrait'); 
 
$dompdf->render(); 

$dompdf->stream("test.pdf", array("Attachment" => 0));