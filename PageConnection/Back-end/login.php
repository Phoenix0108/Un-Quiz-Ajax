<?php
// include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);
/*
$sql = "SELECT email, password FROM utilisateur WHERE email = ?";
$request = $db->prepare($sql);
$request->bind_param("s", $email);
$request->execute();
$reponse = $request->fetch_assoc();
if($reponse->num_rows === 0){
    $data = ["reponse"=>"n'existe pas"];
}elseif($reponse["password"] === $password){
        $data = ["reponse"=>"success"];
    }else{
        $data = ["reponse"=>"mauvais mot de passe"];
    }
*/
$data = ["reponse"=>$email.$password];
echo json_encode($data);
?>