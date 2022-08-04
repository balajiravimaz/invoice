<?php 
require_once "class/Database.php";

$db = new Database;
// require_once "vendor/autoload.php";

// use Dompdf\Dompdf;


// $dompdf = new Dompdf();

// $html = "
// <h1>Hello world</h1>
// ";

// $dompdf->loadHtml($html); 
 
// $dompdf->setPaper('A4', 'portrait'); 
 
// $dompdf->render(); 

// $dompdf->stream("test.pdf", array("Attachment" => 0));


$gst = "10";
$gst_amt = "7500";
$sub_total = "8500";
$total = "25000";
$id ="500004";


$db->query("update total set gst=:Gst, gst_amount=:Amount, sub_total=:Sub, total=:Total where invoice_id = :id");

$db->bind(":Gst", $gst);
$db->bind(":Amount", $gst_amt);
$db->bind(":Sub", $sub_total);
$db->bind(":Total", $total);
$db->bind(":id", $id);

$db->execute();
