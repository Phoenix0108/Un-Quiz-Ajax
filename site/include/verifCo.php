<?php
include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$userId = 0;
$stateCo = false;
if(isset($_COOKIE["token"])){
    $token = htmlspecialchars($_COOKIE["token"]);
    $request = $db->prepare("SELECT * FROM utilisateur WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $result = $request->get_result();
    $request->close();
    $row = $result->num_rows;

    if($row === 0){
        $data=["stateCo"=>false];
    }else{
        $data=["stateCo"=>true];
        setcookie("token", $token, time()+600, "/");
    }
}else{
    $data=["stateCo"=>false];
}
echo json_encode($data);
?>