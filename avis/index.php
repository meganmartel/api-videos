<?php
        header('Content-Type: application/json;'); 
        header('Access-Control-Allow-Origin: *'); 
    require_once './controlleurs/liste-avis-json.php';
    $controlleurAvis = new ControlleurAvis;

        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                    if(isset($_GET['id'])) {
            $controlleurAvis->afficherFicheJSON($_GET['id']);
                    } else {
            $controlleurAvis->afficherJSON();
                    }
                    break;
            case 'POST':
            
                $corpsJSON = file_get_contents('php://input');
                $data = json_decode($corpsJSON, TRUE);

                $controlleurAvis->ajouterJSON($data);
                    break;
                    default;
}

?>