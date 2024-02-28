<?php
include "db_connect.php";
include "requeteExpress.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["token"])){
    $token = htmlspecialchars($_POST["token"]);
    //On récupère l'id de l'utilisateur
    $request = $db->prepare("SELECT * FROM utilisateur WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $user = $request->get_result();
    $request->close();
    if($user->num_rows == 1){
        $user = $user->fetch_assoc();
        if(isset($_POST["idQcm"])){
            //On recherche les resultats du dernier qcm terminé
            $idQcm = htmlspecialchars($_POST["idQcm"]);
            $dataExpress = [
                "id_user"=>$user["id"],
                "idQcm"=>$idQcm
            ];
        }elseif(isset($_POST["idHistorique"])){
            //On recherche les resultat d'un qcm précis
            $idHistorique = htmlspecialchars($_POST["idHistorique"]);
            $dataExpress = [
                "id_user"=>$user["id"],
                "idHistorique"=>$idHistorique
            ];
        }
        if(isset($dataExpress)){
            $resultatExpress = requeteExpress("getResultat", $dataExpress);
            //On recupère les question du QCM
            $request = $db->prepare("SELECT nom FROM qcm
            INNER JOIN question ON qcm.id = question.idqcm
            WHERE qcm.id = ?");
            $request->bind_param("i", $resultatExpress["idqcm"]);
            $request->execute();
            $questionQCM = $request->get_result();
            $rowQuestion = $questionQCM->num_rows;
            $nomQcm = $questionQCM->fetch_assoc()['nom'];
            $data = [
                "numReponseTrue"=>$resultatExpress["nbr_reponseTrue"],
                "numQuestion"=>$rowQuestion,
                "nom"=>$nomQcm
            ];
            echo json_encode($data);
        }
    }
}
$db->close();
?>