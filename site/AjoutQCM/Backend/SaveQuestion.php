<?php
include "db_connect.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
if(isset($_COOKIE["token"])){
    // récuparation de l'ID
    $token = $_COOKIE["token"];
    $request = $db->prepare("SELECT id FROM utilisateur WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $request = $request->get_result();
    $userid = $request->fetch_assoc()["id"];
    $row_utilisateur = $request->num_rows;
    $request->close();
    if($row_utilisateur === 1){
        //création du qcm
        $request = $db->prepare("INSERT INTO qcm(id_user) VALUE(?)");
        $request->bind_param("i", $userid);
        $request->execute();
        $request->close();
        //récupération de l'ID du qcm
        $request = $db->prepare("SELECT id FROM qcm WHERE id_user = ? ORDER BY id DESC LIMIT 1");
        $request->bind_param("s", $userid);
        $request->execute();
        $request = $request->get_result();
        $id_qcm = $request->fetch_assoc()["id"];
        $request->close();
        echo $id_qcm;
        //enregistrement des question 
        $qcm = $_POST["data"];
        //*
        foreach($qcm as $key =>$value){
            $question = $key;
            $reponse1 = $value[0];
            $reponse2 = $value[1];
            $reponse3 = $value[2];
            $reponse4 = $value[3];
            $reponseTrue = $value[4];
            $request = $db->prepare("INSERT INTO question(idqcm, question, reponse1, reponse2, reponse3, reponse4, reponseTrue) VALUE(?, ?, ?, ?, ?, ?, ?)");
            $request->bind_param("isssssi", $id_qcm, $key, $reponse1, $reponse2, $reponse3, $reponse4, $reponseTrue);
            $request->execute();
            $request->close();
        }
        //*/
        $db->close();
    }
}

?>
