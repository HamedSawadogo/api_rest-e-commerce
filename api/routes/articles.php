<?php
require_once "../config/Database.php";
require_once "../model/Article.php";
require_once "../manager/ArticleManager.php";

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$db = Database::getConnection();
$manager = new ArticleManager($db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $donnees = json_decode(file_get_contents("php://input"));

  echo json_encode(['data' => $donnees]);
  if (!empty($donnees->designation) && !empty($donnees->url) && !empty($donnees->prix)) {

    $designation = $donnees->designation;
    $url = $donnees->url;
    $prix = $donnees->prix;
    $article = new Article($designation, $url, $prix);
    if ($manager->addArticle($article)) {
      http_response_code(201);
      echo json_encode(["message" => "L'ajout a été effectué"]);
    } else {
      http_response_code(503);
      echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
    }
  } else {
    echo json_encode(["message" => "une erreur est survenue"]);
    http_response_code(503);
  }
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {

  $articlesList = $manager->getArticleList();
  $newArtilce = [];
  foreach ($articlesList as $key => $value) {
    $newArtilce['articles'][] = [
      'id' => $value->getId(),
      'designation' => $value->getDesignation(),
      'url' => $value->getUrl(),
      'prix' => $value->getPrice()
    ];
  }
  echo json_encode($newArtilce);
  http_response_code(201);
} elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {
  $donnees = json_decode(file_get_contents("php://input"));
  if (isset($donnees->id) && !empty($donnees->id)) {
    $id = (int)$donnees->id;
    if ($manager->deleteArticle($id)) {
      echo json_encode(["message" => "suppression effectué avec succes!"]);
      http_response_code(201);
    } else {
      echo json_encode(["message" => "une erreur est survenue"]);
      http_response_code(503);
    }
  } else {
    echo json_encode(["message" => "une erreur est survenue"]);
    http_response_code(405);
  }
}
