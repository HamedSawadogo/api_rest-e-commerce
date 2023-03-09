<?php

class ArticleManager
{
  // constructeur
  public function __construct(private PDO $connection)
  {
    $this->connection = $connection;
  }
  /**
   * ajouter un article dans la base de Donnée
   */
  public function addArticle(Article $article): bool
  {
    $validExtension = false;
    $extensions = ["jpeg", "png", "jpg"];
    foreach ($extensions as  $extension) {
      $info = new SplFileInfo($article->getUrl());
      if ($info->getExtension() === $extension) {
        $validExtension = true;
      }
    }
    if ($validExtension) {
      $sql = "INSERT INTO article (Designation,prix,url) VALUES(:Designation,:prix,:url)";
      $statements = $this->connection->prepare($sql);
      $statements->execute(array(
        'Designation' => $article->getDesignation(),
        'prix' => $article->getPrice(),
        'url' => $article->getUrl()
      ));
      return true;
    } else return false;
  }
  /**
   * mettre a jour un article dans la base de donnée
   */
  public function updateArticle(Article $article, int $id)
  {
    $sql = "UPDATE article SET Designation=:Designation ,prix=:prix,url=:url where id=:id";
    $statement = $this->connection->prepare($sql);
    $result = $statement->execute(
      [
        "Designation" => $article->getDesignation(),
        "prix" => $article->getPrice(),
        "url" => $article->getUrl(),
        "id" => $id
      ]
    );
    return $result;
  }
  /**
   * supprimer un article dans la base de donnée
   */
  public function deleteArticle($id): bool
  {
    $sql = "DELETE FROM article WHERE id=" . $id;
    $statements = $this->connection->prepare($sql);
    $result = $statements->execute();
    return $result;
  }
  /**
   * recuperer la liste des articles dans la base de donnée
   */
  public function getArticleList(): array
  {
    $sql = "SELECT * FROM article";
    $statements = $this->connection->prepare($sql);
    $statements->execute();
    $articlesList = [];
    while ($article = $statements->fetch()) {
      $newArtilce = new Article($article['Designation'], $article['url'], $article['prix']);
      $newArtilce->setId($article['id']);
      $articlesList[] = $newArtilce;
    }
    return $articlesList;
  }
  // rechercher un article par son nom dans la base de donnée
  public function searchArticle(string $designation): ?Article
  {
    $sql = "SELECT * FROM article WHERE  Designation=?";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam('Designation', $designation);
    $result = $statement->execute();
    if ($statement) {
      return new Article($result['Designation'], $result['url'], $result['prix']);
    }
    return null;
  }
}
