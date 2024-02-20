<?php
include __DIR__."/../../include/db_connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");
if(isset($_COOKIE["token"])){
    $token = htmlspecialchars($_COOKIE["token"]);
    //Récupération de l'id_user
    $request = $db->prepare("SELECT id FROM utilisateur WHERE token = ?");
    $request->bind_param("s", $token);
    $request->execute();
    $result = $request->get_result();
    $request->close();
    $row = $result->num_rows;
    $id = $result->fetch_assoc()["id"];
    if($row === 1){
        //Récupération de l'id des qcm en fonction de l'id de l'utilisateur
        $request = $db->prepare("SELECT id, nom FROM qcm WHERE id_user = ?");
        $request->bind_param("i", $id);
        $request->execute();
        $qcm= $request->get_result();
        $request->close();
        //Récupération des id des qcms
        while($var = $qcm->fetch_assoc()){
            $request = $db->prepare("SELECT count(*) AS nombre_question FROM question WHERE idqcm = ?");
            $request->bind_param("i", $var["id"]);
            $request->execute();
            $result = $request->get_result();
            $request->close();
            echo '<div class="content">
            <span>'.($var["nom"]).'</span>
            <br>
            <span>Nombre de question : '.($result->fetch_assoc()["nombre_question"]).'</span>
            <br>
            <span>Code de partage : #'.($var["id"]).'</span>
            <br><br>
            <button onclick="lance('.($var["id"]).')">Lancez</button>
            <button onclick=supp('.($var["id"]).')>Supprimer</button>
            </div>';
        }
    }
}
?>