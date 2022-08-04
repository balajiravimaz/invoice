<?php
session_start();
require_once "class/Database.php";


if (isset($_SESSION['email'])) {
    if (isset($_POST['update'])) {

        $db = new Database();

        $status = "";

        $invid = $_POST['invid'];


        $cname = ucfirst($_POST['cname']);
        $caddress = $_POST['caddress'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $logo = ucwords($_POST['logo']);



        $ccname = ucfirst($_POST['cc_name']);
        $ccaddress = $_POST['cc_address'];
        $ccstate = $_POST['cc_state'];

        $ccountry = $_POST['cc_country'];

        $invDate = $_POST['invDate'];
        $dueDate = $_POST["dueDate"];

        $notes = $_POST["notes"];

        $total = $_POST["total"];

        $gst = $_POST["gst"];
        $gst_amt = $_POST['gstamount'];

        $sub_total = $_POST["sub"];


        // Address update            

        $db->query("update address set title=:title, name=:Name, c_address=:Address, city=:City, country=:Country, invoice_date=:invDate, due_date=:Date where invoice_id=:id");
        $db->bind(":title", $logo);
        $db->bind(":Name", $cname);
        $db->bind(":Address", $caddress);
        $db->bind(":City", $city);
        $db->bind(":Country", $country);
        $db->bind(":invDate", $invDate);
        $db->bind(":Date", $dueDate);
        $db->bind(":id", $invid);
        if ($db->execute()) {
            $status = 1;
        }


        // //  Billing update    
        $db->query("update billing set b_name=:Name, b_address=:Address, b_city=:City, b_country=:Country where invoice_id=:id");
        $db->bind(":Name", $ccname);
        $db->bind(":Address", $ccaddress);
        $db->bind(":City", $ccstate);
        $db->bind(":Country", $ccountry);
        $db->bind(":id", $invid);
        if ($db->execute()) {
            $status = 1;
        }

        //  Notes update    
        $db->query("update notes set notes = :Notes where invoice_id = :id");
        $db->bind(":Notes", $notes);
        $db->bind(":id", $invid);
        if ($db->execute()) {
            $status = 1;
        }



        // $insert = [];
        // $update = [];

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        // var_dump($_POST['itemId'])

        // update total    
        
        $db->query("update total set gst=:Gst, gst_amount=:Amount, sub_total=:Sub, total=:Total where invoice_id = :id");

        $db->bind(":Gst", $gst);
        $db->bind(":Amount", $gst_amt);
        $db->bind(":Sub", $sub_total);
        $db->bind(":Total", $total);
        $db->bind(":id", $invid);
        if ($db->execute()) {
            $status = 1;
        }


        // // Items update
        for ($i = 0; $i < count($_POST['amt']); $i++) {

            if (!empty($_POST['itemId'][$i])) {

                $db->query("update items set item=:Item, qty=:Qty, amount=:Amount, rate=:Rate where id=:id");
                $db->bind(":Item", $_POST['item'][$i]);
                $db->bind(":Qty", $_POST['qty'][$i]);
                $db->bind(":Amount", $_POST['amt'][$i]);
                $db->bind(":Rate", $_POST['rate'][$i]);
                $db->bind(":id", $_POST['itemId'][$i]);
                if ($db->execute()) {
                    $status = 1;
                }
            } else {
                $db->query("INSERT into items (invoice_id, item,qty,amount,rate) values (:invID, :item,:qty,:amount,:rate)");
                $db->bind(":invID", $invid);
                $db->bind(":item", $_POST['item'][$i]);
                $db->bind(":qty", $_POST['qty'][$i]);
                $db->bind(":amount", $_POST['amt'][$i]);
                $db->bind(":rate", $_POST['rate'][$i]);
                if ($db->execute()) {
                    $status = 1;
                }
            }
        }


        if ($status == 1) {
            header('Location: print.php?id=' . $invid);
        } else {
            echo "<script>alert('Failed')</script>";
        }
    }
} else {
    header("Location: index.php");
}
