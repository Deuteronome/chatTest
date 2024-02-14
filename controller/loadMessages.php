<?php
/*Controller qui gère la récupération de nouveaux messages -
Il n'est appélé que par le script chat.js (requête AJAX) */

/*instanciation de l'objet Model(cf. chat.php pour plus de détail, c'est la même chose)*/
spl_autoload_register(static function(string $fqcn) {
    $path = '../'.str_replace('\\', '/', $fqcn).'.php';    
    require_once($path);
 });

use Model\Model;

if($_SERVER['REQUEST_METHOD']=='GET') {
    //on est bien en méthode GET
    if(isset($_GET['lastId'])) {
        //on récupère bien l'ID du dernier message
        $lastId = (int)strip_tags($_GET['lastId']);

        $bdd = new Model();
        $messageList = $bdd->loadLastMessages($lastId);//on récupère les dernier messages (tous ceux dont l'id et supérieur à $lastId grâce à la méthode de l'objet Model)

        echo json_encode($messageList);//on encode et on envoie au serveur, dans le cas de la méthode GET, le code 200 est envoyé automatiquement avec les données


    } else {
        //on a pas l'id du dernier message, on renvoie un code d'erreur et un message à afficher dans la console - encodé en JSON
        http_response_code(400);
        echo json_encode(['message' => 'id dernier message requise']); 
    }
} else {
    //on est pas en mêthode GET, on renvoie un code d'erreur et un message à afficher dans la console - encodé en JSON
    http_response_code(405);
    echo json_encode(['message' => 'Mauvaise méthode']);
}