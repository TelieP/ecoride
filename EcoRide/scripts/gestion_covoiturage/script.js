/**
 * Change le statut d'un coivturage
 */
function startOrStopCovoit() {
    // Récupération de tous les boutons ayant la classe start_covoit
    const startButtons = document.querySelectorAll('.start_cov');
    // Pour chaque boutons, ajout d'un listener
    startButtons.forEach((startButton) => {
        startButton.addEventListener('click', (event) => {
            const clickedButton = event.currentTarget
            // On vérifie si on démarre ou on stoppe le trajet
            let startOrStop = "D"
            if (clickedButton.innerText == "En cours") {
                startOrStop = "T"
            }
            // Appel à la fonction qui met à jour le statut
            updateStatus(clickedButton, startOrStop)
        });
    });
}
// Ajout des listeners
startOrStopCovoit();

/**
 * Change le statut du covoiturage en BDD + envoi mail
 * @param {HTMLElement} clickedButton 
 * @param {string} startOrStop 
 */
function updateStatus(clickedButton, startOrStop) {
    idTrajet = clickedButton.getAttribute('id');
    $.ajax({
    // Fichier qui est appelé
    url: "scripts/gestion_covoiturage/gestion_covoiturage.php",
    // Méthode POST pour mettre à jour la DB
    method: "POST",
    // On passe la variable status (D ou T)
    data: { startOrStop: startOrStop, idTrajet: idTrajet },
    success: function (data) {
        try {
            // Alert + MAJ du texte du lien
            if (data == "D") {
                // On a reçu "D" : le trajet est en cours
                alert("votre trajet à demarré , passez un bon voyage !")
                clickedButton.innerText = "En cours"
            } else {
                // On a reçu "T" : le trajet est terminé
                alert("votre trajet terminé , merci pour votre confiance !")
                clickedButton.innerText = "Terminé"
            }
            // TODO envoyer email au conducteur et passager
            
        } catch (e) {
            console.error("Erreur JSON :", e);
        }
    },
    error: function (xhr, status, error) {
        // Erreur Ajax
        console.error("Erreur AJAX :", status, error, xhr.responseText);
    }
})
}
