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
    $request = $db->prepare("SELECT reponseTrue, utilisateur.id AS id_user, reponse1, reponse2, reponse3, reponse4
    FROM utilisateur 
    INNER JOIN qcm ON qcm.id_user = utilisateur.id
    INNER JOIN question ON question.idqcm = qcm.id
    WHERE token = ? AND qcm.id = ?");
    $request->bind_param("si", $token, $idQcm);
    $request->execute();
    $result = $request->get_result();
    $request->close();
    $row = $result->num_rows;
    $result = $result->fetch_all(MYSQLI_ASSOC);
    if(1 <= $numQuestion && $numQuestion <= $row){
        $id_user = $result[0]["id_user"];
        //Vérifier si le numéro de la question demandé fait partie du qcm
        if($reponse == $result[$numQuestion-1]["reponseTrue"]){
            //envoyer à express
            $data = json_encode([
                "reponse"=>true, 
                "numQuestion"=>$numQuestion,
                "numQuestionTotal"=>$row,
                "idQcm"=>$idQcm,
                "id_user"=>$id_user
            ]);
            $opts = ['http'=>[
                "method"=>"POST",
                "header"=>"Content-Type: application/json",
                "content"=> $data
            ]];
            $context = stream_context_create($opts);
            $reponse = file_get_contents('http://127.0.0.1:81/repondre-question', false, $context);
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
}
$db->close();
?>