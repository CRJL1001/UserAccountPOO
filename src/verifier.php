<?php

    Class Verifier {

        private static $bdd = null; 

        private static function getBdd() : PDO {
            if (self::$bdd === null){
                require_once("bdd_connect.php");
                self::$bdd = BDD::connexion(); 
            }
            return self::$bdd; 
        }

        public static function syntaxeEmail(string $email) : bool {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return false;
            }
            return true; 
        }

        public static function doublonEmail(string $email) : bool {
            $bdd = self::getBdd(); 
            try{
                $request = $bdd->prepare('SELECT * FROM users WHERE email = ? LIMIT 1'); 
                $request->execute([$email]);
                $user = $request->fetch(); 
                $request->closeCursor(); 
            }catch (PDOException $e){
                throw new RuntimeException("Requête échouée doublonEmail : ".$e->getMessage()); 
            }            
            if($user){
                return false;
            }
            return true;
        }

        public static function doublonPseudo(string $pseudo) : bool {
            $bdd = self::getBdd(); 
            try{
                $request = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? LIMIT 1'); 
                $request->execute([$pseudo]); 
                $user = $request->fetch(); 
                $request->closeCursor(); 
            }catch (PDOException $e){
                throw new RuntimeException("Requête échouée doublonPseudo : ".$e->getMessage()); 
            }
            
            if($user){
                return false;
            }
            return true; 
        }

        public static function strongPassword(string $password) : bool {
            if ( 
                strlen($password) < 8 || 
                !preg_match('/[A-Z]/', $password) ||
                !preg_match('/[a-z]/', $password) ||
                !preg_match('/[0-9]/', $password) ||
                !preg_match('/\W/', $password)
            ){
                return false;
            }
            return true; 
        }

        public static function password_verification(string $password, string $email) : bool {
            $bdd = self::getBdd(); 
            
            try{
                $request = $bdd->prepare('SELECT password FROM users WHERE email = ? LIMIT 1'); 
                $request->execute([$email]); 
                $user = $request->fetch(); 
                $request->closeCursor(); 
            }catch (PDOException $e){
                throw new RuntimeException("Requête échouée password_verification : ".$e->getMessage()); 
            }

            if(!password_verify($password, $user['password'])){
                return false;
            }
            return true; 
        }

    }

?>