<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomUtilisateur = $_POST["nom_utilisateur"];
    $motDePasse = $_POST["mot_de_passe"];


    $requete = "SELECT * FROM Utilisateur WHERE NomUtilisateur = '$nomUtilisateur' AND MotDePasse = '$motDePasse'";
    $resultat = mysqli_query($connexion, $requete);

    if ($resultat) {

        if (mysqli_num_rows($resultat) == 1) {

            header("Location: page_suivante.php");
            exit();

        } else {

            $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {

        $erreur = "Erreur lors de la requête : " . mysqli_error($connexion);
    }
}
?>
