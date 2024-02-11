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
$data = ["connectid"=>0];
if($result->num_rows === 0){
    //ajout de lutilisateur
    $sql = "INSERT INTO utilisateur(nom, email, password) VALUE(?, ?, ?)";
    $request = $db->prepare($sql);
    $request->bind_param("sss", $nom, $email, $password);
    $request->execute();
    $request->close();
    //récupération de son id
    $request = $db->prepare("SELECT id FROM utilisateur WHERE email = ?");
    $request->bind_param("s", $email);
    $request->execute();
    //création de sa session
    $result = $request->get_result();
    $id = $result->fetch_assoc()["id"];
    $request->close();
    $request = $db->prepare("INSERT INTO connection(connectid, userid) VALUE(?, ?)");
    $full = $email.$password.date("h-m-s");
    $request->bind_param("si", $full,$id);
    $request->execute();
    $request->close();
    $data["reponse"]= "success";
    $data["connectid"]=$full;
}else{
    $data["reponse"]="compte déjà existant";
}
echo json_encode($data);
?>