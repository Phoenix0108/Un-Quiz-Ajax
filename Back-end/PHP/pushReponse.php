<?php
include "db_connect.php";
include "requeteExpress.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
if(isset($_POST["token"]) && isset($_POST["idQcm"]) && isset($_POST["numQuestion"]) && isset($_POST["reponse"])){
    $token = htmlspecialchars($_POST["token"]);
    $idQcm = htmlspecialchars($_POST["idQcm"]);
    $numQuestion = htmlspecialchars($_POST["numQuestion"]);
    $reponse = htmlspecialchars($_POST["reponse"]);
    //On récupère l'id de l'utilisateur
    $request = $db->prepare("SELECT * FROM utilisateur WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $user = $request->get_result();
    $request->close();
    if($user->num_rows == 1){
        $user = $user->fetch_assoc();
        // On récupère les question du QCM
        $request = $db->prepare("SELECT * FROM question WHERE idqcm = ?");
        $request->bind_param("i", $idQcm);
        $request->execute();
        $questionQcm = $request->get_result();
        $request->close();
        $questionQcm = $questionQcm->fetch_all(MYSQLI_ASSOC);
        $rowQuestion = count($questionQcm);
        if($rowQuestion > 0){
            if($numQuestion == 1){
                //si on début un QCM il faut faire un INSERT à express pour sauvegarder la progression
                $dataExpress = [
                    "numQuestionTotal"=>$rowQuestion,
                    "idqcm"=>$idQcm,
                    "id_user"=>$user['id']
                ];
                if($reponse == $questionQcm[$numQuestion-1]["reponseTrue"]){
                    //si la reponse est vraie on envoyer à express
                    $dataExpress["reponse"] = true;
                    $data = [
                        "state"=>true,
                        "reponse"=>true
                    ];
                    
                }else{
                    //si la reponse est fausse on envoyer à express
                    $dataExpress["reponse"] = false;
                    $indexTrue = $questionQcm[$numQuestion-1]["reponseTrue"];
                    $data = [
                        "state"=>true,
                        "reponse"=>false,
                        "True"=>$questionQcm[$numQuestion-1]['reponse'.$indexTrue.'']
                    ];
                }
                $resultat = requeteExpress('saveState', $dataExpress);
            }elseif(2 <= $numQuestion && $numQuestion <= $rowQuestion){
                //on va demander à express la progression
                $dataExpress = [
                    "idqcm"=>$idQcm,
                    "id_user"=>$user['id'],
                    "id_note"=>false
                ];
                $resultatExpress = requeteExpress("getProgression", $dataExpress);
                if($numQuestion == $resultatExpress["nbr_reponseRepondu"]+1){
                    //vérifie si le numéro de la reponse qu'on veut enregistrer est la suite des reponses enregistrées
                    //incrémente nbr_reponseRepondu
                    $dataExpress = [
                        "id"=>$resultatExpress["id"],
                        "reponseTrue"=>$resultatExpress["nbr_reponseTrue"],
                        "reponseRepondu"=>$resultatExpress["nbr_reponseRepondu"]+1,
                        "en_cours"=>1
                    ];
                    if($reponse == $questionQcm[$numQuestion-1]["reponseTrue"]){
                        //si la reponse est vraie
                        //incrémente nbr_reponseTrue
                        $dataExpress["reponseTrue"]++;
                        $data = [
                            "state"=>true,
                            "reponse"=>true
                        ];
                    }else{
                        $indexTrue = $questionQcm[$numQuestion-1]["reponseTrue"];
                        $data = [
                            "state"=>true,
                            "reponse"=>false,
                            "True"=>$questionQcm[$numQuestion-1]['reponse'.$indexTrue.'']
                        ];
                    }
                    if($rowQuestion == $numQuestion){
                        // la longueur des question du QCM est égale au numéro de la question alors c'est fini
                        $dataExpress["en_cours"] = 0;
                    }
                    $resultatExpress = requeteExpress("updateProgression", $dataExpress);
                }else{
                    $data = ["state"=>false, "reponse"=>"numéro question n'est pas consécutif"];
                }
                
            }
            echo json_encode($data);
        }
    }
}
$db->close();
?>