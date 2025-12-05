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

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPetById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
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
            return true;
        }
        return false;
    }
}
?>