<?php 

if(isset($_GET['action'])){
    session_start();
    unset($_SESSION['email']);
    
    header("Location: index.php");

}