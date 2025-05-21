
<?php
// session_start();
/**
 * @param string $email The email
 * @param string $password The password
 * @return boolean true if the connection is a success
 */
// public function login($email, $password): bool
// {
//     $user = $this->db->prepare('SELECT * FROM personnel WHERE email = ?', [$email], null, true);
//     if ($user) {
//         $passwordHash = $user->password;
//         if (password_verify($password, $passwordHash)) {
//             $_SESSION['auth']['id'] = $user->personnel_id;
//             $_SESSION['auth']['user'] = $user->name;
//             $_SESSION['auth']['role'] = $user->role_id;
//             return true;
//         }
//     }
//     return false;
// }
?>

    <?php
    // ma fonction php 

    // Démarre une session pour pouvoir utiliser $_SESSION

    function authenticate_user($username, $password)
    {
        // Exemple de données d'authentification (à remplacer par des données réelles ou une base de données)
        $valid_username = "admin";
        $valid_password = "12345"; // Utilisez ici un mot de passe haché dans une vraie application !

        // Vérification des informations d'identification
        if ($username === $valid_username && $password === $valid_password) {
            // L'utilisateur est authentifié, démarrons une session
            $_SESSION['username'] = $username;
            $_SESSION['authenticated'] = true;
            return true;
        } else {
            return false;
        }
    }

    // Traitement du formulaire de connexion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Authentification de l'utilisateur
        if (authenticate_user($username, $password)) {
            // Redirection vers la page protégée
            header("Location: protected_page.php");
            exit();
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }



    // fonctions pour l'admin du site 
    // Fonction pour supprimer un avis
    function supprimerAvis($conn, $Id_avis)
    {
        try {
            // Préparer la requête pour supprimer l'avis
            $stmt = $conn->prepare("DELETE FROM avis WHERE Id_avis = :Id_avis");
            $stmt->bindParam(':Id_avis', $Id_avis);
            $stmt->execute();
            echo "Avis supprimé avec succès.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    // Fonction pour afficher les avis
    function afficherAvis($conn)
    {
        try {
            // Préparer la requête pour récupérer les avis
            $stmt = $conn->query("SELECT * FROM avis WHERE statut = 'non modéré'");
            $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $avis;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    // fonction pour afficher les utilisateurs inscrits sur le site
    function afficherUtilisateurs($conn)
    {
        try {
            // Préparer la requête pour récupérer les utilisateurs
            $stmt = $conn->query("SELECT * FROM utilisateur");
            $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $utilisateurs;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    // Fonction pour afficher les covoiturages proposés par les utilisateurs
    function afficherCovoiturages($conn)
    {
        try {
            // Préparer la requête pour récupérer les covoiturages
            $stmt = $conn->query("SELECT * FROM covoiturage");
            $covoiturages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $covoiturages;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    // appel de la fonction pour afficher la liste des utilisateurs
    $utilisateurs = afficherUtilisateurs($conn);
    // fonction pour changer le role d'un utilisateur
    function changerRoleUtilisateur($conn, $Id_utilisateur, $nouveau_role)
    {
        try {
            // Préparer la requête pour mettre à jour le rôle de l'utilisateur
            $stmt = $conn->prepare("UPDATE utilisateur SET role = :role WHERE Id_utilisateur = :Id_utilisateur");
            $stmt->bindParam(':role', $nouveau_role);
            $stmt->bindParam(':Id_utilisateur', $Id_utilisateur);
            $stmt->execute();
            echo "Rôle de l'utilisateur mis à jour avec succès.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    // fonction pour changer le statut d'un covoiturage
    function changerStatutCovoiturage($conn, $Id_covoiturage, $nouveau_statut)
    {
        try {
            // Préparer la requête pour mettre à jour le statut du covoiturage
            $stmt = $conn->prepare("UPDATE covoiturage SET statut = :statut WHERE Id_covoiturage = :Id_covoiturage");
            $stmt->bindParam(':statut', $nouveau_statut);
            $stmt->bindParam(':Id_covoiturage', $Id_covoiturage);
            $stmt->execute();
            echo "Statut du covoiturage mis à jour avec succès.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    // fonction pour changer le statut d'un utilisateur
    function changerStatutUtilisateur($conn, $Id_utilisateur, $nouveau_statut)
    {
        try {
            // Préparer la requête pour mettre à jour le statut de l'utilisateur
            $stmt = $conn->prepare("UPDATE utilisateur SET statut = :statut WHERE Id_utilisateur = :Id_utilisateur");
            $stmt->bindParam(':statut', $nouveau_statut);
            $stmt->bindParam(':Id_utilisateur', $Id_utilisateur);
            $stmt->execute();
            echo "Statut de l'utilisateur mis à jour avec succès.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    // fonction pour supprimer un utilisateur
    function supprimerUtilisateur($conn, $Id_utilisateur)
    {
        try {
            // Préparer la requête pour supprimer l'utilisateur
            $stmt = $conn->prepare("DELETE FROM utilisateur WHERE Id_utilisateur = :Id_utilisateur");
            $stmt->bindParam(':Id_utilisateur', $Id_utilisateur);
            $stmt->execute();
            echo "Utilisateur supprimé avec succès.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    ?>

    
    
    
    
    
    
    