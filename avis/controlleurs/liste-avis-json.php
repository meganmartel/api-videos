<?php

require_once './modeles/liste-avis-html.php';

class ControlleurAvis {

    /***
     * Fonction permettant de récupérer l'ensemble des avis et de les afficher au format JSON
     */
    function afficherJSON() {
        $resultat = modele_avis::ObtenirTous();
        echo json_encode($resultat);
    }

    /***
     * Fonction permettant de récupérer l'ensemble des avis et de les afficher au format JSON
     */
    function afficherFicheJSON($id) {
        $resultat = modele_avis::ObtenirUn($id);
        echo json_encode($resultat);
    }

    /***
     * Fonction permettant d'ajouter un avis reçu au format JSON
     */
    function ajouterJSON($data) {
        $resultat = new stdClass();

        if(isset($data['note']) && isset($data['commentaires']) && isset($data['videos_id'])) {
            $resultat = modele_avis::ajouter($data['note'], $data['commentaires'], $data['videos_id']);
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Impossible d'ajouter un avis. Des informations sont manquantes.";
        }
        echo json_encode($resultat);
    }

}

?>