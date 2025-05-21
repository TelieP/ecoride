<?php
session_start();
// Supprimer toutes les variables de session
session_unset();
// Détruire la session     
session_destroy();
// Rediriger vers la page de connexion (moi je ferais vers l'index mais bon pcq quand on se déconnecte, pour moi, ça renvoie revoie vers index.php...)
header("Location: index.php");
// Arrêter le script après la redirection
exit();
