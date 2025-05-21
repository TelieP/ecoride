<?php
require_once 'includes/connect.php';
include_once 'includes/header.php'; ?>
<h1>LISTE DES COVOITURAGES DISPONIBLES </h1>
<?php
// Requête pour récupérer les trajets disponibles
$sql = "SELECT c.date_depart, c.heure_depart, c.lieu_depart, c.lieu_arrivee, c.nb_place, c.prix_personne
        FROM covoiturage AS c
        WHERE c.nb_place > 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-4">
    <h2>Trajets Disponibles</h2>

    <?php
    foreach ($trajets as $trajet) { ?>
        <tr>
            <td> <?= $trajet['date_depart'] ?> </td>
            <td> <?= $trajet['heure_depart'] ?> </td>
            <td> <?= $trajet['lieu_depart'] ?> </td>
            <td> <?= $trajet['lieu_arrivee'] ?> </td>
            <td> <?= $trajet['nb_place'] ?> </td>
            <td><?= $trajet['prix_personne'] ?></td>
        <?php } ?>
        </tr>
</div>
<?php
include_once('includes/footer.php');
?>