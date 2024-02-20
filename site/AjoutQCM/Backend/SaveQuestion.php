<?php
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
if(isset($_COOKIE["token"])){
    //verifier les données
    if(isset($_POST["data"]) && isset($_POST["nom"])){
        $conforme = false;
        $qcm = $_POST["data"];
        $nom = htmlspecialchars($_POST["nom"]);
        if(!empty($nom)){
            foreach($qcm as $key =>$value){
                if(!empty($key) && !empty($value[0]) && !empty($value[1]) && !empty($value[2]) && !empty($value[3]) && (0 < $value[4] && $value[4] < 5)){
                    $conforme = true;
                }else{
                    $conforme = false;
                    break;
                }
            }
        }
        if($conforme){
            include __DIR__."/../../include/db_connect.php";
            // récuparation de l'ID
            $token = $_COOKIE["token"];
            $request = $db->prepare("SELECT id FROM utilisateur WHERE token = ?");
            $request->bind_param("s", $token);
            $request->execute();
            $request = $request->get_result();
            $userid = $request->fetch_assoc()["id"];
            $row_utilisateur = $request->num_rows;
            $request->close();
            if($row_utilisateur === 1){
                //création du qcm
                $request = $db->prepare("INSERT INTO qcm(id_user, nom) VALUE(?, ?)");
                $request->bind_param("is", $userid, $nom);
                $request->execute();
                $request->close();
                //récupération de l'ID du qcm
                $request = $db->prepare("SELECT id FROM qcm WHERE id_user = ? ORDER BY id DESC LIMIT 1");
                $request->bind_param("s", $userid);
                $request->execute();
                $request = $request->get_result();
                $id_qcm = $request->fetch_assoc()["id"];
                $request->close();
                echo $id_qcm;
                //enregistrement des question 
                $qcm = $_POST["data"];
                //*
                foreach($qcm as $key =>$value){
                    $question = htmlspecialchars($key);
                    $reponse1 = htmlspecialchars($value[0]);
                    $reponse2 = htmlspecialchars($value[1]);
                    $reponse3 = htmlspecialchars($value[2]);
                    $reponse4 = htmlspecialchars($value[3]);
                    $reponseTrue = htmlspecialchars($value[4]);
                    $request = $db->prepare("INSERT INTO question(idqcm, question, reponse1, reponse2, reponse3, reponse4, reponseTrue) VALUE(?, ?, ?, ?, ?, ?, ?)");
                    $request->bind_param("isssssi", $id_qcm, $key, $reponse1, $reponse2, $reponse3, $reponse4, $reponseTrue);
                    $request->execute();
                    $request->close();
                }
            }
            $db->close();
        }
    }
    
}

?>
