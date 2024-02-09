<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';
    
    // Collecte des données du formulaire
    $name = $_POST['nom'];
    $gender = $_POST['gender'];
    $color = $_POST['color'];
    $pet = implode(', ', $_POST['pet']);


    if (empty($name) || empty($gender) || empty($color) || empty($pet)) {
        echo "Toutes les cases sont nécessaires";
    } else {
        $sql = "INSERT INTO feedback (name, gender, color, pet) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Liaison des valeurs aux paramètres avec les types corrects
        $stmt->bind_param("ssss", $name, $gender, $color, $pet);

        if ($stmt->execute()) {
            // Rediriger après une opération réussie (redirection sûre via header)
            header('Location: ../../merci.html');
            exit();
        } else {
            // Afficher un messgender d'erreur générique (sécurisé)
            echo htmlspecialchars("$name, Une erreur s'est produite lors du traitement de votre demande. Veuillez réessayer plus tard.", ENT_QUOTES, 'UTF-8');
        }

        $stmt->close();
        $conn->close();
    }
}
?>
