<?php
session_start();
include 'includes/header.php';
include 'includes/connect.php';

if (isset($_SESSION['user']) && $_SESSION['user']['Id_utilisateur'] == 7) {

    try {

        $stmt = $conn->query("SELECT COUNT(*) AS total_covoiturages FROM covoiturage");
        $totalCovoiturages = $stmt->fetch(PDO::FETCH_ASSOC)['total_covoiturages'];


        $stmt = $conn->query("SELECT COUNT(*) AS total_utilisateurs FROM utilisateur");
        $totalUtilisateurs = $stmt->fetch(PDO::FETCH_ASSOC)['total_utilisateurs'];
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit();
    }
} else {

    header('Location: index.php');
    exit();
}
?>
<h1>LISTE DES UTILISATEURS </h1>
<div class="list_users">

    <?php
    include 'includes/fonctions.php';



    $utilisateurs = afficherUtilisateurs($conn);
    foreach ($utilisateurs as $utilisateur) { ?>
        <div class="container d-flex-row   mt-6  flex-direction:wrap " style="width: 100%;">
            <div class="card mb-3 " style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"> <?= htmlspecialchars($utilisateur['nom']) ?> <?= htmlspecialchars($utilisateur['prenom']) ?> </h5>
                    <p class="card-text">Email: <?= htmlspecialchars($utilisateur['email']) ?> </p>
                    <p class="card-text">Téléphone:<?= htmlspecialchars($utilisateur['telephone']) ?></p>
                    <p class="card-text">Adresse: <?= htmlspecialchars($utilisateur['adresse']) ?></p>

                    <div class="card card-body">
                        <form method="POST" action="delete_user.php">
                            <input type="hidden" name="Id_utilisateur" value="<?= htmlspecialchars($utilisateur['Id_utilisateur']) ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                    <div>
                        <bouton class="btn btn-primary" id="View_avis_user" data-bs-toggle="collapse" data-bs-target="#avis' . $utilisateur['Id_utilisateur'] . '">Afficher les avis</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

</div>

<h1>Tableau de Bord Administrateur</h1>

<div>
    <h2>Statistiques</h2>
    <p><strong>Total des Covoiturages :</strong> <?php echo $totalCovoiturages; ?></p>
    <p><strong>Total des Utilisateurs :</strong> <?php echo $totalUtilisateurs; ?></p>
</div>

<div style="width: 50%; margin: auto;">
    <canvas id="covoituragesChart"></canvas>
</div>

<div style="width: 50%; margin: auto; margin-top: 30px;">
    <canvas id="utilisateursChart"></canvas>
</div>

<script>
    const covoituragesData = {
        labels: ['Covoiturages'],
        datasets: [{
            label: 'Nombre de covoiturages',
            data: [<?php echo $totalCovoiturages; ?>],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };


    const utilisateursData = {
        labels: ['Utilisateurs'],
        datasets: [{
            label: 'Nombre d\'utilisateurs inscrits',
            data: [<?php echo $totalUtilisateurs; ?>],
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
    };


    const covoituragesConfig = {
        type: 'bar',
        data: covoituragesData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };


    const utilisateursConfig = {
        type: 'bar',
        data: utilisateursData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    new Chart(document.getElementById('covoituragesChart'), covoituragesConfig);
    new Chart(document.getElementById('utilisateursChart'), utilisateursConfig);
</script>

</body>

</html>