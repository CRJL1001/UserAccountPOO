<?php

class Securite {

    public static function chiffrer(string $password) : string {
        $crypted_password = password_hash($password, PASSWORD_DEFAULT); 
        return $crypted_password;
    }
}