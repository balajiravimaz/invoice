<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    require_once "class/Database.php";
    $db = new Database;
    $payload = file_get_contents('php://input');
    $data = json_decode($payload);
    $item_id = $data->id;
    
    $db->query("delete from items where id=:id");
    $db->bind(":id", $item_id);
    $db->execute();
}
