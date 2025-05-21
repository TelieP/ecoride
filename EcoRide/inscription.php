<?php
session_start();
require_once 'includes/header.php'; // Inclusion du header
require_once 'includes/connect.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['pass'], PASSWORD_ARGON2ID);
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $naissance = $_POST['naissance'];
    $photo = $_POST['photo'];
    $pseudo = $_POST['pseudo'];
    $id_role = "user";
    try {
        $stmt = $conn->prepare("SELECT * FROM `utilisateur` WHERE email = :email"); // on vérifie que l'email n'existe pas dejà en base de données
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
            echo "Email déjà utilisé.";
        } else {
            // Ajout de l'utilisateur en BDD
            $stmt = $conn->prepare("
                INSERT INTO `utilisateur` (`nom`, `prenom`, `email`, `password`, `telephone`, `adresse`, `date_naissance`, `photo`, `pseudo`) 
                VALUES (:nom, :prenom, :email, :password, :telephone, :adresse, :naissance, :photo, :pseudo)
            ");
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $stmt->bindParam(':naissance', $naissance, PDO::PARAM_STR);
            // Chemin photo en fonction de la session
            $cheminPhoto = 'images';
            $cheminDossier = '';
            if (!$_SESSION) { // L'utilsateur n'est pas connecté et souhaite s'inscire : c'est un conducteur
                $cheminDossier = '/conducteurs/';
            } else {
                $cheminDossier = '/employes/';
            }
            if (isset($_FILES['photo'])) {
                $photo = $_FILES['photo']['name'];
                $cheminPhoto .= "/$cheminDossier/$photo";
                move_uploaded_file($_FILES['photo']['tmp_name'], $cheminPhoto);
            } else {
                $photo = 'une erreur est survenue';
            }
            $stmt->bindParam(':photo', $cheminPhoto, PDO::PARAM_STR);
            $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            if ($stmt->execute()) {
                // On récupère l'id de l'utilisateur inséré et l'id du rôle posté
                $idUtilisateur = $conn->lastInsertId();
                $idRole = $_POST['Id_role'];
                // On insère dans la table *possede* ces 2 informations
                $stmt = $conn->prepare('INSERT INTO `possede` (Id_role, Id_utilisateur) ' .
                    'VALUES (:id_role, :id_utilisateur)');
                $stmt->bindParam(':id_role', $idRole, PDO::PARAM_INT);
                $stmt->bindParam(':id_utilisateur', $idUtilisateur, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    echo "Inscription réussie !";
                    if ('Id_role' === 2) {
                        header('Location: profil.php');
                    } else {
                        header('Location: profil.php');
                    }
                    //header('Location: profil.php');
                    exit();
                } else {
                    echo "Erreur lors de l'inscription.";
                }
            } else {
                echo "Erreur lors de l'inscription.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<div class="container col-mb-3 " style="width: 100%;  margin-top: 260px; margin-bottom: 400px;">
    <form class="form-group text-white" method="post" enctype="multipart/form-data">
        <h2>Inscription</h2>
        <input id="user" name="user" type="hidden" value="2">
        Nom: <input type=" text" name="nom" required>
        Prénom: <input type="text" name="prenom" required>
        Email: <input type="email" name="email" required>
        Mot de passe: <input type="password" name="pass" required>
        Téléphone: <input type="number" name="telephone" required>
        Adresse: <input type="text" name="adresse" required>
        Date de naissance: <input type="date" name="naissance" required>
        Photo: <input type="file" name="photo" accept="image/png , image/jpeg">
        Pseudo: <input type="text" name="pseudo" required>

        <?php
        $stmt = $conn->prepare("SELECT Id_role, libelle FROM role");
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$_SESSION) { ?>
            <input type="hidden" id="Id_role" name="Id_role" value="2">
        <?php } else { ?>
            <label for="Id_role">Role :</label>
            <select name="Id_role" id="Id_role">
                <?php
                foreach ($roles as $role) {
                ?>
                    <option value="<?= $role['Id_role']; ?>"><?= $role['libelle']; ?></option>
                <?php
                }
                ?>
            </select>
        <?php  } ?>

        <button type="submit">S'inscrire</button>
        <a href="connexion.php">Déjà inscrit ?</a>
    </form>
</div>
<?php
require_once 'includes/footer.php'; // Inclusion du footer
