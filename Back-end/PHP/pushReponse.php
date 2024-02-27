<?php
include __DIR__."/../../include/db_connect.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["token"]) && isset($_POST["idQcm"]) && isset($_POST["numQuestion"]) && isset($_POST["reponse"])){
    // Vérification de la légitimité de l'utilisateur
    $token = htmlspecialchars($_POST["token"]);
    $idQcm = htmlspecialchars($_POST["idQcm"]);
    $numQuestion = htmlspecialchars($_POST["numQuestion"]);
    $reponse = htmlspecialchars($_POST["reponse"]);
    $request = $db->prepare("SELECT reponseTrue
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
        if($reponse == $result[$numQuestion-1]["reponseTrue"]){
            $data = [
                "state"=>true,
                "reponse"=>true,
            ];
        }else{
            $indexTrue = $result[$numQuestion-1]["reponseTrue"];
            $data = [
                "state"=>true,
                "reponse"=>false,
                "True"=>$result[$numQuestion-1]['reponse'.$indexTrue.'']
            ];
        }
        echo json_encode($data);
    }
    $request->close();
}
$db->close();
?>