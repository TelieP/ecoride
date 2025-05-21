<?php


session_start();

// connexion à la base de données
require_once('../includes/connect.php');
require_once('../includes/header.php');



//if (!isset($_SESSION['id_utilisateur'])) {
//  header('Location: ../connexion.php'); // redirection vers la page de connexion si l'utilisateur n'est pas connecté
//exit();
//}

$user_id = $_SESSION["user"]['Id_utilisateur'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // traitement du formulaire losrque l'utilisateur soumet les informations

    // on récupère les données du formulaire
    $date_depart = $_POST['date_depart'];
    $lieu_depart = $_POST['lieu_depart'];
    $lieu_arrivee = $_POST['lieu_arrivee'];
    $prix = $_POST['prix_personne'];
    $nombre_place = $_POST['nb_place'];
    $heure_depart = $_POST['heure_depart'];

    // on insère les données dans la base de données
    $sql = "INSERT INTO `covoiturage` (`date_depart`,`heure_depart`,`lieu_depart`, `lieu_arrivee`,`nb_place`, `prix_personne` ) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam($date_depart, $heure_depart, $lieu_depart, $lieu_arrivee, $nombre_place, $prix);
    $stmt->execute();

    // on insere les données  de la voiture si elles sont présentes 

    if (isset($_POST['modele']) && isset($_POST['couleur']) && isset($_POST['immatriculation']) && isset($_POST['date_premiere_immatriculation']) && isset($_POST['energie'])) {

        $modele = $_POST['modele'];
        $couleur = $_POST['couleur'];
        $immatriculation = $_POST['immatriculation'];
        $date_premiere_immatriculation = $_POST['date_premiere_immatriculation'];
        $energie = $_POST['energie'];


        $sql_voiture = "INSERT INTO `voiture` ( `modele`,`immatriculation`, `energie`, `couleur`, `date_premiere_immatriculation` , `id_utilisateur` , `id_marque`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_voiture = $conn->prepare($sql_voiture);
        $stmt_voiture->bindParam($modele, $immatriculation, $energie, $couleur, $date_premiere_immatriculation,  $id_utilisateur, $id_marque);
        $stmt_voiture->execute();
    }
    // on redirige après avoir  ajouté le trajet et la voiture
    header('Location: confirmation_ajout_trajet.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Création d'un trajet de covoiturage</title>
</head>

<body>

    <h1> Créer un nouveau trajet de covoitutrage</h1>
    <form class="form-group" method="POST">
        <h2> informations sur le trajet de covoiturage </h2>
        <label for="date_depart"> Date de départ </label>
        <input type="date" name="date_depart" id="date_depart" required> <br><br>
        <label for="lieu_depart"> Lieu de départ </label>
        <input type="text" name="lieu_depart" id="lieu_depart" required> <br><br>
        <label for="lieu_arrivee"> Lieu d'arrivée </label>
        <input type="text" name="lieu_arrivee" id="lieu_arrivee" required> <br><br>
        <label for="prix_personne"> Prix par personne </label>
        <input type="number" name="prix_personne" id="prix_personne" required> <br><br>
        <label for="nb_place"> Nombre de places disponibles </label>
        <input type="number" name="nb_place" id="nb_place" required> <br><br>
        <label for="heure_depart"> Heure de départ </label>
        <input type="time" name="heure_depart" id="heure_depart" required> <br><br>


        <!-- Code à vérifier  -->

        <!-- <h2> Ajouter une voiture </h2>
        <label for="marque"> Marque </label>

        <select name="marque" id="marque"> -->
        //<?php
            // $query = "SELECT `Id_marque` AND `libelle`  FROM `marque` ";
            // $stmt_marque = $conn->prepare($query);
            // $stmt_marque->execute();
            // $marques = $stmt_marque->fetchAll(PDO::FETCH_ASSOC);

            // foreach ($marques as $marque) {
            //     echo "<option value=" . $marque['Id_marque'] . ">" . $marque['nom'] . "</option>";
            // }
            // var_dump($query);

            // 
            // 
            ?>
        <!-- <label for="modele"> Modèle </label>
                <input type="text" name="modele" id="modele"> <br><br>
                <label for="couleur"> Couleur </label>
                <input type="text" name="couleur" id="couleur"> <br><br>
                <label for="immatriculation"> Immatriculation </label>
                <input type="text" name="immatriculation" id="immatriculation"> <br><br>
             <label for="date_premiere_immatriculation"> Date de première immatriculation </label>
             <input type="date" name="date_premiere_immatriculation" id="date_premiere_immatriculation"> <br><br>
                <label for="energie"> Energie </label>
             <input type="text" name="energie" id="energie"> <br><br> -->

        <button type="submit"> Créer le trajet </button>

    </form>

</body>

</html>
<?php
require_once('../includes/footer.php');
?>