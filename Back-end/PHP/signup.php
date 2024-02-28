<?php
include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["signup_name"]) && isset($_POST["signup_email"]) && isset($_POST["signup_password"])){
    $nom = htmlspecialchars($_POST["signup_name"]);
    $email = htmlspecialchars($_POST["signup_email"]);
    $password_hash = password_hash(htmlspecialchars($_POST["signup_password"]), PASSWORD_DEFAULT);
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
        $data = [
            "reponse"=> "success",
            "state"=>true,
            "token"=>$token
        ];
    }else{
        $data = ["reponse"=>"compte déjà existant", "state"=>false];
    }
    echo json_encode($data);
}
$db->close();
?>