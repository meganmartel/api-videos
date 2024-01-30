<?php

require_once "../include/config.php";

class modele_avis {
    public $id;
    public $note;

    public $commentaires;
    public $videos_id;
    /***
     * Fonction permettant de construire un objet de type modele_avis
     */
    public function __construct($id, $note, $commentaires, $videos_id) {
        $this->id = $id;
        $this->note = $note;
        $this->commentaires = $commentaires;
        $this->videos_id = $videos_id;

    }


    /***
     * Fonction permettant de se connecter à la base de données
     */
    static function connecter() {

        $mysqli = new mysqli(Db::$host, Db::$username, Db::$password, Db::$database);

        //Vérifier la connexion
        if ($mysqli -> connect_errno) {
            http_response_code(500); // Envoi un code 500 au serveur
            $erreur = new stdClass();
            $erreur->message = "Échec de connexion à la base de données";
            $erreur->error = $mysqli -> connect_error;
            echo json_encode($erreur);
            exit();
        }

        return $mysqli;
    }

    /***
     * Fonction permettant de récupérer l'ensemble des avis
     */
    public static function ObtenirTous() {
        $liste = [];
        $mysqli = self::connecter();

        $resultatRequete = $mysqli->query("SELECT * FROM avis");

        foreach ($resultatRequete as $enregistrement) {
            $liste[] = new modele_avis($enregistrement['id'], $enregistrement['note'], $enregistrement['commentaires'], $enregistrement['videos_id']);

        }

        return $liste;
    }
    
    /***
     * Fonction permettant de récupérer un avis en fonction de son identifiant
     */
    public static function ObtenirUn($videos_id) {
        $listeCommentaires = [];
        $resultat = new stdClass();

        $mysqli = self::connecter();

        if ($requete = $mysqli->prepare("SELECT * FROM avis WHERE videos_id=?")) { // Création d'une requête préparée
            $requete->bind_param("i", $videos_id); // Envoi des paramètres à la requête

            $requete->execute(); // Exécution de la requête

            $resultat_requete = $requete->get_result(); // Récupération de résultats de la requête

            while ($enregistrement = $resultat_requete->fetch_assoc()) { // Récupération de l'enregistrement
                $avis = new modele_avis($enregistrement['id'], $enregistrement['note'], $enregistrement['commentaires'], $enregistrement['videos_id']);
                $listeCommentaires[] = $avis;
            } 

            $requete->close(); // Fermeture du traitement
            return $listeCommentaires;
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Une erreur a été détectée dans la requête utilisée";
            $resultat->erreur - $mysqli->error;
            return $resultat;
        }
    }

    /***
     * Fonction permettant d'ajouter un avis
     */
    public static function ajouter($note, $commentaires, $videos_id) {
        $resultat = new stdClass();

        $mysqli = self::connecter();

        // Création d'une requête préparée
        if ($requete = $mysqli->prepare("INSERT INTO avis(note, commentaires, videos_id) VALUES (?, ?, ?)")) {

        $requete->bind_param("dsi", $note, $commentaires, $videos_id);

        if($requete->execute()) { // Exécution de la requête
            $resultat->message = "Avis ajouté"; // Message ajouté dans la page en cas d'ajout réussi
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Une erreur est survenue lors de l'ajout"; // Message ajouté dans la page en cas d'échec
            $resultat->erreur = $requete->error;
        }

        $requete->close(); // Fermeture du traitement

        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Une erreur a été détectée dans la requête utilisée";
            $resultat->erreur = $mysqli->error;
        }

        return $resultat;
    }

}

?>