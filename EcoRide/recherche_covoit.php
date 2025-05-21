<?php
// Démarrer la session pour récupérer les données de l'utilisateur (si nécessaire)
session_start();

// Inclure la configuration pour la connexion à la base de données
include('includes/connect.php');

// Variables pour stocker les résultats de recherche
$covoiturages = [];

// Vérifier si le formulaire de recherche a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire de recherche
    $ville_depart = $_POST['ville_depart'] ?? '';
    $ville_arrivee = $_POST['ville_arrivee'] ?? '';
    $date_depart = $_POST['date_depart'] ?? '';

    // Préparer la requête de recherche
    $query = "SELECT * FROM covoiturage WHERE 1=1";

    // Ajouter des conditions à la requête en fonction des critères de recherche
    if (!empty($ville_depart)) {
        $query .= " AND lieu_depart LIKE :ville_depart";
    }
    if (!empty($ville_arrivee)) {
        $query .= " AND lieu_arrivee LIKE :ville_arrivee";
    }
    if (!empty($date_depart)) {
        $query .= " AND date_depart >= :date_depart";
    }

    // Exécuter la requête
    try {
        $stmt = $conn->prepare($query);

        // Lier les paramètres si nécessaire
        if (!empty($ville_depart)) {
            $stmt->bindValue(':lieu_depart', '%' . $ville_depart . '%');
        }
        if (!empty($ville_arrivee)) {
            $stmt->bindValue(':lieu_arrivee', '%' . $ville_arrivee . '%');
        }
        if (!empty($date_depart)) {
            $stmt->bindValue(':date_depart', $date_depart);
        }

        $stmt->execute();
        $covoiturages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur de recherche : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche des Covoiturages</title>
</head>

<body>

    <h1>Recherche des Covoiturages</h1>

    <form method="POST" action="">
        <label for="ville_depart">Ville de départ :</label>
        <input type="text" id="ville_depart" name="ville_depart" value="<?php echo htmlspecialchars($ville_depart ?? ''); ?>"><br>

        <label for="ville_arrivee">Ville d'arrivée :</label>
        <input type="text" id="ville_arrivee" name="ville_arrivee" value="<?php echo htmlspecialchars($ville_arrivee ?? ''); ?>"><br>

        <label for="date_depart">Date de départ (format YYYY-MM-DD HH:MM:SS) :</label>
        <input type="text" id="date_depart" name="date_depart" value="<?php echo htmlspecialchars($date_depart ?? ''); ?>"><br>

        <button type="submit">Rechercher</button>
    </form>

    <?php if (!empty($covoiturages)): ?>
        <h2>Résultats de la recherche :</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ville de départ</th>
                    <th>Ville d'arrivée</th>
                    <th>Date de départ</th>
                    <th>Places disponibles</th>
                    <th>Conducteur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($covoiturages as $covoiturage): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($covoiturage['id']); ?></td>
                        <td><?php echo htmlspecialchars($covoiturage['ville_depart']); ?></td>
                        <td><?php echo htmlspecialchars($covoiturage['ville_arrivee']); ?></td>
                        <td><?php echo htmlspecialchars($covoiturage['date_depart']); ?></td>
                        <td><?php echo htmlspecialchars($covoiturage['places_disponibles']); ?></td>
                        <td>
                            <?php
                            // Récupérer le nom du conducteur
                            $stmt = $pdo->prepare("SELECT nom FROM utilisateurs WHERE id = :conducteur_id");
                            $stmt->bindValue(':conducteur_id', $covoiturage['conducteur_id']);
                            $stmt->execute();
                            $conducteur = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo htmlspecialchars($conducteur['nom']);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>Aucun covoiturage trouvé pour ces critères.</p>
    <?php endif; ?>

</body>

</html>