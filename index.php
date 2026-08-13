<?php

    //base
    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password'])){
        
        $pseudo = htmlspecialchars($_POST['pseudo']); 
        $email = htmlspecialchars($_POST['email']); 
        $password = htmlspecialchars($_POST['password']); 


        
        require_once("src/verifier.php");

        //verifications

        if  (!Verifier::syntaxeEmail($email)){ //vérif syntaxe
            header("location: index.php?error=1&message=Email invalide"); 
            exit(); 
        } else if (!Verifier::doublonEmail($email)){ //doublons email
            header("location: index.php?error=1&message=Email déjà"); 
            exit(); 
        }
        else if (!Verifier::doublonPseudo($pseudo)){ //doublons pseudo
            header("location: index.php?error=1&message=Pseudo déjà pris"); 
            exit(); 
        } 
        else if (!Verifier::strongPassword($password)){ //mdp fort
            header("location: index.php?error=1&message=Mot de passe faible"); 
            exit(); 
        }

        //inscription

        require_once("src/bdd_helper.php"); 

        if ( BDD_helper::inscription($email, $pseudo, $password)){
            header("location: index.php?success=1&message=Vous êtes inscrit, veuillez vous connecter !"); 
            exit(); 
        }

        
    }

?>
<html>
    <head>
        <meta charset="utf-8">
        <title>POO X Inscription</title>
        <link rel="stylesheet" href="design/default.css">
    </head>
    <body>
        <section id="container">
            <h1>Bienvenue</h1>
            <form method="post" action="index.php">
                <input type="text" name="pseudo" placeholder="Pseudo"><br>
                <input type="email" name="email" placeholder="Email"><br>
                <input type="password" name="password" placeholder="Mot de passe"><br>
                <?php
                    if(isset($_GET['error']) && htmlspecialchars($_GET['error']) == 1){
                        echo 'Erreur : '.htmlspecialchars($_GET['message']).'<br>'; 
                    }
                    if(isset($_GET['success']) && htmlspecialchars($_GET['success']) == 1){
                        echo htmlspecialchars($_GET['message']).'<br>'; 
                    }
                ?>
                <input type="submit" value="Inscription"><br>
                <a href="src/login.php">Page de connexion</a>
            </form>
            <section id="square1"></section>
            <section id="square2"></section>
            <section id="square3"></section>
        </section>

        
    </body>
</html>
