<?php
session_start();


if (isset($_SESSION['email'])) {
    if (isset($_GET['id'])) {
        require_once "class/Database.php";

        $db = new Database();
        $inv_id = $_GET['id'];
        $table = array("address", "billing","items","notes","total");
        $status  = 0;
        foreach($table as $tab){
            $db->query("DELETE FROM $tab where invoice_id = :invID");
            $db->bind(":invID", $inv_id);
            $db->execute();
            $status =1;
        }
        if($status  == 1){
            header("Location: index.php");
        }else{
            echo "<script>alert('Failed to Delete');</script>";
        }
    }
}
