<?php
include_once '../include/config.php';

header('Content-Type: application/json;'); 
header('Access-Control-Allow-Origin: *');

$mysqli = new mysqli(Db::$host, Db::$username, Db::$password, Db::$database); // Établissement de la connexion à la base de données
if ($mysqli -> connect_errno) { // Affichage d'une erreur si la connexion échoue
    echo 'Échec de connexion à la base de données MySQL: ' . $mysqli -> connect_error;
    exit();
} 

switch($_SERVER['REQUEST_METHOD'])
{
case 'PUT':
    $reponse = new stdClass();
    $reponse->message = "Augmenter le score: ";

    $corpsJSON = file_get_contents('php://input');
    $data = json_decode($corpsJSON, TRUE); 

    if(isset($_GET['id'])) {
        if ($requete = $mysqli->prepare("UPDATE videos SET score = score+1 WHERE id=?")) {
        $requete->bind_param("i", $_GET['id']);
                    
            if($requete->execute()) {
                        $reponse->message .= 'Succès';
            } else {
                        $reponse->message .= "Erreur dans l'exécution de la requête";
            }

            $requete->close();
        } else {
        $reponse->message .= "Erreur dans la préparation de la requête";    
        }
    } else {
    $reponse->message .= "Erreur dans le corps de l'objet fourni";
    }
    echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 

    break;
    default:
    $reponse = new stdClass();
    $reponse->message = "Opération non supportée";
    echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
 
$mysqli->close();
?>