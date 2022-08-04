<?php
session_start();
require_once "class/Database.php";


if (isset($_SESSION['email'])) {
if (isset($_POST['save'])) {

    $db = new Database();


    $status = "";
    $email = $_SESSION['email'];

    $db->query("select id from users where email =  '$email' ");
    $user = $db->resultset();
    $user_id = $user[0]['id'];

    $db->query("select inv_id from inv_autogen where id = 1");
    $inv_user = $db->resultset();
    $inv_id =$inv_user[0]['inv_id'];
    
    $auto_inc = ++$inv_id;
    
    $db->query("update inv_autogen set inv_id ='$auto_inc' where id = '1' ");
    $db->execute();

    $cname = ucfirst($_POST['cname']);
    $caddress = $_POST['caddress'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $logo = ucwords($_POST['logo']);



    $ccname = ucfirst($_POST['cc_name']);
    $ccaddress = $_POST['cc_address'];
    $ccstate = $_POST['cc_state'];

    $ccountry = $_POST['cc_country'];

    $invno = $auto_inc;
    $invDate = $_POST['invDate'];
    $dueDate = $_POST["dueDate"];

    $notes = $_POST["notes"];

    $total = $_POST["total"];

    $gst = $_POST["gst"];
    $gst_amt = $_POST['gstamount'];

    $sub_total = $_POST["sub"];


    // Address Insert
    $db->query("INSERT into address (user_id,invoice_id,title,name,c_address,city,country,invoice_date,due_date) values (:userId,:invoiceId,:title,:Cname,:cAddress,:city,:country,:invoiceDate,:dueDate)");
    $db->bind(":userId", $user_id);
    $db->bind(":invoiceId", $invno);
    $db->bind(":title", $logo);
    $db->bind(":Cname", $cname);
    $db->bind(":cAddress", $caddress);
    $db->bind(":city", $city);
    $db->bind(":country", $country);
    $db->bind(":invoiceDate", $invDate);
    $db->bind(":dueDate", $dueDate);
    if ($db->execute()) {
        $status = 1;
    }


    // //  Billing Insert
    $db->query("insert into billing(invoice_id,b_name,b_address,b_city,b_country) values  (:invoice,:bName,:bAddress,:bCity,:bCountry)");

    $db->bind(":invoice", $invno);
    $db->bind(":bName", $ccname);
    $db->bind(":bAddress", $ccaddress);
    $db->bind(":bCity", $ccstate);
    $db->bind(":bCountry", $ccountry);
    if ($db->execute()) {
        $status = 1;
    }

    //  Notes Insert
    $db->query("insert into notes(invoice_id,notes) values (:invId, :notes)");
    $db->bind(":invId", $invno);
    $db->bind(":notes", $notes);
    if ($db->execute()) {
        $status = 1;
    }

    // insert total
    $db->query("insert into total(invoice_id, gst,gst_amount, sub_total,total) values (:invid, :gst,:gstAmount,:subTotal,:total)");
    $db->bind(":invid", $invno);
    $db->bind(":gst", $gst);
    $db->bind(":gstAmount", $gst_amt);
    $db->bind(":subTotal", $sub_total);
    $db->bind(":total", $total);
    if ($db->execute()) {
        $status = 1;
    }

    // // Items Insert

    for ($i = 0; $i < count($_POST['amt']); $i++) {

        $db->query("insert into items(invoice_id, item,qty,amount,rate) values (:invID, :item,:qty,:amount,:rate)");
        $db->bind(":invID", $invno);
        $db->bind(":item", $_POST['item'][$i]);
        $db->bind(":qty", $_POST['qty'][$i]);
        $db->bind(":amount", $_POST['amt'][$i]);
        $db->bind(":rate", $_POST['rate'][$i]);
        if ($db->execute()) {
            $status = 1;
        }
    }
    if ($status == 1) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Failed')</script>";
    }
} 
}
else {
    header("Location: index.php");
}
