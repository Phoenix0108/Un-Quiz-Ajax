<?php
include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["token"])){
    $token = htmlspecialchars($_POST["token"]);
    $request = $db->prepare("SELECT * FROM utilisateur WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $result = $request->get_result();
    $request->close();
    $reponse = $result->fetch_assoc();
    if($result->num_rows === 1){
        $data = [
            "nom"=>$reponse["nom"],
            "email"=>$reponse["email"],
            "state"=>false
        ];
        echo json_encode($data);
    }
}
?>