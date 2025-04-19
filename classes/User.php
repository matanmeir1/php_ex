<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/Logger.php';
require_once __DIR__ . '/Post.php';

class User {
    public $id;
    public $name;
    public $email;
    public $birth_date;
    public $is_active;
    public $posts = [];

    private $db;

    // Constructor
    public function __construct($data = []) {
        try {
            $this->db = new Dbh();
        } catch (Exception $e) {
            Logger::logMessage("Failed to initialize DB in User::__construct(): " . $e->getMessage());
            throw $e;
        }

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Method to save the user to the database (using insert)
    public function save() {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'is_active' => $this->is_active ?? 1
        ];

        try {
            $this->db->insert('users', $data);
            Logger::logMessage("User inserted: " . json_encode($data));
            return true;
        } catch (Exception $e) {
            Logger::logMessage("Failed to insert user: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to get all users from database (using select)
    public static function getAll() {
        try {
            $db = new Dbh();
            $rows = $db->select("SELECT * FROM users WHERE is_active = 1");

            $users = [];
            foreach ($rows as $row) {
                $users[] = new self($row);
            }

            Logger::logMessage("Retrieved all users (count: " . count($users) . ")");
            return $users;
        } catch (Exception $e) {
            Logger::logMessage("Error in User::getAll(): " . $e->getMessage());
            return [];
        }
    }

    // Method to get all users and attach their posts
    public static function getAllWithPosts() {
        try {
            $users = self::getAll();

            foreach ($users as $user) {
                $user->posts = Post::getByUserId($user->id);
            }

            Logger::logMessage("Retrieved all users with posts (count: " . count($users) . ")");
            return $users;
        } catch (Exception $e) {
            Logger::logMessage("Error in User::getAllWithPosts(): " . $e->getMessage());
            return [];
        }
    }
}
