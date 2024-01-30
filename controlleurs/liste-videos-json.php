<?php

require_once './modeles/liste-videos-html.php';

class ControlleurVideo {

    /***
     * Fonction permettant de récupérer l'ensemble des vidéos et de les afficher au format JSON
     */
    function afficherJSON() {
        $resultat = modele_video::ObtenirTous();
        echo json_encode($resultat);
    }

    /***
     * Fonction permettant de récupérer l'ensemble des vidéos et de les afficher au format JSON
     */
    function afficherFicheJSON($id) {
        $resultat = modele_video::ObtenirUn($id);
        echo json_encode($resultat);
    }

    /***
     * Fonction permettant d'ajouter un vidéo reçu au format JSON
     */
    function ajouterJSON($data) {
        $resultat = new stdClass();

        if(isset($data['img_url']) && isset($data['nom']) && isset($data['description']) && isset($data['categories']) && isset($data['auteur']['nom']) && isset($data['auteur']['description']) && isset($data['auteur']['verifie']) && isset($data['datePublication']) && isset($data['duree']) && isset($data['nombreVues']) && isset($data['score']) && isset($data['sousTitres'])) {
            $resultat = modele_video::ajouter($data['img_url'], $data['nom'], $data['description'], $data['categories'], $data['auteur']['nom'], $data['auteur']['description'], $data['auteur']['verifie'], $data['datePublication'], $data['duree'], $data['nombreVues'], $data['score'], $data['sousTitres']);
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Impossible d'ajouter un vidéo. Des informations sont manquantes.";
        }
        echo json_encode($resultat);
    }

    /***
     * Fonction permettant de modifier un vidéo reçu au format JSON
     */
    function modifierJSON($data) {
        $resultat = new stdClass();
        if(isset($_GET['id'])) {
            if(isset($data['img_url']) && isset($data['nom']) && isset($data['description']) && isset($data['categories']) && isset($data['auteur']['nom']) && isset($data['auteur']['description']) && isset($data['auteur']['verifie']) && isset($data['datePublication']) && isset($data['duree']) && isset($data['nombreVues']) && isset($data['score']) && isset($data['sousTitres'])) {
                $resultat = modele_video::modifier($_GET['id'], $data['img_url'], $data['nom'], $data['description'], $data['categories'], $data['auteur']['nom'], $data['auteur']['description'], $data['auteur']['verifie'], $data['datePublication'], $data['duree'], $data['nombreVues'], $data['score'], $data['sousTitres']);
            } else {
                http_response_code(500); // Envoi un code 500 au serveur
                $resultat = "Impossible de modifier le vidéo. Des informations sont manquantes.";
            }
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "ID manquant";
        }
        echo json_encode($resultat);
    }

    /***
     * Fonction permettant de supprimer un vidéo reçu au format JSON
     */
    function supprimerJSON() {
        $resultat = new stdClass();
        if(isset($_GET['id'])) {
            $resultat = modele_video::supprimer($_GET['id']);
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "ID manquant";
        }
        echo json_encode($resultat);
    }
}

?>