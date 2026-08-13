<?php

session_start(); 
if ($_SESSION['connected'] == 1){
    try{
        require_once("user.php"); 
        User::logout(); 
        header('location: login.php');
        exit();
    }catch (RuntimeException $e){
        throw new RuntimeException("Erreur de déconnexion : ".$e->getMessage()); 
    }
}