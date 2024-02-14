<?php 
session_start();

//redirection vers le chat si l'utilisateur est déjà identifié
if(isset($_SESSION["username"]) && !empty($_SESSION["username"])){
    header('location: ../controller/chat.php');
}

//appel de la vue
require_once('../view/loginView.php');