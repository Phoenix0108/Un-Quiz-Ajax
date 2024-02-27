<?php
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
include __DIR__."/../../include/db_connect.php";
if(isset($_COOKIE["token"]) && isset($_POST["idQcm"])){
    $token = htmlspecialchars($_COOKIE["token"]);
    $idQcm = htmlspecialchars($_POST["idQcm"]);
    $request = $db->prepare("SELECT * FROM qcm
    INNER JOIN utilisateur ON utilisateur.id = qcm.id_user
    WHERE token = ? AND qcm.id = ?");
    $request->bind_param("si", $token, $idQcm);
    $request->execute();
    $row_utilisateur = $request->num_rows;
    $request->close();
    echo $row_utilisateur;
    if($row_utilisateur >= 1){
        $request = $db->prepare("DELETE FROM qcm WHERE id = ?");
        $request->bind_param("i", $idQcm);
        $request->execute();
        $request->close();
        $request = $db->prepare("DELETE FROM question WHERE idqcm = ?");
        $request->bind_param("i", $idQcm);
        $request->execute();
        $request->close();
    }
}
$db->close();
?>