<?php

class BDD_helper{

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

    public static function inscription(string $email, string $pseudo, string $password) : bool{
        $bdd = self::getBdd();  

        require_once('securite.php');
        $crypted_password = Securite::chiffrer($password); 
        
        try{
            $request = $bdd->prepare('INSERT INTO users (pseudo, email, password) VALUES (?, ?, ?)'); 
            $request->execute([$pseudo, $email, $crypted_password]); 
            $request->closeCursor(); 
        }catch (PDOException $e){
            die('Erreur : '.$e->getMessage()); 
        }

        return true; 
    }
}