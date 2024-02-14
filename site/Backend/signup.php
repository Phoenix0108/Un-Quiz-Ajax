<?php
include __DIR__."/../include/db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$nom = htmlspecialchars($_POST["nom"]);
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$sql = "SELECT email, password FROM utilisateur WHERE email = ?";
$request = $db->prepare($sql);
$request->bind_param("s", $email);
$request->execute();
$result = $request->get_result();
$request->close();
if($result->num_rows === 0){
    //ajout de lutilisateur
    $token = bin2hex(random_bytes(32));
    $sql = "INSERT INTO utilisateur(nom, email, password, token) VALUE(?, ?, ?, ?)";
    $request = $db->prepare($sql);
    $request->bind_param("ssss", $nom, $email, $password_hash, $token);
    $request->execute();
    $request->close();
    $data = ["reponse"=> "success", "check"=>true];
    setcookie("token", $token, time()+6000, "/");
}else{
    $data = ["reponse"=>"compte déjà existant", "check"=>false];
}
echo json_encode($data);
?>