<?php
    session_start(); 

    //si pas connecté
    if ($_SESSION['connected'] != 1){
        header('location: login.php');
        exit(); 
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>POO X Connected</title>
        <link rel="stylesheet" href="../design/default.css">
    </head>
    <body>
        <section id="container">
            <h1>Bienvenue <?=$_SESSION['pseudo']?></h1>
            <form method="post" action="logout.php">
                <input type="submit" value="Déconnexion" style="margin-top : 40px; margin-bottom : 40px;"><br>
            </form>
            <section id="square1"></section>
            <section id="square2"></section>
            <section id="square3"></section>
        </section>

        
    </body>
</html>