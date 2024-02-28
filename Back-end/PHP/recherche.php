<?php
include "db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");
if(isset($_POST["recherche"])){
    $recherche = htmlspecialchars($_POST["recherche"]);
    //Récupération de l'id_user
    if($recherche != ""){
        $request = $db->prepare("SELECT * FROM qcm WHERE id LIKE ?");
        $request->bind_param("i", $recherche);
    }else{
    $request = $db->prepare("SELECT * FROM qcm");
    }
    $request->execute();
    $qcm = $request->get_result();
    $row = $qcm->num_rows;
    $request->close();
    if($row>0){
        while($var = $qcm->fetch_assoc()){
            $request = $db->prepare("SELECT count(*) AS nbr_ligne FROM question WHERE idqcm = ?");
            $request->bind_param("i", $var["id"]);
            $request->execute();
            $question = $request->get_result();
            $question = $question->fetch_assoc();
            $request->close();
            echo '
            <div class="Column cInput container">
                <span>'.($var["nom"]).'</span>
                <span>Nombre de question : '.($question["nbr_ligne"]).'</span>
                <span>Code de partage : #'.($var["id"]).'</span>
                <button onclick="lance('.($var["id"]).')" class="blue">Lancez</button>
            </div>';
        }
    }
}
?>