<?php
include "db_connect.php";
include "requeteExpress.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");
if(isset($_POST["token"])){
    $token = htmlspecialchars($_POST["token"]);
    $request = $db->prepare("SELECT * FROM utilisateur WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $user = $request->get_result();
    $request->close();
    if($user->num_rows == 1){
        $user = $user->fetch_assoc();
        $dataExpress = [
            "id_user"=>$user["id"]
        ];
        $resultatExpress = requeteExpress("getNote", $dataExpress);
        for($i = 0; $i < count($resultatExpress); $i++){
            $note = $resultatExpress[$i];
            $request = $db->prepare("SELECT nom FROM qcm 
            INNER JOIN question ON question.idqcm = qcm.id
            WHERE qcm.id = ?
            ");
            $request->bind_param("i", $note["idqcm"]);
            $request->execute();
            $qcm = $request->get_result();
            $nbr_ligne = $qcm->num_rows;
            $qcm = $qcm->fetch_assoc();
            if($note["en_cours"] == 1){
                //Le QCM n'est pas fini
                echo '
                <div class="container Column historique">
                    <div class="Row sp_btw">
                        <div>
                            <h3 class="title">'.($qcm["nom"]).'</h3>
                        </div>
                        <span class="note">Question restante:'.($nbr_ligne - $note["nbr_reponseRepondu"]).'</span>
                    </div>
                    <div class="Column cInput">
                        <span>Code de partage : #'.($note["idqcm"]).'</span>
                        <span class="enCours">En cours</span>
                    </div>
                    <div class="Row end">
                        <span>Date : '.($note["date"]).'</span>
                    </div>
                    <div class="Row">
                        <button type="button" class="green" onclick="reprendreQCM('.($note["id"]).')">Reprendre</button>
                        <button type="button" class="red" onclick="supQCM('.($note["id"]).')">Supprimer</button>
                    </div>
                </div>';
            }else{
                echo '
                <div class="container Column historique">
                    <div class="Row sp_btw">
                        <div>
                            <h3 class="title">Athèle</h3>
                        </div>
                        <span class="note">Note '.($note["nbr_reponseTrue"])."/".($note["nbr_reponseRepondu"]).'</span>
                    </div>
                    <div class="Column cInput">
                        <span>Code de partage : #'.($note["idqcm"]).'</span>
                        <span class="terminer">Terminer</span>
                    </div>
                    <div class="Row end">
                        <span>Date : '.($note["date"]).'</span>
                    </div>
                    <button type="button" class="red" onclick="supQCM('.($note["id"]).')">Supprimer</button>
                </div>';
            }
        }
    }
}
?>