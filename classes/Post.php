<?php

require_once 'database.php';

class Post {
    public $id;
    public $user_id;
    public $title;
    public $body;
    public $created_at;
    public $is_active;

    private $db;

    public function __construct($data = []) {
        $this->db = new Dbh();

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

        return $this->db->insert('posts', $data);
    }

    public static function getAll() {
        $db = new Dbh();
        $rows = $db->select("SELECT * FROM posts WHERE is_active = 1");

        $posts = [];
        foreach ($rows as $row) {
            $posts[] = new self($row);
        }
        return $posts;
    }

    public static function getByUserId($user_id) {
        $db = new Dbh();
        $rows = $db->select("SELECT * FROM posts WHERE user_id = :user_id AND is_active = 1", [
            'user_id' => $user_id
        ]);

        $posts = [];
        foreach ($rows as $row) {
            $posts[] = new self($row);
        }
        return $posts;
    }


    public static function getGroupedByHour() {
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
    }
    

    public static function getBirthdayFeed() {
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
    
        return $results;
    }
    

}
