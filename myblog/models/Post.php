<?php
class Post
{
    // DB stuff
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Constractor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Post
    public function read()
    {
        // Create Query
        $query = 'SELECT 
                c.name AS category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY 
                p.created_at DESC';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get Single Post
    public function read_single()
    {
        $query = 'SELECT 
                c.name AS category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT 0,1';


        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->id);

        //Execute Query
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->title = $row['title'];
            $this->category_id = $row['category_id'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->created_at = $row['created_at'];
            $this->category_name = $row['category_name'];
            return true;
        }
        return false;
    }
}