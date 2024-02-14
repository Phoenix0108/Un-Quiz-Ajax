<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomUtilisateur = $_POST["nom_utilisateur"];
    $email = $_POST["email"];
    $motDePasse = $_POST["mot_de_passe"];

    $verificationNomUtilisateur = "SELECT * FROM Utilisateur WHERE NomUtilisateur = '$nomUtilisateur'";
    $resultatNomUtilisateur = mysqli_query($connexion, $verificationNomUtilisateur);

    $verificationEmail = "SELECT * FROM Utilisateur WHERE Email = '$email'";
    $resultatEmail = mysqli_query($connexion, $verificationEmail);

    if (mysqli_num_rows($resultatNomUtilisateur) > 0) {

        $erreur = "Le nom d'utilisateur est déjà utilisé. Choisissez un autre nom d'utilisateur.";

    } elseif (mysqli_num_rows($resultatEmail) > 0) {

        $erreur = "L'adresse e-mail est déjà utilisée. Utilisez une autre adresse e-mail.";

    } else {
        
        $requeteInsertion = "INSERT INTO Utilisateur (NomUtilisateur, Email, MotDePasse) VALUES ('$nomUtilisateur', '$email', '$motDePasse')";

        if (mysqli_query($connexion, $requeteInsertion)) {
            
            header("Location: page_connexion.php");
            exit();

        } else {
            $erreur = "Erreur lors de l'insertion des données : " . mysqli_error($connexion);
        }
    }
}
?>
