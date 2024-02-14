<?php
session_start();
/* Gestion du formulaire - le nom envoyé est stocké dans l'hyperglobale $_SESSION*/
if(isset($_POST['username']) && !empty($_POST['username'])) {
    $_SESSION["username"] = htmlspecialchars($_POST['username']);
}

/*au lieu de récupérer le model via un require, on utilise l'importation via la commande use,
la fonction autoload explique où trouver le fichier en fonction de l'espace de nom donné dans le use (ici Model\Model à aller chercher dans ../Model/Model.php)*/
spl_autoload_register(static function(string $fqcn) {
    $path = '../'.str_replace('\\', '/', $fqcn).'.php';    
    require_once($path);
 });

use Model\Model;//on importe la class Model

$bdd = new Model();//on instancie un objet Model qu'on stocke dans une variable

$lastId = (int)$bdd->getLastMessageId();//on utilise une méthode de l'objet Model pour récupérer l'id du dernier message entré en base de donnée

//on invoque la vue
require_once('../view/chatView.php');