<?php
session_start();

// Connexion à la base de données
require_once 'includes/connect.php';
require_once 'includes/header.php';

// Vérification de la session utilisateur (l'utilisateur doit être connecté)
if (!isset($_SESSION['user'])) {
    die("Veuillez vous connecter pour réserver." . " <a href='connexion.php'>Se connecter</a>");
}
// var_dump($_GET);
// Récupérer l'ID du trajet à réserver
if (!isset($_GET['id'])) {
    die("ID de trajet manquant.");
}

$cov_id = $_GET['id'];

// Récupérer les informations du trajet

$sql = "SELECT c.Id_covoiturage, c.heure_depart, c.date_depart, c.nb_place, 
            c.heure_arrivee, u.nom, u.prenom, v.modele, v.immatriculation, c.prix_personne, c.lieu_depart, c.lieu_arrivee,u.photo
                FROM covoiturage AS c
                JOIN voiture AS v ON v.Id_voiture = c.Id_voiture
                JOIN utilisateur AS u ON u.Id_utilisateur = v.Id_voiture
                WHERE  c.Id_covoiturage = :cov_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':cov_id' => $cov_id]);
$reserve = $stmt->fetch(PDO::FETCH_ASSOC);
// detail du trajet qui va etre reservé 
// var_dump($reserve);
?>
<div class="list-group mt-4">

    <h2 class="text-center">Détails du trajet</h2>
    <!-- <h3 class="text-center">Réservation de covoiturage</h3> -->
    <div class="list-group-item list-group-item-action">
        <h5><i class="bi bi-geo-fill"></i> De <?= htmlspecialchars($reserve['lieu_depart']) ?></br><i class="bi bi-arrow-down"></i></br> <i class="bi bi-geo-fill"></i> à <?= htmlspecialchars($reserve['lieu_arrivee']) ?></h5>
        <p><i class="bi bi-calendar3"></i> Date : <?= date("d/m/Y", timestamp: strtotime($reserve['date_depart']))  ?> à <?= $reserve['heure_depart'] ?></p>
        <p><i class="bi bi-person-workspace"></i> Conducteur : <?= htmlspecialchars($reserve['nom']) ?> <?= htmlspecialchars($reserve['prenom']) ?></p>
        <img src="<?= htmlspecialchars($reserve['photo']) ?>" alt="Conducteur" class="img-fluid" style="width: 75px; height: 75px; border-radius: 50%;">
        <p><i class="bi bi-car-front-fill"></i> Véhicule : <?= htmlspecialchars($reserve['modele']) ?> </p>
        <p><i class="bi bi-cash-coin"></i> Prix : <?= number_format($reserve['prix_personne'], 2) ?> €</p>
    </div>
    <?php
    if (!$reserve) {
        die("Trajet non trouvé.");
    }

    // Vérifier la soumission du formulaire de réservation
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $places_reserves = $_POST['places_reserves'];
        // var_dump($_SESSION);
        // Vérifier que le nombre de sièges est disponible
        if ($places_reserves > $reserve['nb_place']) {
            die("Nombre de sièges insuffisant.");
        }

        // Réserver les sièges
        $Id_utilisateur = $_SESSION['user']['Id_utilisateur'];
        $sql = "INSERT INTO reservation (Id_covoiturage, Id_utilisateur, places_reserves) VALUES (:Id_covoiturage, :Id_utilisateur, :places_reserves)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':Id_covoiturage', $cov_id);
        $stmt->bindValue(':Id_utilisateur', $Id_utilisateur);
        $stmt->bindValue(':places_reserves', $places_reserves);
        $stmt->execute();

        // Mettre à jour le nombre de sièges disponibles
        $sql = "UPDATE covoiturage SET nb_place = nb_place - :places_reserves WHERE Id_covoiturage = :Id_covoiturage";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':places_reserves', $places_reserves);
        $stmt->bindValue(':Id_covoiturage', $cov_id);
        $stmt->execute();

        // Rediriger vers la page de confirmation ou d'accueil
        echo "<div class='alert alert-success'>Réservation réussie !</div>";
        echo "<a href='index.php' class='btn btn-primary'>Retour à l'accueil</a>";
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>Réservation de Trajet</title>
    </head>

    <body>
        <h1>Réserver le trajet</h1>
        <form method="post">
            <label for="places_reserves">Nombre de sièges à réserver:</label>
            <input type="number" name="places_reserves" min="1" max="<?= $reserve['nb_place'] ?>" required>
            <div class="list-group-item list-group-item-action">
                <button type="submit" class="btn btn-success">Reserver</button>
            </div>

        </form>

    </body>

    </html>

    <?= require_once('includes/footer.php'); ?>