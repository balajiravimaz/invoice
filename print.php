<?php
session_start();
require_once "vendor/autoload.php";


use Dompdf\Dompdf;

if (isset($_SESSION['email'])) {
    if (isset($_GET['id'])) {
        require_once "class/Database.php";

        $db = new Database();

        $email = $_SESSION['email'];

        $db->query("select id from users where email =  '$email' ");
        $user = $db->resultset();
        $user_id = $user[0]['id'];

        $inv_id = $_GET['id'];

        $dompdf = new Dompdf();


        $db->query("SELECT * FROM `address` join billing on address.invoice_id = billing.invoice_id join total on billing.invoice_id = total.invoice_id join notes on total.invoice_id = notes.invoice_id where address.invoice_id = :invId ;");
        $db->bind(":invId",$inv_id);
        $address = $db->resultset();


        $db->query("SELECT * from items where invoice_id = :invId ");
        $db->bind(":invId", $inv_id);
        $items = $db->resultset();

        $html = '
    <style>
    p{
        color:#454545;
        font-size: 15px;
        margin:0;
        padding:0;        
    }
    h1,h2,h3,h4{
        margin:0;
        padding:0;
    }
    h4{
        margin-bottom: 1px;
    }
    .border{
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }
    table{
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        // border: 1px solid;
      }
      .inlne,
      .p{
        display: inline-block;
        float:left;       
        margin-bottom: 5px;         
      }      
      .p{
        text-align: left;
        padding-left: 10px;
      }
      .inlne{
        font-weight: bolder;
        width: 400px;
        clear: left;
        text-align: right;
      }
      table, th{
        color: #fff;
      }
      .bg-secondary{
        background: #6c757d!important;        
      }
      h1,h4{
        color: #232323;
      }
      .items{
        border-collapse: collapse;
      }      
      h5{
        font-size: 16px;
      }
      .items td{
        padding: 10px;
        border: 1px solid #ddd;
      }
      b{
        color: #000;
      }
    </style>

        <table>
        <tr>
        <td><h4>' . $address[0]['name'] . '</h4></td>
        <td align="right"><h1>' . $address[0]['title'] . '</h1></td>                
        </tr>        
        <tr>
        <td><p>' . $address[0]['c_address'] . '</p></td>
        <td></td>
        </tr>
        <tr>
        <td><p>' . $address[0]['city'] . '</p></td>
        <td></td>
        </tr>
        <tr>
        <td><p>' . $address[0]['country'] . '</p></td>
        <td></td>
        </tr>
        </table>

        <div class="border"></div>
        <br>
        <h4><b>Billing To: </b></h4>
        <table style="margin-top:20px;">
        <tr>
        <td><h4>' . $address[0]['b_name'] . '</h4></td>
        <td align="right"><p class="inlne">Invoice:</p> <p class="p">' . $address[0]['invoice_id'] . '</p></td>
        </tr>
        <tr>
        <td><p>' . $address[0]['b_address'] . '</p></td>
        <td align="right"><p class="inlne">Invoice Date:</p> <p class="p">' . $address[0]['invoice_date'] . '</p></td>
        </tr>
        <tr>
        <td><p>' . $address[0]['b_city'] . '</p></td>
        <td align="right"><p class="inlne">Due Date:</p> <p class="p">' . $address[0]['due_date'] . '</p></td>
        </tr>
        <tr>
        <td><p>' . $address[0]['b_country'] . '</p></td>        
        </tr>
        </table>
        <br>
        <table class="items">
        <thead class="bg-secondary">
        <tr>
        <th>Item Description</th>        
        <th>Quanitity</th>
        <th>Amount</th>
        <th>Rate</th>
        </tr>
        </thead>
        <tbody>';

        foreach ($items as $data) {
            $html .= '
            <tr style="border-bottom: 1px solid #ddd;">
            <td align="center">
            <p>' . $data['item'] . '</p>
            </td>
            <td align="center">
                <p>' . $data['qty'] . '</p>
            </td>
            <td align="center">
                <p>' . $data['amount'] . '</p>
            </td>
            <td align="right">
                <p>' . $data['rate'] . '</p>
            </td>
            </tr>  
            ';
        }

        $html .= '
        <tr>
        <td align="right" colspan="3">
            <b style="color:#000;">Sub Total</b>
        </td>
        <td align="right">
            <p><b>' . $address[0]['sub_total'] . '.00</b></p>
        </td>
    </tr>
    <tr>
        <td align="right" colspan="3">
            <div class="d-flex justify-content-end">
                <b style="color:#000";>CGST(%) + IGST(%) : </b>
                <span style="color:#000;"><b>' . $address[0]['gst'] . '</b></span>
            </div>
        </td>
        <td align="right">            
            <p><b>' . $address[0]['gst_amount'] . '.00</b></p>
        </td>
    </tr>
    <tr class="total">
        <td colspan="3" align="right">
            <p><b>Total</b></p>
        </td>
        <td align="right" style="background: #efefef;">
            <p><b>' . $address[0]['total'] . '.00</b></p>
        </td>
    </tr>
        </tbody>
        </table>
        <br>
        <h5 style="margin-bottom: 0px;"><b>Notes:</b></h5>
        <p style="margin-bottom: 15px;">'.$address[0]['notes'].'</p>        
        <h5 style="margin-bottom: 15px;"><b>Terms and Conditions</b></h5>    
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,</p>    
        <br>
        <p><b>Please make the payment by the due date.</b></p>
        ';

        $dompdf->loadHtml($html);



        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("test.pdf", array("Attachment" => 0));
    }
}
