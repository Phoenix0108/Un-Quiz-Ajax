<?php
include "db_connect.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["token"]) && isset($_POST["idQcm"]) && isset($_POST["numQuestion"])){
    // récuparation de l'ID
    $token = htmlspecialchars($_POST["token"]);
    $idQcm = htmlspecialchars($_POST["idQcm"]);
    $numQuestion = htmlspecialchars($_POST["numQuestion"]);
    $request = $db->prepare("SELECT question, reponse1, reponse2, reponse3, reponse4
    FROM utilisateur 
    INNER JOIN qcm ON qcm.id_user = utilisateur.id
    INNER JOIN question ON question.idqcm = qcm.id
    WHERE token = ? AND qcm.id = ?");
    $request->bind_param("si", $token, $idQcm);
    $request->execute();
    $request = $request->get_result();
    $result = $request->fetch_all(MYSQLI_ASSOC);
    if(1 <= $numQuestion && $numQuestion <= $request->num_rows){
        //Vérifier si le numéro de la question demandé fait partie du qcm
        $data = [
            "state"=>true,
            "question"=>$result[$numQuestion-1]["question"],
            "reponse1"=>$result[$numQuestion-1]["reponse1"],
            "reponse2"=>$result[$numQuestion-1]["reponse2"],
            "reponse3"=>$result[$numQuestion-1]["reponse3"],
            "reponse4"=>$result[$numQuestion-1]["reponse4"],
            "numQuestionTotal"=>$request->num_rows,
            "index"=>$numQuestion
        ];
        echo json_encode($data);
    }
    $request->close();
}
$db->close();
?>