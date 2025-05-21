<?php
require_once 'includes/header.php';
require_once 'includes/connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Id_utilisateur = $_POST['Id_utilisateur'];
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE Id_utilisateur = :Id_utilisateur");
    $stmt->bindParam(':Id_utilisateur', $Id_utilisateur);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur) {
        $stmt = $conn->prepare("DELETE FROM utilisateur WHERE Id_utilisateur = :Id_utilisateur");
        $stmt->bindParam(':Id_utilisateur', $Id_utilisateur);
        if ($stmt->execute()) {
            echo "Utilisateur supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'utilisateur.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }
}
