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

    public function readOne()
    {
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

    public function create()
    {
        //filter les données
        $product_name = htmlspecialchars(strip_tags($this->name));
        $product_description = htmlspecialchars(strip_tags($this->description));
        $product_price = htmlspecialchars(strip_tags($this->price));
        $product_category_id = htmlspecialchars(strip_tags($this->category_id));

        $sql = "INSERT INTO `produits` (`nom`, `description`, `prix`, `categories_id`) VALUES (:name, :description, :price, :category_id)";
        $query = $this->connexion->prepare($sql);
        try {
            $query->execute([
                ":name" => "$product_name",
                ":description" => "$product_description",
                ":price" => "$product_price",
                ":category_id" => "$product_category_id"
            ]);
            return $query;
        } catch (PDOException $e) {
            echo "Erreur execute requete Create :" . '' . $e->getMessage();
        }
    }

    public function delete(){
        $product_id = htmlspecialchars(strip_tags($this->id));
        $sql = "DELETE from produits where id = :id";
        $query = $this->connexion->prepare($sql);
        try {
            $query->execute([
                ":id" => "$product_id"
            ]);
            return $query;
        } catch (PDOException $e) {
            echo "Erreur execute requete DELETE :" . '' . $e->getMessage();
        }
        
    }

    public function update()
    {
        //filter les données
        $product_id = htmlspecialchars(strip_tags($this->id));
        $product_name = htmlspecialchars(strip_tags($this->name));
        $product_description = htmlspecialchars(strip_tags($this->description));
        $product_price = htmlspecialchars(strip_tags($this->price));
        $product_category_id = htmlspecialchars(strip_tags($this->category_id));
        $sql = "UPDATE `produits` set nom = :name, 
                                      description = :description, 
                                      prix = :price, 
                                      categories_id = :category_id
                                      where id = :id";
        $query = $this->connexion->prepare($sql);
        try {
            $query->execute([
                ":name" => "$product_name",
                ":description" => "$product_description",
                ":price" => "$product_price",
                ":category_id" => "$product_category_id",
                ":id" => "$product_id"
            ]);
            return $query;
        } catch (PDOException $e) {
            echo "Erreur execute requete Update :" . '' . $e->getMessage();
        }
    }
}
