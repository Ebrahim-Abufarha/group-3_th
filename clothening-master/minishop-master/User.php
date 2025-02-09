<?php
class User {
    private $conn;
    private $table_name = 'users';

    public $user_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone;
    public $address;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return false; // Email already exists
        }
    
        $query = "INSERT INTO users (first_name, last_name, email, password, phone, address, role) 
                  VALUES (:first_name, :last_name, :email, :password, :phone, :address, :role)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':role', $this->role);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login() {
        $query = 'SELECT user_id, first_name, last_name, email, password, role FROM ' . $this->table_name . ' WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $row['password'])) {
                $this->user_id = $row['user_id'];
                $this->first_name = $row['first_name'];
                $this->last_name = $row['last_name'];
                $this->role = $row['role'];
                $_SESSION['user_id'] = $this->user_id;
                $_SESSION['first_name'] = $this->first_name;

                $_SESSION['user_role'] = $this->role;
                return true;
            }
        }
        return false;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>