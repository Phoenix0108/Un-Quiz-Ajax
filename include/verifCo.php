<?php
$userId = 0;
$stateCo = false;
if(isset(htmlspecialchars($_COOKIE["connect_id"]))){
    $connectionId = htmlspecialchars($_COOKIE["connect_id"])
    $slq = "SELECT userid FROM connection WHERE connectid = ?";
    $request = $db->prepare($sql);
    $request->bind_param("s", $connectionId);
    $request->execute();
    $result = $request->get_result();
    $request->close();
    $row = $result->row_nums;

    if($row === 0){
        $data=["stateCo"=>"session non existante"];
    }else{
        $data=["stateCo"=>"session existante"];
        $connectid = $result->fetch_assoc()["userid"];
        $stateCo = true;
    }
}else{
    $data=["stateCo"=>"session exipiré"];
}
?>