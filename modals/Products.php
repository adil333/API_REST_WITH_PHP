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
    public function create()
    {
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
}
