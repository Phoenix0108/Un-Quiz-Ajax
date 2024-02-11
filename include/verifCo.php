<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$userId = 0;
$stateCo = false;
if(isset($_COOKIE["token"])){
    $token = htmlspecialchars($_COOKIE["token"]);
    $slq = "SELECT * FROM utilisateur WHERE token = ?";
    $request = $db->prepare($sql);
    $request->bind_param("s", $token);
    $request->execute();
    $result = $request->get_result();
    $request->close();
    $row = $result->row_nums;

    if($row === 0){
        $data=["stateCo"=>false];
    }else{
        $data=["stateCo"=>false, "token"=>$result->fetch_assoc()["token"]];
    }
}else{
    $data=["stateCo"=>false];
}
echo json_encode($data);
?>