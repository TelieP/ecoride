<?php
require_once('includes/header.php');
require_once('includes/connect.php');
?>

<?php
session_start();
if (!isset($_SESSION['user'])) {
    die("Veuillez vous connecter pour ajouter une voiture." . " <a href='connexion.php'>Se connecter</a>");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $date_mise_en_circulation = $_POST['date_mise_en_circulation'];
    $immatriculation = $_POST['immatriculation'];
    $energie = $_POST['energie'];
    $preferences = $_POST['preferences'];

    $sql = "INSERT INTO voiture (Id_utilisateur, Id_marque, modele, date_premiere_immatriculation, immatriculation, energie) 
            VALUES (:Id_utilisateur, :marque, :modele, :date_mise_en_circulation, :immatriculation, :energie)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':Id_utilisateur', $_SESSION['user']['Id_utilisateur'], PDO::PARAM_INT);
    $stmt->bindParam(':marque', $marque, PDO::PARAM_STR);
    $stmt->bindParam(':modele', $modele, PDO::PARAM_STR);
    $stmt->bindParam(':date_mise_en_circulation', $date_mise_en_circulation, PDO::PARAM_STR);
    $stmt->bindParam(':immatriculation', $immatriculation, PDO::PARAM_STR);
    $stmt->bindParam(':energie', $energie, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Voiture ajoutée avec succès !</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'ajout de la voiture.</div>";
    }
}

?>
<div class="container mt-4">
    <h1>Ajouter une voiture</h1>
    <form action="" method="post">
        <div class="col-auto">
            <label for="marque">Marque</label>
            <select name="marque" id="marque" required>
                <?php
                // Requête pour récupérer les marques de voiture
                $stmt = $conn->query("SELECT * FROM marque");
                foreach ($stmt as $row) {
                    echo "<option value='" . $row['Id_marque'] . "'>" . $row['libelle'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <label for="modele">Modèle</label>
            <input type="text" name="modele" id="modele" placeholder="Modèle" required>
        </div>
        <div class="col-auto">
            <label for="date_mise_en_circulation">Date de mise en circulation</label>
            <input type="date" name="date_mise_en_circulation" id="date_mise_en_circulation" placeholder="JJ/MM/AAAA" required>
        </div>
        <div class="col-auto">
            <label for="immatriculation">Immatriculation</label>
            <input type="text" name="immatriculation" id="immatriculation" placeholder="Immatriculation" required>
        </div>
        <div class="col-auto">
            <label for="energie">Énergie</label>
            <select name="energie" id="energie" required>
                <option value="essence">Essence</option>
                <option value="diesel">Diesel</option>
                <option value="electrique">Électrique</option>
                <option value="hybride">Hybride</option>
            </select>
        </div>

        <div class="col-auto">
            <label for="preferences">Préférences</label></br>
            <select name="preferences" id="preferences" required>
                <option value="fumeur">Fumeur</option>
                <option value="non_fumeur">Non fumeur</option>
                <option value="animaux">Animaux</option>
                <option value="pas_animaux">Pas d'animaux</option>
                <option value="musique">Musique</option>
                <option value="pas_musique">Pas de musique</option>
                <option value="autre">Autre</option>
            </select></br></br>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>

</div>






</form>
</div>
<?php
require_once('includes/footer.php');


?>