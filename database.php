<?php

class Dbh {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "buisnessdb";
    private $charset = "utf8";
    private $conn;

    public function __construct() {
        echo "Running constructor...<br>";
        $this->connect();
    }

    public function connect() {
        echo "Trying to connect...<br>";
        try {
            $dsn = "mysql:host={$this->servername};dbname={$this->dbname};charset={$this->charset}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
            echo "✅ Connected successfully<br>";
        } catch (PDOException $e) {
            echo "❌ Connection failed: " . $e->getMessage();
            exit;
        }
    }

    public function select($query, $params = []) {
        if ($this->conn === null) {
            echo "❌ ERROR: \$this->conn is null<br>";
            exit;
        }

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query error: " . $e->getMessage();
            return [];
        }
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(fn($k) => ":$k", array_keys($data)));

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function update($table, $data, $where) {
        $set = implode(", ", array_map(fn($k) => "$k = :$k", array_keys($data)));
        $query = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function delete($table, $where, $params = []) {
        $query = "DELETE FROM $table WHERE $where";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }
}
