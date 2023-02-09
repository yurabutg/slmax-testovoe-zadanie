<?php

class Database
{
    private string $host = '127.0.0.1';
    private string $username = '********';
    private string $password = '********';
    private string $db_name = 'test';
    private int $port = 8889;
    private string $table_name = 'users';
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name;port=$this->port", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function getById($id)
    {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user === false) {
                    return [];
                }
                return $user;
            }
        } catch (PDOException $exception) {
            echo "Get user error: " . $exception->getMessage();
        }

        return [];
    }


    public function saveUser($user)
    {
        if (isset($user['id'])) {
            $query = "UPDATE {$this->table_name} SET first_name=:first_name, last_name=:last_name, birth_date=:birth_date, gender=:gender, birth_city=:birth_city WHERE id={$user['id']}";
        } else {
            $query = "INSERT INTO {$this->table_name} (first_name, last_name, birth_date, gender, birth_city) 
                      VALUES (:first_name, :last_name, :birth_date, :gender, :birth_city)";
        }

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':first_name', $user['first_name']);
            $stmt->bindParam(':last_name', $user['last_name']);
            $stmt->bindParam(':birth_date', $user['birth_date']);
            $stmt->bindParam(':gender', $user['gender']);
            $stmt->bindParam(':birth_city', $user['birth_city']);

            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $exception) {
            echo "Save user error: " . $exception->getMessage();
        }

        return false;
    }

    public function getUsersIdsByConditions(string $field, string $condition, $value): array
    {
        try {
            $query = "SELECT id FROM {$this->table_name} WHERE {$field} {$condition} :value";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':value', $value);

            if ($stmt->execute()) {
                $user_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
                if ($user_ids === false) return [];
                return $user_ids;
            }
        } catch (PDOException $exception) {
            echo "Get users error: " . $exception->getMessage();
        }

        return [];
    }


    public function deleteById($id)
    {
        try {
            $query = "DELETE FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $exception) {
            echo "Delete user error: " . $exception->getMessage();
        }

        return false;
    }
}
