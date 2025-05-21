/**
 * Récupère les trajets écolo (appelé depuis recherche.php sur l'événement 'onchange')
 */
function getEnvironmentallyFriendlyCarSharing() {
  // On récupère la checkbox => peut être remplacé par document.getElementById (mais autant profiter de jQuery :))
  const checkBox = $("#ecological");
  // On regarde si elle est cochée ou non
  // Si elle est cochée, on met 1 dans la variable ecological, 0 sinon
  let ecological = checkBox[0].checked ? 1 : 0;
  // Appel Ajax de type GET
  $.ajax({
    // Fichier qui est appelé
    url: "/scripts/filters/filter.php",
    // Méthode GET car on récupère des données
    method: "GET",
    // On passe la variable ecological (0 ou 1)
    data: { ecological: ecological },
    success: function (data) {
      try {
        // Si pas d'erreur : log dans la console
        // TODO : Afficher trajet ecolos
        console.log(data);
      } catch (e) {
        // Le drame ! Mais ça ne se produira pas :)
        console.error("Erreur JSON :", e);
      }
    },
    error: function (xhr, status, error) {
      // Erreur Ajax
      console.error("Erreur AJAX :", status, error, xhr.responseText);
    }
  })
};

/**
 * Fonction pour récuperer les trajets par prix croissant ou décroissant 
 * Appelée depuis recherche.php sur l'événement 'onchange'
 **/
function getlowprice() {
  // On récupère la checkbox en jQuery
  const askOrDeskBox = $("#lowprice");
  // On regarde si elle est cochée ou non
  // Si elle est cochée, on met 1 dans la variable askOrDesk, 0 sinon
  const askOrDesk = askOrDeskBox[0].checked ? 1 : 0;
  // On récupère les divs de la recherche
  const covoitDivs = $('.list-group-item');
  // On crée un tableau pour les ids à récuprérer
  let idsCovoits = [];
  // On boucle sur le tableau covoitDivs
  // Pour chaque élément (div) du tableau : on récupère l'id de la div
  covoitDivs.each(function() {
    idsCovoits.push($(this).attr('id'));
  });
  // Appel Ajax
  $.ajax({
    // Fichier qui est appelé
    url: "scripts/filters/filter.php",
    // Méthode GET car on récupère des données
    method: "GET",
    // On passe la variable askOrDesk (0 ou 1)
    data: { askOrDesk : askOrDesk, idsCovoits: idsCovoits },
    success: function (data) {
      try {
        // Appel à la fonction d'affichage des trajets triés
        displaySortedCovoit(data, askOrDesk);
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

/**
 * Fonction qui trie les covoits en fonction de leurs prix
 * @param {JSON} data : Données triées
 * @param {integer} ascOrDesc 0 ou 1
 * - 1 pour croissant, 
 * - 0 pour décroissant
 */
function displaySortedCovoit(data, ascOrDesc) {
  // On récupère la div
  const trajetsDiv = $(".list-group.mt-4");
  // On vide d'abord les trajets existants
  trajetsDiv.empty();
  data.forEach(covoit => {
    // Construction du covoit
    const divCovoit = "<div class=\"list-group-item list-group-item-action\" + id=\"" + covoit['Id_covoiturage'] + "\" >"
      + "<h5><i class=\"bi bi-geo-fill\"></i> De " + covoit['lieu_depart'] + "</br><i class=\"bi bi-arrow-down\"></i></br> <i class=\"bi bi-geo-fill\"></i> à " + covoit['lieu_arrivee'] + "</h5>"
      + "<p><i class=\"bi bi-calendar3\"></i> Date : + " + covoit['date_depart'] + " à " + covoit['heure_depart'] + "</p>"
      + "<p> </i> Conducteur : " + covoit['nom'] + " " + covoit['prenom'] + "<img src=" + covoit['photo'] + " alt=\"Conducteur\" class=\"img-fluid\" style=\"width: 75px; height: 75px; border-radius: 50%;\"></p>"
      + "<p><i class=\"bi bi-car-front-fill\"></i> Véhicule : " + covoit['modele'] + "</p>"
      + "<p><i class=\"bi bi-cash-coin\"></i> Prix : " + covoit['prix_personne'] + "€</p>"
      + "<p><i class=\"bi bi-person-check-fill\"></i> Places restantes : " + covoit['nb_place'] + "</p>"
      + "<a href=\"reservation_cov.php?id=" + covoit['Id_covoiturage'] + "\" class=\"btn btn-success\"><i class=\"fas fa-check\"></i> Réserver</a>"
      + "<a href=\"reservation_cov.php?id=" + covoit['Id_covoiturage'] + "\" class=\"btn btn-success stretched-link\"><i class=\"fas fa-check\"></i> VOIR</a>"
      + "</div>"
    // On ajoute à la div principale
    trajetsDiv.append(divCovoit);
    // Changement du libellé
    let label = $("#labellowprice");
    if (ascOrDesc == 1) {
      label.text("Trier par prix croissant");
    } else {
      label.text("Trier par prix décroissant");
    }
  })
}