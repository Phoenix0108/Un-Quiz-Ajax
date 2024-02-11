<?php
include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);
$request = $db->prepare("SELECT * FROM utilisateur WHERE email = ?");
$request->bind_param("s", $email);
$request->execute();
$result = $request->get_result();
$request->close();
$reponse = $result->fetch_assoc();
$data = ["token"=>0];
if($result->num_rows === 0){
    $data["reponse"]="n'existe pas";
}elseif($reponse["password"] === $password){
        $data["reponse"]="success";
        $sql = "UPDATE utilisateur SET token=? WHERE id = ?";
        $request = $db->prepare($sql);
        $token = bin2hex(random_bytes(32));
        $request->bind_param("si", $token, $reponse["id"]);
        $request->execute();
        $request->close();
        $data["token"]=$token;
        $data["reponse"] = "success";
    }else{
        $data["reponse"]="mauvais mot de passe";
    }


echo json_encode($data);
?>