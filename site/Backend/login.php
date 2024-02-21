<?php
// Inclure le fichier de connexion à la base de données
include __DIR__."/../include/db_connect.php"; 

// Autoriser l'accès depuis n'importe quel origine
header("Access-Control-Allow-Origin: *");

// Définir le type de contenu pour la réponse JSON
header("Content-Type: application/json");

// Récupérer les données du formulaire 
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);

// Préparer la requête SQL pour récupérer l'utilisateur en fonction de l'email
$request = $db->prepare("SELECT * FROM utilisateur WHERE email = ?");
$request->bind_param("s", $email);
$request->execute();

// Obtenir le résultat de la requête
$result = $request->get_result();

// Fermer la requête préparée
$request->close();

// Récupérer la première ligne du résultat (la ligne correspondant à l'utilisateur avec cet email)
$reponse = $result->fetch_assoc();

// Vérifier si l'utilisateur n'existe pas
if ($result->num_rows === 0) {

    $data = ["reponse" => "n'existe pas", "check" => false];

} elseif (password_verify($password, $reponse["password"])) {

    // Si le mot de passe est correct, générer un nouveau token
    $sql = "UPDATE utilisateur SET token=? WHERE id = ?";
    $request = $db->prepare($sql);

    // Générer un token unique (32 octets convertis en une chaîne hexadécimale)
    $token = bin2hex(random_bytes(32));

    // Lier les paramètres et exécuter la requête pour mettre à jour le token
    $request->bind_param("si", $token, $reponse["id"]);
    $request->execute();
    $request->close();

    // Stocker le token dans un cookie avec une durée de vie de 6000 secondes (10 minutes)
    setcookie("token", $token, time() + 6000, "/");

    // Répondre avec un succès
    $data = ["reponse" => "success", "check" => true];
    
} else {
    // Si le mot de passe est incorrect
    $data = ["reponse" => "mauvais mot de passe", "check" => false];
}

// Envoyer la réponse au format JSON
echo json_encode($data);
?>
