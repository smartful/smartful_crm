<?php

class PDOFactory
{
    public static function getMySQLConnexion()
    {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=crm','root','');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $bdd;
        } catch (Exception $e) {
            die("Erreur : ".$e->getMessage());
        }
    }
}