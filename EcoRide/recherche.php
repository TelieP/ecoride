<?php
// Démarrer la session pour récupérer les données de l'utilisateur (si nécessaire)
session_start();

// Inclure la configuration pour la connexion à la base de données
require_once('includes/connect.php');
require_once('includes/header.php');
?>

<body>
    <!-- debut_filtres pour trajests  -->
    <div class="container">
        <div class="row">
            <div class="col lg-4">
                <fieldset class="m-5">
                    <!-- Checkbox pour le trajet ecolo ou non -->
                    <!-- L'événement onchange permet d'appeler la fonction getEnvironmentallyFriendlyCarSharing() du fichier filter.js -->
                    <input type="checkbox" id="ecological" name="ecological" onchange="getEnvironmentallyFriendlyCarSharing()" />
                    <label for="ecological">Trajet écologique</label>
                </fieldset>
            </div>
            <div class="col">
                <fieldset class="m-5">
                    <!-- Checkbox pour le trajet du moins chers au plus chere -->
                    <!-- L'événement onchange permet d'appeler la fonction getlowprice() du fichier filter.js -->
                    <input type="checkbox" id="lowprice" name="lowprice" onchange="getlowprice()">
                    <label id="labellowprice" for="lowprice">Tri du moins cher au plus cher</label>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- fin_filtres pour trajets -->
    <h1>Rechercher un Covoiturage</h1>
    <div class="row g-3">
        <form action="" method="GET" class="form-group  text-white p-2 w-50 mx-auto">
            <div class="row g-3">
                <div class="col">
                    <label for="depart">Ville de départ </label>
                    <input type="text" class="form-control" id="depart" name="depart" required placeholder="ville de depart">
                </div>
                <div class="col">
                    <label for="arrivee">Ville d'arrivée </label>
                    <input type="text" class="form-control" id="arrivee" name="arrivee" required placeholder="ville d'arrivée">
                </div>
                <div class="col">
                    <label for="date">Date du trajet </label>
                    <input type="date" class="form-control" id="date" name="date" required placeholder="date">
                </div>
                <button type="submit" class="btn btn-primary mb-3">Rechercher</button>
            </div>
        </form>
    </div>

    <?php

    // Si des paramètres sont envoyés via GET

    if (isset($_GET['depart']) && isset($_GET['arrivee']) && isset($_GET['date'])) {
        $depart = $_GET['depart'];
        $arrivee = $_GET['arrivee'];
        $date = $_GET['date'];

        // Requête SQL pour rechercher les trajets
        // $sql = "SELECT * FROM covoiturage WHERE lieu_depart LIKE :depart AND lieu_arrivee LIKE :arrivee AND  DATE(date_depart) LIKE :date AND nb_place > 0";
        $sql = "SELECT c.Id_covoiturage, c.heure_depart, c.date_depart, c.nb_place, u.photo,
            c.heure_arrivee, u.nom, u.prenom, v.modele, v.immatriculation, c.prix_personne, c.lieu_depart, c.lieu_arrivee
                FROM covoiturage AS c
                JOIN voiture AS v ON v.Id_voiture = c.Id_voiture
                JOIN utilisateur AS u ON u.Id_utilisateur = v.Id_voiture
                WHERE  lieu_depart = :depart AND lieu_arrivee = :arrivee AND  DATE(date_depart) = :date AND nb_place > 0";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':depart',  $depart);
        $stmt->bindValue(':arrivee',  $arrivee);
        $stmt->bindValue(':date', $date);

        $stmt->execute();
        $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($trajets);

        if (count($trajets) > 0): ?>
            <div class="list-group mt-4">
                <?php foreach ($trajets as $trajet): ?>
                    <div class="list-group-item list-group-item-action" id="<?= $trajet['Id_covoiturage'] ?>">
                        <h5><i class="bi bi-geo-fill"></i> De <?= htmlspecialchars($trajet['lieu_depart']) ?></br><i class="bi bi-arrow-down"></i></br> <i class="bi bi-geo-fill"></i> à <?= htmlspecialchars($trajet['lieu_arrivee']) ?></h5>
                        <p><i class="bi bi-calendar3"></i> <?= date("d/m/Y", timestamp: strtotime($trajet['date_depart']))  ?> à <?= $trajet['heure_depart'] ?></p>
                        <p> <i class="bi bi-person-circle"></i></i> <?= htmlspecialchars($trajet['nom']) ?> <?= htmlspecialchars($trajet['prenom']) ?><img src="<?= htmlspecialchars($trajet['photo']) ?>" alt="Conducteur" class="img-fluid" style="width: 75px; height: 75px; border-radius: 50%;"></p>
                        <p><i class="bi bi-car-front-fill"></i> Véhicule : <?= htmlspecialchars($trajet['modele']) ?> </p>
                        <p><i class="bi bi-cash-coin"></i> Prix : <?= number_format($trajet['prix_personne'], 2) ?> €</p>
                        <p><i class="bi bi-person-check-fill"></i> Places restantes : <?= htmlspecialchars($trajet['nb_place']) ?></p>
                        <a href="reservation_cov.php?id=<?= $trajet['Id_covoiturage'] ?>" class="btn btn-success"><i class="fas fa-check"></i> Réserver</a>
                        <a href="reservation_cov.php?id=<?= $trajet['Id_covoiturage'] ?>" class="btn btn-success stretched-link"><i class="fas fa-check"></i> VOIR</a>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center mt-4"><i class="fas fa-exclamation-circle"></i> Aucun trajet trouvé</div>
        <?php endif; ?>
        </div>
    <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="scripts/filters/filter.js"></script>
</body>

<?= require_once('includes/footer.php');
