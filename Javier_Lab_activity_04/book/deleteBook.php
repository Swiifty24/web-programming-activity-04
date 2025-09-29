<?php 
    require_once "../classes/book.php";
    $bookObj = new library();

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        if(isset($_GET['id'])) {
            $b_id = trim(htmlspecialchars($_GET['id']));
            $book = $bookObj->fetchBook($b_id);
    
            if(!$book) {
                echo "<a href='viewBook.php'>View Product</a>";
                exit("No Book Found");
            } else {
                $bookObj->deleteBook($b_id);
                header("location: viewBook.php");
            }
    
        } else {
            echo "<a href='viewBook.php'>View Product</a>";
            exit("No Book Found");
        }
    }
?>