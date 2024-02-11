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
$data = ["connectid"=>0];
if($result->num_rows === 0){
    $data["reponse"]="n'existe pas";
}elseif($reponse["password"] === $password){
        $data["reponse"]="success";
        $sql = "INSERT INTO connection(connectid, userid) VALUE(?, ?)";
        $request = $db->prepare($sql);
        $full = $email.$password.date("h-m-s");
        $request->bind_param("si", $full, $reponse["id"]);
        $request->execute();
        $request->close();
        $data["connectid"]=$full;
        $data["reponse"] = "success";
    }else{
        $data["reponse"]="mauvais mot de passe";
    }


echo json_encode($data);
?>