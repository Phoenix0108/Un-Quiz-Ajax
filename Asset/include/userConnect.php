<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nomUtilisateur = $_POST["nom_utilisateur"];
    $motDePasse = $_POST["mot_de_passe"];

    // Vérifier les données dans la base de données
    $requete = "SELECT * FROM Utilisateur WHERE NomUtilisateur = '$nomUtilisateur' AND MotDePasse = '$motDePasse'";
    $resultat = mysqli_query($connexion, $requete);

    if ($resultat) {
        // Vérification des données
        if (mysqli_num_rows($resultat) == 1) {
            // L'utilisateur est authentifié, rediriger vers la page suivante
            header("Location: page_suivante.php");
            exit();
        } else {
            // Nom d'utilisateur ou mot de passe incorrect
            $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        // Erreur de requête
        $erreur = "Erreur lors de la requête : " . mysqli_error($connexion);
    }
}
?>
