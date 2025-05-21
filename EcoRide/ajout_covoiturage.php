<?php
session_start();
require_once 'includes/connect.php';
require_once 'includes/header.php';

if (isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        $depart = htmlspecialchars($_POST['lieu_depart']);
        $arrivee = htmlspecialchars($_POST['lieu_arrivee']);
        $date = htmlspecialchars($_POST['date_depart']);
        $heure = htmlspecialchars($_POST['heure_depart']);
        $nb_place = htmlspecialchars($_POST['nb_place']);
        $statut = htmlspecialchars($_POST['statut']);
        $prix = htmlspecialchars($_POST['prix']);
        $voiture = htmlspecialchars($_POST['voiture']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $stmt = $conn->prepare("INSERT INTO `covoiturage` (`date_depart`, `heure_depart`, `lieu_depart`, `lieu_arrivee`, `statut`, `nb_place`, `prix_personne`,Id_voiture) VALUES (:date_depart, :heure_depart, :lieu_depart, :lieu_arrivee, :statut, :nb_place, :prix, :Id_voiture)");
            $stmt->bindParam(':lieu_depart', $depart, PDO::PARAM_STR);
            $stmt->bindParam(':lieu_arrivee', $arrivee, PDO::PARAM_STR);
            $stmt->bindParam(':date_depart', $date, PDO::PARAM_STR);
            $stmt->bindParam(':heure_depart', $heure, PDO::PARAM_STR);
            $stmt->bindParam(':nb_place', $nb_place, PDO::PARAM_INT);
            $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
            $stmt->bindParam(':prix', $prix, PDO::PARAM_INT);
            $stmt->bindParam(':Id_voiture', $voiture, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Covoiturage ajouté avec succès";
            } else {
                echo "Erreur lors de l'ajout du covoiturage";
            }
        }
    }
} else {
    die("Veuillez vous connecter pour ajouter un covoiturage." . " <a href='connexion.php'>Se connecter</a>");
}
?>
<h1>Ajouter un covoiturage</h1></br>
<form class="form-group" method="post">
    <div>
        <label for="Ville de départ"> Ville de départ</label>
        <input type="text" name="lieu_depart" required>
    </div>
    <div>
        <label for="Ville d'arrivée">Ville d'arrivée</label>
        <input type="text" name="lieu_arrivee" required>
    </div>
    <div>
        <label for="Date départ">Date départ</label>
        <input type="date" name="date_depart" required>
    </div>
    <div>
        <label for="Heure départ">Heure départ</label>
        <input type="time" name="heure_depart" required>
    </div>
    <div>
        <label for=" Nombre de places"> Nombre de places</label>
        <input type="number" name="nb_place" required>
    </div>
    <div>
        <label for="voiture">Voiture</label>

        <select class="mb-2" name="voiture" id="voiture">
            <?php
            $UserId = $_SESSION['user']['Id_utilisateur'];
            $stmt = $conn->query("SELECT * FROM marque AS m
                    JOIN voiture AS v  ON v.Id_marque = m.Id_marque
                    JOIN utilisateur AS u ON u.Id_utilisateur = v.Id_utilisateur
                    WHERE u.Id_utilisateur = $UserId");
            foreach ($stmt as $row) {
                echo "<option value='" . $row['Id_marque'] . "'>" . $row['libelle'] . "</option>";
            }
            ?>
        </select>
    </div>
    <input type="hidden" id="statut" name="statut" value="disponible">

    <div>
        <label for="prix">Prix</label>
        <input type="number" name="prix" required><br>
    </div>
    <button type="submit">Ajouter</button>
</form>

<?php
require_once 'includes/footer.php';
?>