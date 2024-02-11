<?php
include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$nom = htmlspecialchars($_POST["nom"]);
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);
$sql = "SELECT email, password FROM utilisateur WHERE email = ?";
$request = $db->prepare($sql);
$request->bind_param("s", $email);
$request->execute();
$result = $request->get_result();
$request->close();
$data = ["token"=>0];
if($result->num_rows === 0){
    //ajout de lutilisateur
    $token = bin2hex(random_bytes(32));
    $sql = "INSERT INTO utilisateur(nom, email, password, token) VALUE(?, ?, ?, ?)";
    $request = $db->prepare($sql);
    $request->bind_param("ssss", $nom, $email, $password, $token);
    $request->execute();
    $request->close();
    $data["reponse"]= "success";
    $data["token"]=$token;
}else{
    $data["reponse"]="compte déjà existant";
}
echo json_encode($data);
?>