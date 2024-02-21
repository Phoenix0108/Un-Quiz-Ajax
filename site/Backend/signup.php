<?php
    // Inclusion du fichier de connexion à la base de données
    include __DIR__."/../include/db_connect.php";

    // Autorisation d'accès depuis n'importe quelle origine
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST["nom"]);
    $email = htmlspecialchars($_POST["email"]);
    $password_hash = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);

    // Requête pour vérifier si l'email est déjà utilisé
    $sql = "SELECT email, password FROM utilisateur WHERE email = ?";
    $request = $db->prepare($sql);
    $request->bind_param("s", $email);
    $request->execute();

    // Récupération du résultat de la requête
    $result = $request->get_result();

    // Fermeture de la requête préparée
    $request->close();

    // Vérification si l'email est déjà utilisé
    if ($result->num_rows === 0) {

        // Ajout de l'utilisateur s'il n'existe pas
        $token = bin2hex(random_bytes(32));

        // Requête pour ajouter l'utilisateur
        $sql = "INSERT INTO utilisateur(nom, email, password, token) VALUES (?, ?, ?, ?)";
        $request = $db->prepare($sql);
        $request->bind_param("ssss", $nom, $email, $password_hash, $token);
        $request->execute();
        $request->close();

        // Stockage du token dans un cookie (durée : 6000 secondes)
        setcookie("token", $token, time()+6000, "/");

        $data = ["reponse"=> "success", "check"=>true];
        
    } else {
        $data = ["reponse"=>"compte déjà existant", "check"=>false];
    }

    // Retourner les données au format JSON
    echo json_encode($data);
?>
