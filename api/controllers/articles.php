<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// suivant la methode du client
switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    $db = Database::getConnection();
    $donnees = json_decode(file_get_contents("php://input"));
    break;
  case 'GET':
    # code...
    break;
  case 'DELETE':
    # code...
    break;
  case 'PUT':
    # code...
    break;

  default:
    # code...
    break;
}
// On vérifie la méthode
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // On inclut les fichiers de configuration et d'accès aux données
  include_once '../config/Database.php';

  if (!empty($donnees->nom) && !empty($donnees->description) && !empty($donnees->prix) && !empty($donnees->categories_id)) {
    // Ici on a reçu les données
    // On hydrate notre objet
    $produit->nom = $donnees->nom;
    $produit->description = $donnees->description;
    $produit->prix = $donnees->prix;
    $produit->categories_id = $donnees->categories_id;

    if ($produit->creer()) {
      // Ici la création a fonctionné
      // On envoie un code 201
      http_response_code(201);
      echo json_encode(["message" => "L'ajout a été effectué"]);
    } else {
      // Ici la création n'a pas fonctionné
      // On envoie un code 503
      http_response_code(503);
      echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
    }
  }
} else {
  // On gère l'erreur
  http_response_code(405);
  echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
