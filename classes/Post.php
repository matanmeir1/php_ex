<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/Logger.php';



class Post {
    public $id;
    public $user_id;
    public $title;
    public $body;
    public $created_at;
    public $is_active;

    private $db;

    public function __construct($data = []) {
        try {
            $this->db = new Dbh();
        } catch (Exception $e) {
            Logger::logMessage("Failed to initialize DB in Post::__construct(): " . $e->getMessage());
            throw $e;
        }
    
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    

    public function save() {
        $data = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'body' => $this->body,
            'created_at' => $this->created_at ?? date('Y-m-d H:i:s'),
            'is_active' => $this->is_active ?? 1
        ];

        try 
        {
            $this->db->insert('posts', $data);
            Logger::logMessage("Post inserted: " . json_encode($data));
            return true;
        } catch (Exception $e) {
            Logger::logMessage("Failed to insert post: " . $e->getMessage());
            throw $e;
        }
    }

    public static function getAll() {
        try {
            $db = new Dbh();
            $rows = $db->select("SELECT * FROM posts WHERE is_active = 1");
    
            $posts = [];
            foreach ($rows as $row) {
                $posts[] = new self($row);
            }
    
            return $posts;
        } catch (Exception $e) {
            Logger::logMessage("Error in Post::getAll(): " . $e->getMessage());
            return [];
        }
    }
    



    public static function getByUserId($user_id) {
        try {
            $db = new Dbh();
            $rows = $db->select("SELECT * FROM posts WHERE user_id = :user_id AND is_active = 1", [
                'user_id' => $user_id
            ]);
    
            $posts = [];
            foreach ($rows as $row) {
                $posts[] = new self($row);
            }
    
            Logger::logMessage("Retrieved posts for user_id: $user_id (count: " . count($posts) . ")");
            return $posts;
        } catch (Exception $e) {
            Logger::logMessage("Error in Post::getByUserId($user_id): " . $e->getMessage());
            return [];
        }
    }
    


    public static function getGroupedByHour() {
        try {
            $db = new Dbh();
            return $db->select("
                SELECT 
                    DATE(created_at) AS post_date,
                    HOUR(created_at) AS post_hour,
                    COUNT(*) AS post_count
                FROM posts
                WHERE is_active = 1
                GROUP BY post_date, post_hour
                ORDER BY post_date DESC, post_hour DESC
            ");
        } catch (Exception $e) {
            Logger::logMessage("Error in Post::getGroupedByHour(): " . $e->getMessage());
            return [];
        }
    }
    
    

    public static function getBirthdayFeed() {
        try {
            $db = new Dbh();
    
            $results = $db->select("
                SELECT 
                    posts.id,
                    posts.user_id,
                    posts.title,
                    posts.body,
                    posts.created_at,
                    posts.is_active,
                    users.name AS user_name,
                    users.email,
                    users.birth_date
                FROM posts
                JOIN users ON users.id = posts.user_id
                WHERE MONTH(users.birth_date) = MONTH(CURDATE())
                  AND posts.created_at = (
                      SELECT MAX(created_at)
                      FROM posts
                      WHERE posts.user_id = users.id
                        AND posts.is_active = 1
                  )
                  AND users.is_active = 1
                  AND posts.is_active = 1
                ORDER BY posts.created_at DESC
            ");
    
            Logger::logMessage("Retrieved birthday feed (count: " . count($results) . ")");
            return $results;
        } catch (Exception $e) {
            Logger::logMessage("Error in Post::getBirthdayFeed(): " . $e->getMessage());
            return [];
        }
    }
    
    

}
