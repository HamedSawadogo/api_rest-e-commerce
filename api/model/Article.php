<?php

class Article
{
  private int $id;
  public function __construct(
    private string $designation,
    private string $url,
    private float $price
  ) {
    $this->designation = $designation;
    $this->url = $url;
    $this->price = $price;
  }

  // setters
  public function setId(int $id)
  {
    if (is_int($id) && isset($id)) {
      $this->id = $id;
    }
  }
  // getters
  public function getId(): int
  {
    return $this->id;
  }
  public function getDesignation(): string
  {
    return $this->designation;
  }

  public function getUrl(): string
  {
    return $this->url;
  }
  public function getPrice(): float
  {
    return $this->price;
  }
  // setters
}
