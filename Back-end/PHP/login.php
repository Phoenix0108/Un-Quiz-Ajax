<?php
include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["login_email"]) && isset($_POST["login_password"])){
    $email = htmlspecialchars($_POST["login_email"]);
    $request = $db->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $request->bind_param("s", $email);
    $request->execute();
    $result = $request->get_result();
    $request->close();
    $reponse = $result->fetch_assoc();
    if($result->num_rows === 0){
        $data = ["reponse"=>"n'existe pas", "state"=>false];
    }elseif(password_verify(htmlspecialchars($_POST["login_password"]), $reponse["password"])){
            $sql = "UPDATE utilisateur SET token=? WHERE id = ?";
            $request = $db->prepare($sql);
            $token = bin2hex(random_bytes(32));
            $request->bind_param("si", $token, $reponse["id"]);
            $request->execute();
            $request->close();
            setcookie("token", $token, time()+6000, "/");
            $data = [
                "reponse"=>"success", 
                "token"=>$token,
                "state"=>true];  
        }else{
            $data = ["reponse"=>"mauvais mot de passe", "state"=>false];
        }

    echo json_encode($data);
}
?>