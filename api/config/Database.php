<?php

class Database
{
  // Connexion à la base de données
  private $host = "localhost";
  private $db_name = "vente-articles";
  private $username = "root";
  private $password = "";
  public static $connexion = null;

  private function __construct()
  {
    try {
      self::$connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      self::$connexion->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Erreur de connexion : " . $exception->getMessage();
    }
  }
  // getter pour la connexion
  public static function getConnection()
  {
    if (self::$connexion == null) {
      new Database();
    }
    return self::$connexion;
  }
}

$db = Database::getConnection();
