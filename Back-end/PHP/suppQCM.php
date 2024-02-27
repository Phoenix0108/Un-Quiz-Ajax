<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");
if(isset($_POST["token"]) && isset($_POST["idQcm"])){
    include "db_connect.php";
    $token = htmlspecialchars($_POST["token"]);
    $idQcm = htmlspecialchars($_POST["idQcm"]);
    //Récupération de le Qcm associé à l'utilisateur
    $request = $db->prepare("SELECT qcm.id AS idQcm FROM utilisateur INNER JOIN qcm ON qcm.id_user = utilisateur.id WHERE token = ? AND qcm.id = ?");
    $request->bind_param("si", $token, $idQcm);
    $request->execute();
    $result = $request->get_result();
    $request->close();
    $row = $result->num_rows;
    if($row === 1){
        //suppression du QCM
        $request = $db->prepare("DELETE FROM qcm WHERE id = ?");
        $request->bind_param("i", $idQcm);
        $request->execute();
        $request->close();
        //supression des questions du QCM
        $request = $db->prepare("DELETE FROM question WHERE idqcm = ?");
        $request->bind_param("i", $idQcm);
        $request->execute();
        $request->close();
    }
    $db->close();
}
?>