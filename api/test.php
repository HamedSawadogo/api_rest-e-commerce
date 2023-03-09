<?php

require_once "./manager/ArticleManager.php";
require_once "./config/Database.php";
require_once "./model/Article.php";

$db = Database::getConnection();
$manager = new ArticleManager($db);

$imageUrl = "http://s1.lprs1.fr/images/2021/10/22/8436147_apple-macbookair-cdiscount.jpg";
$article = new Article("Television Sumsung", $imageUrl, 225000);

// var_dump($manager->addArticle($article));
// // $manager->updateArticle($article,2);
// // var_dump();
// print_r($manager->getArticleList());

$articlesList = $manager->getArticleList();
$newArtilce = [];
foreach ($articlesList as $key => $value) {
  $newArtilce[] = [
    'id' => $value->getId(),
    'designation' => $value->getDesignation(),
    'url' => $value->getUrl(),
    'prix' => $value->getPrice()
  ];
}

var_dump($newArtilce);
