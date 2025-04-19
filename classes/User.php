<?php

require_once 'database.php';

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
        $this->db = new Dbh();

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Method to save the user to the database(using insert)
    public function save()
     {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'is_active' => $this->is_active ?? 1
        ];

        return $this->db->insert('users', $data);
    }

    // Method to get all users from database(using select)
    public static function getAll() {
        $db = new Dbh();
        $rows = $db->select("SELECT * FROM users WHERE is_active = 1");

        $users = [];
        foreach ($rows as $row) {
            $users[] = new self($row);
        }
        return $users;
    }


    public static function getAllWithPosts() {
        $users = self::getAll();
    
        foreach ($users as $user) {
            $user->posts = Post::getByUserId($user->id);
        }
    
        return $users;
    }
    


}
