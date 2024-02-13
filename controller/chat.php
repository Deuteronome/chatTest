<?php
session_start();

if(isset($_POST['username']) && !empty($_POST['username'])) {
    $_SESSION["username"] = htmlspecialchars($_POST['username']);
}


spl_autoload_register(static function(string $fqcn) {
    $path = '../'.str_replace('\\', '/', $fqcn).'.php';    
    require_once($path);
 });

use Model\Model;

$bdd = new Model();

$lastId = (int)$bdd->getLastMessageId();


require_once('../view/chatView.php');