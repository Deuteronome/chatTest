<?php

session_start();

spl_autoload_register(static function(string $fqcn) {
    $path = '../'.str_replace('\\', '/', $fqcn).'.php';    
    require_once($path);
 });

use Model\Model;

if($_SERVER['REQUEST_METHOD']=='POST') {
    if(isset($_SESSION['username'])) {
        $JSONdata = file_get_contents('php://input');
        $data = json_decode($JSONdata);

        if(isset($data->message) && !empty($data->message)) {
            $author = $_SESSION['username'];
            $message = htmlspecialchars($data->message);

            $bdd = new Model();

            try {
                $bdd->createMessage($author, $message);
            } catch(Exception $e) {
                http_response_code(500);
                echo json_encode(['message' => $e->getMessage()]);
            }
            
            http_response_code(201);
            echo json_encode(['message' => 'Message ajouté']); 

        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Message vide']); 
        }
    }else {
        http_response_code(401);
        echo json_encode(['message' => 'Utilisateur deconnecté']); 
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Mauvaise méthode']);
}