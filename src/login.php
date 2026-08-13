<?php
    session_start(); 
    //envoi formulaire
    if (!empty($_POST['email']) && !empty($_POST['password'])){

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        try {
            require_once("user.php"); 
            if (User::login($email, $password)){
                //redirection
                header('location: connected.php'); 
                exit(); 
            } else {
                header('location: login.php?error=1&message=Email ou MDP invalide'); 
                exit(); 
            }
        }catch(RuntimeException $e){
            throw new RuntimeException("Erreur de connexion : ".$e->getMessage()); 
        }



    }

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>POO X Connexion</title>
        <link rel="stylesheet" href="../design/default.css">
    </head>
    <body>
        <section id="container">
            <h1>Bienvenue</h1>
            <form method="post" action="login.php">
                <input type="email" name="email" placeholder="Email"><br>
                <input type="password" name="password" placeholder="Mot de passe"><br>
                <?php
                    if(isset($_GET['error']) && htmlspecialchars($_GET['error']) == 1){
                        echo 'Erreur : '.htmlspecialchars($_GET['message']).'<br>'; 
                    }
                ?>
                <input type="submit" value="Connexion" style="margin-top : 40px; margin-bottom : 40px;"><br>
                <a href="../index.php">Page d'inscription</a>
            </form>
            <section id="square1"></section>
            <section id="square2"></section>
            <section id="square3"></section>
        </section>

        
    </body>
</html>