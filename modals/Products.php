<?php

class Products
{
    //connexion
    private $connexion;

    // Propriétés
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_nom;
    public $created_at;

    public function __construct(PDO $db)
    {
        $this->connexion = $db;
    }
   

    public function readAll()
    {
        $sql = "SELECT * FROM produits";
        $query = $this->connexion->prepare($sql);
        try {
            $query->execute();
            return $query;
        } catch (PDOException $e) {
            echo "Erreur execute requete read all :" . '' . $e->getMessage();
        }
    }

    public function readOne(){
        $product_id = htmlspecialchars(strip_tags($this->id));
        $sql = "SELECT * from produits where id = :id";
        $query = $this->connexion->prepare($sql);
        try {
            $query->execute([":id" => "$product_id"]);
            return $query;
        } catch (PDOException $e) {
            echo "Erreur execute requete read One :" . '' . $e->getMessage();
        }

    }

    public function create(){

        $sql = "INSERT INTO `produits` (`nom`, `description`, `prix`, `categories_id`) VALUES (:name, :discriptiuon, :price, :category_id)";
        $query = $this->connexion->prepare($sql);
        try {
            $query->execute([
                ":name" => "$this->name", 
                ":discriptiuon" => "$this->description",
                ":price" => "$this->price",
                ":category_id" => "$this->category_id"
            ]); 
            return $query;
        }  catch (PDOException $e) {
            echo "Erreur execute requete Create :" . '' . $e->getMessage();
        }

    }
}
