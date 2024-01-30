<?php

require_once "./include/config.php";

class modele_auteur {
    public $nom;
    public $description;
    public $verifie;

    public function __construct($auteur_nom, $auteur_description, $auteur_verifie) {
        $this->nom = $auteur_nom;
        $this->description = $auteur_description;
        $this->verifie = $auteur_verifie;
    }
}

class modele_video {
    public $id;
    public $img_url;
    public $nom;
    public $description;
    public $categories;
    public $auteur;
    public $datePublication;
    public $duree;
    public $nombreVues;
    public $score;
    public $sousTitres;

    /***
     * Fonction permettant de construire un objet de type modele_video
     */
    public function __construct($id, $img_url, $nom, $description, $categories, $auteur_nom, $auteur_description, $auteur_verifie, $datePublication, $duree, $nombreVues, $score, $sousTitres) {
        $this->id = $id;
        $this->img_url = $img_url;
        $this->nom = $nom;
        $this->description = $description;
        $this->categories = $categories;
        $this->datePublication = $datePublication;
        $this->duree = intval($duree);
        $this->nombreVues = intval($nombreVues);
        $this->score = intval($score);
        $this->sousTitres = $sousTitres;

        $this->auteur = new modele_auteur($auteur_nom, $auteur_description, boolval($auteur_verifie));
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
     * Fonction permettant de récupérer l'ensemble des vidéos
     */
    public static function ObtenirTous() {
        $liste = [];
        $mysqli = self::connecter();

        $resultatRequete = $mysqli->query("SELECT * FROM videos");

        foreach ($resultatRequete as $enregistrement) {
            $liste[] = new modele_video($enregistrement['id'], $enregistrement['img_url'], $enregistrement['nom'], $enregistrement['description'], $enregistrement['categories'], $enregistrement['auteur_nom'], $enregistrement['auteur_description'], $enregistrement['auteur_verifie'], $enregistrement['datePublication'], $enregistrement['duree'], $enregistrement['nombreVues'], $enregistrement['score'], $enregistrement['sousTitres']);

        }

        return $liste;
    }
    
    /***
     * Fonction permettant de récupérer un vidéo en fonction de son identifiant
     */
    public static function ObtenirUn($id) {
        $resultat = new stdClass();

        $mysqli = self::connecter();

        if ($requete = $mysqli->prepare("SELECT * FROM videos WHERE id=?")) { // Création d'une requête préparée
            $requete->bind_param("i", $id); // Envoi des paramètres à la requête

            $requete->execute(); // Exécution de la requête

            $resultat_requete = $requete->get_result(); // Récupération de résultats de la requête

            if($enregistrement = $resultat_requete->fetch_assoc()) { // Récupération de l'enregistrement
                $video = new modele_video($enregistrement['id'], $enregistrement['img_url'], $enregistrement['nom'], $enregistrement['description'], $enregistrement['categories'], $enregistrement['auteur_nom'], $enregistrement['auteur_description'], $enregistrement['auteur_verifie'], $enregistrement['datePublication'], $enregistrement['duree'], $enregistrement['nombreVues'], $enregistrement['score'], $enregistrement['sousTitres']);
            } else {
                http_response_code(404); // Envoi un code 404 au serveur
                $resultat->message = "Erreur: Aucun vidéo trouvé";
                return $resultat;
            }

            $requete->close(); // Fermeture du traitement
            return $video;
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Une erreur a été détectée dans la requête utilisée";
            $resultat->erreur - $mysqli->error;
            return $resultat;
        }
    }

    /***
     * Fonction permettant d'ajouter un vidéo
     */
    public static function ajouter($img_url, $nom, $description, $categories, $auteur_nom, $auteur_description, $auteur_verifie, $datePublication, $duree, $nombreVues, $score, $sousTitres) {
        $resultat = new stdClass();

        $mysqli = self::connecter();

        // Création d'une requête préparée
        if ($requete = $mysqli->prepare("INSERT INTO videos(img_url, nom, description, categories, auteur_nom, auteur_description, auteur_verifie, datePublication, duree, nombreVues, score, sousTitres) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {

        $requete->bind_param("ssssssdsdiis", $img_url, $nom, $description, $categories, $auteur_nom, $auteur_description, $auteur_verifie, $datePublication, $duree, $nombreVues, $score, $sousTitres);

        if($requete->execute()) { // Exécution de la requête
            $resultat->message = "Vidéo ajouté"; // Message ajouté dans la page en cas d'ajout réussi
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

    /***
     * Fonction permettant de modifier un vidéo
     */
    public static function modifier($id, $img_url, $nom, $description, $categories, $auteur_nom, $auteur_description, $auteur_verifie, $datePublication, $duree, $nombreVues, $score, $sousTitres) {
        $resultat = new stdClass();

        $mysqli = self::connecter();

        // Création d'une requête préparée
        if ($requete = $mysqli->prepare("UPDATE videos SET img_url=?, nom=?, description=?, categories=?, auteur_nom=?, auteur_description=?, auteur_verifie=?, datePublication=?, duree=?, nombreVues=?, score=?, sousTitres=? WHERE id=?")) {

        $requete->bind_param("ssssssdsdiisi", $img_url, $nom, $description, $categories, $auteur_nom, $auteur_description, $auteur_verifie, $datePublication, $duree, $nombreVues, $score, $sousTitres, $id);

        if($requete->execute()) { // Exécution de la requête
            $resultat->message = "Vidéo modifié"; // Message ajouté dans la page en cas de modification réussi
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Une erreur est survenue lors de l'édition"; // Message ajouté dans la page en cas d'échec
            $resultat->erreur = $resultat->error;
        }

        $requete->close(); // Fermeture du traitement

        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Une erreur a été détectée dans la requête utilisée";
            $resultat->erreur = $mysqli->error;
        }

        return $resultat;
    }

    /***
     * Fonction permettant de supprimer un vidéo
     */
    public static function supprimer($id) {
        $resultat = new stdClass();

        $mysqli = self::connecter();

        // Création d'une requête préparée
        if ($requete = $mysqli->prepare("DELETE FROM videos WHERE id=?")) {

        $requete->bind_param("i", $id);

        if($requete->execute()) { // Exécution de la requête
            $resultat->message = "Vidéo supprimé"; // Message ajouté dans la page en cas de suppression réussi
        } else {
            http_response_code(500); // Envoi un code 500 au serveur
            $resultat->message = "Une erreur est survenue lors de la suppression"; // Message ajouté dans la page en cas d'échec
            $resultat->erreur = $requete->error;
        }

        $requete->close(); // Fermeture du traitement

        } else {
            http_response_code(500); // Envoi un coe 500 au serveur
            $resultat->message = "Une erreur a été détectée dans la requête utilisée";
            $resultat->erreur = $mysqli->error;
        }

        return $resultat;
    }

}

?>