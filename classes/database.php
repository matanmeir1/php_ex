<?php


require_once __DIR__ . '/Logger.php';


class Dbh 
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "buisnessdb";
    private $charset = "utf8";
    private $conn;


    // Constructor
    public function __construct() {
        try {
            $this->connect();
            Logger::logMessage("DB connection initialized.");
        } catch (Exception $e) {
            Logger::logMessage("DB constructor failed: " . $e->getMessage());
            throw $e; 
        }
    }
    

    // Connect to the database
    public function connect()
    {
    try {
        $dsn = "mysql:host={$this->servername};dbname={$this->dbname};charset={$this->charset}";
        $this->conn = new PDO($dsn, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Logger::logMessage("DB connected successfully.");
        return $this->conn;
    } catch (PDOException $e) {
        Logger::logMessage("DB connection failed: " . $e->getMessage());
        throw $e; 
    }
    }



    //SELECT
    public function select($query, $params = [])
    {
    if ($this->conn === null) {
        Logger::logMessage("select() failed: no DB connection");
        throw new Exception("Database connection is not initialized.");
    }

    try {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        Logger::logMessage("Query error in select(): " . $e->getMessage());
        throw $e;
    }
    }


    //INSERT
    public function insert($table, $data) 
    {
    if (empty($table)) {
        Logger::logMessage("No table provided to insert into.");
        throw new Exception("No table provided to insert into.");
    }

    if (empty($data)) {
        Logger::logMessage("No data provided to insert into $table.");
        throw new Exception("No data provided to insert into $table.");
    }

    try {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(fn($k) => ":$k", array_keys($data)));

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);

        $success = $stmt->execute($data);

        if (!$success) {
            Logger::logMessage("Failed to insert into $table: " . json_encode($data));
            throw new Exception("Failed to insert into $table.");
        } else {
            Logger::logMessage("✅ Inserted into $table: " . json_encode($data));
        }

        return $success;
    } catch (PDOException $e) {
        Logger::logMessage("Insert error in $table: " . $e->getMessage());
        throw $e;
    }
    }


    //UPDATE
    public function update($table, $data, $where) 
    {
    if (empty($table)) {
        $msg = "Update failed: No table provided.";
        Logger::logMessage($msg);
        throw new Exception($msg);
    }

    if (empty($data)) {
        $msg = "Update failed: No data provided for table '$table'.";
        Logger::logMessage($msg);
        throw new Exception($msg);
    }

    if (empty($where)) {
        $msg = "Update failed: WHERE clause is missing for table '$table'.";
        Logger::logMessage($msg);
        throw new Exception($msg);
    }

    try {
        $set = implode(", ", array_map(fn($k) => "$k = :$k", array_keys($data)));
        $query = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);

        if ($stmt->rowCount() === 0) {
            $msg = "Update warning: No rows affected in table '$table'. Data may be identical or item not found.";
            Logger::logMessage($msg);
            throw new Exception($msg);
        }

        Logger::logMessage("Update successful in table '$table' with data: " . json_encode($data));
        return true;
    } catch (PDOException $e) {
        Logger::logMessage("Update error in table '$table': " . $e->getMessage());
        throw $e;
    }
    }

    

    //DELETE
    public function delete($table, $where, $params = []) 
    {
    if (empty($table)) {
        $msg = "Delete failed: No table provided.";
        Logger::logMessage($msg);
        throw new Exception($msg);
    }

    if (empty($where) || trim($where) === '') {
        $msg = "Delete failed: WHERE clause is missing.";
        Logger::logMessage($msg);
        throw new Exception($msg);
    }

    try {
        $query = "DELETE FROM $table WHERE $where";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        if ($stmt->rowCount() === 0) {
            $msg = "Delete warning: No rows deleted from '$table'. Item may not exist.";
            Logger::logMessage($msg);
            throw new Exception($msg);
        }

        Logger::logMessage("Delete successful from table '$table'. WHERE: $where. Params: " . json_encode($params));
        return true;
    } catch (PDOException $e) {
        Logger::logMessage("Delete error in table '$table': " . $e->getMessage());
        throw $e;
    }
    }




    // todo - write to log func
}
