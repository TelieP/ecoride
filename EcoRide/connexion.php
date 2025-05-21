<?php
session_start();
require_once 'includes/header.php';
require_once 'includes/connect.php';

if (!empty($_POST)) {

    $email = $_POST["email"];
    $password = $_POST['mot_de_passe'];

    if (isset($email, $password)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Adresse email ou mot de passe  invalide : ' . $email);
        }
        $sql = "SELECT * FROM `utilisateur` WHERE `email` = :email";
        $query = $conn->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            die('Utilisateur inconnu');
        }
        if (!password_verify($password, $user['password'])) {
            echo '<script type="text/javascript">window.alert("Adresse email ou mot de passe  invalide ");</script>';
        } else {
            $_SESSION['user'] = $user;
            header('Location: index.php');
        }
    }
}
?>
<h1>Connexion</h1>

<form method="post" class="form-group"><br>
    <div class="mb-3 text-center" id="form-controler">
        <div class="mb-3">
            <label for="email">Adresse email</label><br>
            <input type="email" name="email" id="email" required placeholder="Adresse email">
        </div>
        <div class="mb-3">
            <label for="mot_de_passe">Mot de passe</label><br>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required placeholder="Mot de passe">
        </div>
        <button type="submit" class="btn btn-primary mb-3">Se connecter</button><br>
        <a href="inscription.php">Pas encore inscrit ?</a><br>
    </div>
</form>
<?php
require_once 'includes/footer.php';
?>