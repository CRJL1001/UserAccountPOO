<?php

    Class BDD {

        public static function connexion() : PDO {

            static $bdd = null; 
            if ($bdd === null){
                try{
                    $bdd = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', ''); 
                }catch (PDOException $e){
                    throw new RuntimeException("Erreur bdd_connect.php"); 
                }  
            }           
            return $bdd;
        }        
    }
     
?>