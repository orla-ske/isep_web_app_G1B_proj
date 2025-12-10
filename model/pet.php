<?php
class Pet {
    private $conn;
    private $table_name = "Pet";

    public $id;
    public $weight;
    public $name;
    public $age;
    public $breed;
    public $gender;
    public $height;
    public $photo_url;
    public $is_active;
    public $vaccintation_status;
    public $color;
    public $Users_id;

    // Owner properties
    public $owner_first_name;
    public $owner_last_name;
    public $owner_role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPetById($id) {
        $query = "SELECT p.*, u.first_name, u.last_name, u.role 
                  FROM " . $this->table_name . " p
                  LEFT JOIN users u ON p.Users_id = u.id
                  WHERE p.id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->weight = $row['weight'];
            $this->name = $row['name'];
            $this->age = $row['age'];
            $this->breed = $row['breed'];
            $this->gender = $row['gender'];
            $this->height = $row['height'];
            $this->photo_url = $row['photo_url'];
            $this->is_active = $row['is_active'];
            $this->vaccintation_status = $row['vaccintation_status'];
            $this->color = $row['color'];
            $this->Users_id = $row['Users_id'];

            // Map owner details
            $this->owner_first_name = $row['first_name'];
            $this->owner_last_name = $row['last_name'];
            $this->owner_role = $row['role'];

            return true;
        }
        return false;
    }

    public function getAllPets() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserPets($user_id) {
        $query = "SELECT id, name, breed, age, photo_url 
                  FROM " . $this->table_name . " 
                  WHERE Users_id = :user_id 
                  ORDER BY name ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($user_id, $name, $breed, $age, $photo_url = null) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (Users_id, name, breed, age, photo_url) 
                  VALUES (:user_id, :name, :breed, :age, :photo_url)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':photo_url', $photo_url);
        
        return $stmt->execute();
    }

    public function update($id, $name, $breed, $age) {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, breed = :breed, age = :age 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>