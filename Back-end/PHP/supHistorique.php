<?php
include "db_connect.php";
include "requeteExpress.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");
if(isset($_POST["token"]) && isset($_POST["id_note"])){
    $token = htmlspecialchars($_POST["token"]);
    $id_note = htmlspecialchars($_POST["id_note"]);
    $request = $db->prepare("SELECT * FROM utilisateur WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $user = $request->get_result();
    $request->close();
    if($user->num_rows == 1){
        $user = $user->fetch_assoc();
        $dataExpress = [
            "id_user"=>$user['id'],
            "id_note"=>$id_note
        ];
        requeteExpress("supNote", $dataExpress);
    }
}
?>