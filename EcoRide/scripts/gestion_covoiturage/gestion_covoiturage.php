<?php

// S'assurer d'envoyer du JSON
header('Content-Type: application/json');

require_once '../../includes/connect.php';

if (isset($_POST['startOrStop']) && isset($_POST['idTrajet'])) {
  // On récupère "D" ou "T" et l'id du trajet
  $startOrStop = $_POST['startOrStop'];
  $idTrajet = $_POST['idTrajet'];
  // On met à la jour la colonne statut de la table covoiturage de la DB ('dispobible' ou 'en cours')
  $query = "UPDATE covoiturage SET statut = :statut WHERE id = :id";
  if ($startOrStop == 'D') {
    // Le vocovoit a démarré
    $sql = "UPDATE covoiturage
      SET statut = REPLACE(statut, 'disponible', 'en cours')
      WHERE Id_covoiturage = :idTrajet";
  } else {
    // Le covoit est terminé
    $sql = "UPDATE covoiturage  
      SET statut = REPLACE(statut, 'en cours', 'terminé')
      WHERE Id_covoiturage = :idTrajet";
  }
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':idTrajet', $idTrajet);
  $stmt->execute();
  // On revoie au JS "D" ou "T"
  echo json_encode($startOrStop);
}
