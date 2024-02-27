<?php
include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");
if(isset($_POST["token"])){
    $token = htmlspecialchars($_POST["token"]);
    //Récupération de l'id_user
    $request = $db->prepare(
        "SELECT qcm.id AS idQcm, qcm.nom AS nom FROM utilisateur
        INNER JOIN qcm ON qcm.id_user = utilisateur.id
        WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $qcm = $request->get_result();
    $row = $qcm->num_rows;
    $request->close();
    if($row > 0){
        while($var = $qcm->fetch_assoc()){
            $request = $db->prepare("SELECT count(*) AS nombre_question FROM question WHERE idqcm = ?");
            $request->bind_param("i", $var["idQcm"]);
            $request->execute();
            $result = $request->get_result();
            $request->close();
            echo '
            <div class="Column cInput container">
                <span>'.($var["nom"]).'</span>
                <span>Nombre de question : '.($result->fetch_assoc()["nombre_question"]).'</span>
                <span>Code de partage : #'.($var["idQcm"]).'</span>
                <div class="Row">
                    <button onclick="lance('.($var["idQcm"]).')" class="blue">Lancez</button>
                    <button onclick="supp('.($var["idQcm"]).')" class="red">Supprimer</button>
                </div>
            </div>
            ';
        }
    }
}
?>