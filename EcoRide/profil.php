<?php
session_start();
// Vérification de la session utilisateur (l'utilisateur doit être connecté)
if (!isset($_SESSION['user'])) {
    die("Veuillez vous connecter pour accéder à votre profil." . " <a href='connexion.php'>Se connecter</a>");
}
// Connexion à la base de données

include 'includes/connect.php';
include 'includes/header.php';

?>

<body>
    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            startOrStopCovoit()
        });
    </script> -->
    <h1>Mon Profil</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="<?= $_SESSION['user']['photo'] ?>" alt="Photo de profil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
            </div>
            <div class="col-md-8">
                <h2><?= $_SESSION['user']['nom'] ?> <?= $_SESSION['user']['prenom'] ?></h2>
                <p>Email : <?= $_SESSION['user']['email'] ?></p>
                <p>Téléphone : <?= $_SESSION['user']['telephone'] ?></p>
                <p>Adresse : <?= $_SESSION['user']['adresse'] ?></p>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <h2>Mes Trajets Réservés</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Lieu de départ</th>
                    <th>Lieu d'arrivée</th>
                    <th>Nombre de places réservées </th>
                    <?php
                    // Requête pour récupérer le libelle  de l'administrateur
                    $sql = "SELECT Id_role FROM role WHERE libelle = 'admin'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Vérification si l'utilisateur est un administrateur
                    if ($admin) { ?>
                        <th> avis</th>
                    <?php } else { ?>
                        <a href="dashboard.php" class="btn btn-primary">accéder au dashboard </a>
                    <?php }
                    //requete sql pour insérer les avis sur l'utilisateur
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':Id_utilisateur', $_SESSION['user']['Id_utilisateur']);

                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Requête pour récupérer les trajets réservés par l'utilisateur
                $Id_utilisateur = $_SESSION['user']['Id_utilisateur'];
                $sql = "SELECT c.date_depart, c.heure_depart, c.lieu_depart, c.lieu_arrivee, r.places_reserves, c.Id_covoiturage, r.Id_utilisateur
                        FROM reservation AS r
                        JOIN covoiturage AS c ON r.Id_covoiturage = c.Id_covoiturage
                        WHERE r.Id_utilisateur = :Id_utilisateur";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':Id_utilisateur', $Id_utilisateur);
                $stmt->execute();
                $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($reservations as $reservation) { ?>
                    <tr>
                        <td><?= $reservation['date_depart'] ?> </td>
                        <td><?= $reservation['heure_depart'] ?> </td>
                        <td><?= $reservation['lieu_depart'] ?></td>
                        <td><?= $reservation['lieu_arrivee'] ?> </td>
                        <td><?= $reservation['places_reserves'] ?></td>
                        <td><a href="avis.php?Id_utilisateur=<?= $reservation['Id_utilisateur'] ?>" class="btn btn-primary">Donner un avis</a></td>
                    </tr>
                <?php }
                ?>

            </tbody>
        </table>
    </div>

    <div class=" container mt-4">
        <h2>Mes Trajets Proposés</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Lieu de départ</th>
                    <th>Lieu d'arrivée</th>
                    <th>Nombre de places disponibles</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Requête pour récupérer les trajets proposés par l'utilisateur
                $Id_utilisateur = $_SESSION['user']['Id_utilisateur'];
                $sql = "SELECT c.date_depart,c.heure_depart,c.lieu_depart,c.lieu_arrivee,c.nb_place,c.Id_covoiturage FROM covoiturage AS c
                    JOIN voiture v ON v.Id_marque = c.Id_voiture
                    JOIN utilisateur u ON u.Id_utilisateur = v.Id_utilisateur
                    WHERE u.Id_utilisateur = $Id_utilisateur";
                // $stmt->bindValue(':Id_utilisateur', $Id_utilisateur);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Boucle sur les trajets
                foreach ($trajets as $trajet) { ?>
                    <tr>
                        <td> <?= $trajet['date_depart'] ?> </td>
                        <td> <?= $trajet['heure_depart'] ?> </td>
                        <td> <?= $trajet['lieu_depart'] ?> </td>
                        <td> <?= $trajet['lieu_arrivee'] ?> </td>
                        <td> <?= $trajet['nb_place'] ?> </td>
                        <td><button><a id="<?= $trajet['Id_covoiturage'] ?>" class="start_cov">Démarrer</a></button></td>
                        <!-- TODO Crée et executer la fonction javascript pour demarrer(changer en arreter trajet) le trajet et envoyer un mail aux participant du covoiturage-->
                        <?php
                        // $emails = "SELECT email FROM reservation AS r
                        //            JOIN utilisateur AS u ON u.Id_utilisateur=r.Id_reservation";
                        // $stmt = $conn->prepare($emails);
                        // $stmt->execute();
                        // $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        // var_dump($emails);

                        $to = "test@mailhog.local";
                        $subject = "Hey, I’m Pi Hog Pi!";
                        $body = "Hello, MailHog!";
                        $headers = "From: pihogpi@kinsta.com" . "\r\n";
                        mail($to, $subject, $body, $headers);
                        // foreach ($emails as $email) {
                        //     // Envoi d'un email à chaque participant du covoiturage
                        //     $to = $email;
                        //     $subject = "Trajet démarré";
                        //     $message = "Le trajet que vous avez réservé a été démarré.";

                        //     mail($to, $subject, $message);
                        // }

                        ?>
                        <script>

                        </script>
                    </tr>
                    <?php }
                    ?>+
            </tbody>
        </table>
    </div>
    <div class="container mt-4 display-flex justify-content-center align-items-center flex-wrap">
        <div>
            <h3>
                <a href="ajout_voiture.php" class="btn btn-success"> Conducteur ? Ajouter une voiture </a></p>
            </h3>
        </div>
        <div>
            <h3>
                <a href="ajout_covoiturage.php" class="btn btn-success"> Ajouter un nouveau trajet </a></p>
            </h3>
        </div>
    </div>
    <div class="container mt-4">
        <h2>Modifier mes informations</h2>
        <form action="modifier_profil.php" method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($_SESSION['user']['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($_SESSION['user']['prenom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="scripts/gestion_covoiturage/script.js"></script>
</body>

</html>
<?php
require_once 'includes/footer.php';
