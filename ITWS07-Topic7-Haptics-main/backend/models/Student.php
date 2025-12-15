<?php
class Student {
    private $conn;
    private $table_name = "students";

    // Student properties
    public $id;
    public $student_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $course;
    public $year_level;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE - Add new student
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET student_id=:student_id,
                    first_name=:first_name,
                    last_name=:last_name,
                    email=:email,
                    phone=:phone,
                    course=:course,
                    year_level=:year_level";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->course = htmlspecialchars(strip_tags($this->course));
        $this->year_level = htmlspecialchars(strip_tags($this->year_level));

        // Bind values
        $stmt->bindParam(":student_id", $this->student_id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":course", $this->course);
        $stmt->bindParam(":year_level", $this->year_level);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ - Get all students
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ ONE - Get single student
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->student_id = $row['student_id'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->course = $row['course'];
            $this->year_level = $row['year_level'];
            return true;
        }
        return false;
    }

    // UPDATE - Update student
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET student_id=:student_id,
                    first_name=:first_name,
                    last_name=:last_name,
                    email=:email,
                    phone=:phone,
                    course=:course,
                    year_level=:year_level
                WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->course = htmlspecialchars(strip_tags($this->course));
        $this->year_level = htmlspecialchars(strip_tags($this->year_level));

        // Bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":student_id", $this->student_id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":course", $this->course);
        $stmt->bindParam(":year_level", $this->year_level);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE - Delete student
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>

