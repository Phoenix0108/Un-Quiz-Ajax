<?php
// include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$nom = htmlspecialchars($_POST["nom"]);
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);
/*
$sql = "SELECT email, password FROM utilisateur WHERE email = ?";
$request = $db->prepare($sql);
$request->bind_param("s", $email);
$request->execute();
if($request->num_rows === 0){
    $sql = "INSERT INTO utilisateur VALUE(?, ?, ?)";
    $request = $db->prepare($sql);
    $request->bind_param("sss", $nom, $email, $password);
    $request->execute();
    $data = ["reponse": "success"];
}else{
    $data = ["reponse": "compte déjà existant"];
}
*/
$data = ["reponse"=>$nom.$email.$password];
echo json_encode($data);
?>