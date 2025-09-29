<?php
require_once "database.php";
$db = new database();

class library
{
    public $id = "";
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_date = "";

    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addBook()
    {
        $sql = "INSERT INTO book(title, author, genre, publication_date) VALUE (:title, :author, :genre, :publication_date)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_date", $this->publication_date);

        return $query->execute();
    }

    public function viewBook($genre="", $search="")
    {
        $sql = "SELECT * FROM book WHERE 1";

        if(!empty($genre)) {
            $sql .= " AND genre = :genre";
        }

        $sql .= " ORDER BY title ASC"; 

        $query = $this->db->connect()->prepare($sql);
        
        if (!empty($search)) 
        {
            $like = "%" . $search . "%";
            $query->bindParam(":search", $like, PDO::PARAM_STR);
        }
        if(!empty($genre)) 
        { 
             $query->bindParam(":genre", $genre, PDO::PARAM_STR);
        }
        if($query->execute())
        {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return null;
        }
    }

    public function isBookExist($bTitle)
    {
        $sql = "SELECT COUNT(*) as total_books FROM book WHERE title = :title";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(":title", $bTitle, PDO::PARAM_STR);

        if ($query->execute())
        {
            $record = $query->fetch(PDO::FETCH_ASSOC);
            return $record["total_books"] > 0;
        }

        return false;
    }

    public function fetchBook($b_id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(":id", $b_id);

        if ($query->execute()) {
            return $query->fetch();
        } else {
            return null;
        }
    }

    public function editBook($b_id) {
        $sql = "UPDATE books SET title = :title, author = :author, genre = :genre, publication_year = :publication_year WHERE id=:id";

        $query = $this->db->connect()->prepare($sql);
        
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_date);
        $query->bindParam(":id", $b_id);
        return $query->execute();
    }

    public function deleteBook($b_id, ) {
        $sql = "UPDATE books SET status = 'NOT ACTIVE' WHERE id=:id";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(":id", $b_id);
        return $query->execute();
    }
}