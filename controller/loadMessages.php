<?php

spl_autoload_register(static function(string $fqcn) {
    $path = '../'.str_replace('\\', '/', $fqcn).'.php';    
    require_once($path);
 });

use Model\Model;

if($_SERVER['REQUEST_METHOD']=='GET') {
    if(isset($_GET['lastId'])) {
        $lastId = (int)strip_tags($_GET['lastId']);

        $bdd = new Model();
        $messageList = $bdd->loadLastMessages($lastId);

        echo json_encode($messageList);


    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Date dernier message requise']); 
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Mauvaise méthode']);
}