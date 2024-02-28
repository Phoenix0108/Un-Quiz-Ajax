<?php
include "db_connect.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["token"])){
    $token = htmlspecialchars($_POST["token"]);
    $request = $db->prepare("DELETE FROM utilisateur WHERE token = ?");
    $request->bind_param('s', $token);
    $request->execute();
    $request->close();
    echo json_encode(["state"=>true]);
}
$db->close();
?>