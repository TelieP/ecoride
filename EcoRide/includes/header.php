<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<header class="navigation" id="navbar">
    <nav class="navbar navbar-expand-lg bg-success navbar-light">
        <div class="container-fluid bg">
            <a href="index.php"> <img src="images/logo.svg" alt="logo" width="90" height="90"></a>
            <a href="index.php" class="navbar-brand" href="index.php">EcoRide</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link" href="index.php">Accueil</a>
                    <li class="nav-item">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="recherche.php">Covoiturages</a>
                    </li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php">Connexion</a>
                        </li>
                    <?php endif; ?>
                    </li>
                    <!-- test debut  -->
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php">profil</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="inscription.php">inscription</a>
                        </li>
                    <?php endif; ?>
                    </li>
                    <!-- fin test  -->

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                </ul>



                <!-- vérifier si l'utilisateur est connecté et afficher le lien vers le profil -->
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- ajoute la photo de profil de l'utilisateur connecté  -->
                    <img src="<?= $_SESSION['user']['photo'] ?>" alt="Photo de profil" class="rounded-circle" width="50" height="50">
                    <!-- affiche le pseudo de l'utilisateur connecté  -->
                    <span class="navbar-text text-white ms-2"><?= $_SESSION['user']['pseudo'] ?></span>
                <?php endif; ?>
                <!-- <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Rechercher</button>
                    </form> -->
            </div>
        </div>
    </nav>
</header>