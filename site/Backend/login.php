<?php
include __DIR__."/../include/db_connect.php";
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
if($result->num_rows === 0){
    $data = ["reponse"=>"n'existe pas", "check"=>false];
}elseif(password_verify($password, $reponse["password"])){
        $sql = "UPDATE utilisateur SET token=? WHERE id = ?";
        $request = $db->prepare($sql);
        $token = bin2hex(random_bytes(32));
        $request->bind_param("si", $token, $reponse["id"]);
        $request->execute();
        $request->close();
        setcookie("token", $token, time()+6000, "/");
        $data = ["reponse"=>"success", "check"=>true];  
    }else{
        $data = ["reponse"=>"mauvais mot de passe", "check"=>false];
    }


echo json_encode($data);
?>