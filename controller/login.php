<?php 
session_start();
if(isset($_SESSION["username"]) && !empty($_SESSION["username"])){
    header('location: ../controller/chat.php');
}

require_once('../view/loginView.php');