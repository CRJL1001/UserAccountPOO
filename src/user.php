<?php

class User {

    private static ?PDO $bdd = null; 

    private static function getBdd() : PDO {
        if (self::$bdd === null){     
            try{
                require_once("bdd_connect.php");
                self::$bdd = BDD::connexion(); 
            }catch(RuntimeException $e){
                throw new RuntimeException("Connexion bdd_connect.php non établie".$e->getMessage()); 
            }
        }
        return self::$bdd; 
    }
    
    
    public static function login(string $email, string $password) : bool {
        require_once("verifier.php"); 
        if (
            !Verifier::syntaxeEmail($email) || //évite les requêtes bdd pour rien si le mail ou mdp est déjà invalide
            !Verifier::strongPassword($password) ||
            Verifier::doublonEmail($email) || //si compte existe
            !Verifier::password_verification($password, $email)
            ){
            return false; 
        }
        
        //si ok

        if (self::createSession($email)){
            return true; 
        }
    }

    private static function createSession(string $email) : bool {
        session_start(); 
        try{
            $bdd = self::getBdd(); 
            $request = $bdd->prepare('SELECT * FROM users WHERE email = ? LIMIT 1'); 
            $request->execute([$email]); 
            $user = $request->fetch(); 

            if (!$user){
                return false;
            }
            $_SESSION['connected'] = 1; 
            $_SESSION['email'] = $user['email']; 
            $_SESSION['pseudo'] = $user['pseudo']; 

            return true; 

        }catch(RuntimeException $e){
            throw new RuntimeException(" Erreur de création de session : ".$e->getMessage()); 
        }
    }

    public static function logout(){
        session_start();   
        try{
            $_SESSION['connected'] = 0; 
            session_abort(); 
            session_destroy(); 
        }catch(RuntimeException $e){
            throw new RuntimeException('Erreur de déconnexion : '.$e->getMessage()); 
        }                 
    }
}