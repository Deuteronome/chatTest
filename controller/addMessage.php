<?php
/*Controller qui gère l'ajout de messages en base de données -
Il n'est appélé que par le script chat.js (requête AJAX) */
session_start();

/*instanciation de l'objet Model(cf. chat.php pour plus de détail, c'est la même chose)*/
spl_autoload_register(static function(string $fqcn) {
    $path = '../'.str_replace('\\', '/', $fqcn).'.php';    
    require_once($path);
 });

use Model\Model;


if($_SERVER['REQUEST_METHOD']=='POST') {
    //on est bien en méthode POST
    if(isset($_SESSION['username'])) {
        $JSONdata = file_get_contents('php://input');//on récupère les données
        $data = json_decode($JSONdata);//on décode pour obtenir un tableau associatif

        if(isset($data->message) && !empty($data->message)) {
            //le message n'est pas vide
            //on définit les données du message
            $author = $_SESSION['username'];
            $message = htmlspecialchars($data->message);

            $bdd = new Model();//on instancie le Model 

            try {
                $bdd->createMessage($author, $message);//on utilise la méthode qui insère des données en bdd
            } catch(Exception $e) {
                //en cas d'echec, , on renvoie un code d'erreur et un message à afficher dans la console - encodé en JSON
                http_response_code(500);
                echo json_encode(['message' => $e->getMessage()]);
            }
            
            //on renvoie le code de réussite - 201 - création d'une entrée en base de données
            http_response_code(201);
            echo json_encode(['message' => 'Message ajouté']); 

        } else {
            //Il n'y a pas de message, on renvoie un code d'erreur et un message à afficher dans la console - encodé en JSON
            http_response_code(400);
            echo json_encode(['message' => 'Message vide']); 
        }
    }else {
        //la session est expiré, on renvoie un code d'erreur et un message à afficher dans la console - encodé en JSON
        http_response_code(401);
        echo json_encode(['message' => 'Utilisateur deconnecté']); 
    }
} else {
    //on est pas en mêthode POST, on renvoie un code d'erreur et un message à afficher dans la console - encodé en JSON
    http_response_code(405);
    echo json_encode(['message' => 'Mauvaise méthode']);
}