<?php
include "db_connect.php";
include "requeteExpress.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["token"]) && isset($_POST["idQcm"]) && isset($_POST["numQuestion"])){
    // récuparation de l'ID
    $token = htmlspecialchars($_POST["token"]);
    $idQcm = htmlspecialchars($_POST["idQcm"]);
    $numQuestion = htmlspecialchars($_POST["numQuestion"]);
    $request = $db->prepare("SELECT question, reponse1, reponse2, reponse3, reponse4
    FROM qcm
    INNER JOIN question ON question.idqcm = qcm.id
    WHERE qcm.id = ?");
    $request->bind_param("i",$idQcm);
    $request->execute();
    $request = $request->get_result();
    $questionQcm = $request->fetch_all(MYSQLI_ASSOC);
    $rowQuestion = $request->num_rows;
    $request->close();
    if(1 <= $numQuestion && $numQuestion <= $rowQuestion){
        //Vérifier si le numéro de la question demandé fait partie du qcmù
        if(isset($_POST["idHistorique"])){
            //reprendre un QCM
            $idHistorique = htmlspecialchars($_POST["idHistorique"]);
            //on prend recupère l'id de l'utilisateur
            $request = $db->prepare("SELECT * FROM utilisateur WHERE token = ?");
            $request->bind_param("s", $token);
            $request->execute();
            $request = $request->get_result();
            $user = $request->fetch_assoc();
            //Pour retrouver à quel numéro on c'est arréter
            $dataExpress = [
                "idqcm"=>$idQcm,
                "id_user"=>$user['id'],
                "id_note"=>$idHistorique
            ];
            $resultatExpress = requeteExpress("getProgression", $dataExpress);
            $numQuestion = $resultatExpress["nbr_reponseRepondu"]+1;
        }
        $data = [
            "state"=>true,
            "question"=>$questionQcm[$numQuestion-1]["question"],
            "reponse1"=>$questionQcm[$numQuestion-1]["reponse1"],
            "reponse2"=>$questionQcm[$numQuestion-1]["reponse2"],
            "reponse3"=>$questionQcm[$numQuestion-1]["reponse3"],
            "reponse4"=>$questionQcm[$numQuestion-1]["reponse4"],
            "numQuestionTotal"=>$rowQuestion,
            "index"=>$numQuestion
        ];
        echo json_encode($data);
    }
}
$db->close();
?>