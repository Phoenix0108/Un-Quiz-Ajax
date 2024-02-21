<?php
    $allowOrigin = "http://localhost";
    header("Access-Control-Allow-Origin: *");

    // Vérification de l'existence du cookie "token"
    if (isset($_COOKIE["token"])) {
        
        // Vérification de l'existence des données "data" et "nom" dans la requête POST
        if (isset($_POST["data"]) && isset($_POST["nom"])) {
            
            $conforme = false;
            $qcm = $_POST["data"];
            $nom = htmlspecialchars($_POST["nom"]);

            // Vérification de la conformité des données du QCM
            if (!empty($nom)) {
                foreach ($qcm as $key => $value) {
                    if (
                        !empty($key) &&
                        !empty($value[0]) &&
                        !empty($value[1]) &&
                        !empty($value[2]) &&
                        !empty($value[3]) &&
                        (0 < $value[4] && $value[4] < 5)
                    ) {
                        $conforme = true;
                    } else {
                        $conforme = false;
                        break;
                    }
                }
            }

            // Si les données sont conformes
            if ($conforme) {
                include __DIR__."/../../include/db_connect.php";

                // Récupération de l'ID de l'utilisateur à partir du cookie "token"
                $token = $_COOKIE["token"];
                $request = $db->prepare("SELECT id FROM utilisateur WHERE token = ?");
                $request->bind_param("s", $token);
                $request->execute();
                $request = $request->get_result();
                $userid = $request->fetch_assoc()["id"];
                $row_utilisateur = $request->num_rows;
                $request->close();

                // Si un utilisateur est trouvé avec le token
                if ($row_utilisateur === 1) {

                    // Création du QCM
                    $request = $db->prepare("INSERT INTO qcm(id_user, nom) VALUE(?, ?)");
                    $request->bind_param("is", $userid, $nom);
                    $request->execute();
                    $request->close();

                    // Récupération de l'ID du QCM récemment créé
                    $request = $db->prepare("SELECT id FROM qcm WHERE id_user = ? ORDER BY id DESC LIMIT 1");
                    $request->bind_param("s", $userid);
                    $request->execute();
                    $request = $request->get_result();
                    $id_qcm = $request->fetch_assoc()["id"];
                    $request->close();
                    echo $id_qcm;

                    // Enregistrement des questions du QCM
                    foreach ($qcm as $key => $value) {
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

                // Fermeture de la connexion à la base de données
                $db->close();
            }
        }
    }
?>
