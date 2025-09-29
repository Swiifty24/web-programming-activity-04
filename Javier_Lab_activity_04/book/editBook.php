<?php 

require_once "../classes/book.php";
$bookObj = new library();

$book = [];
$errors = [];
$b_id = "";
if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['id'])) {
        $b_id = trim(htmlspecialchars($_GET['id']));
        $book = $bookObj->fetchBook($b_id);

        if(!$book) {
            echo "<a href='viewBook.php'>View Product</a>";
            exit("No Book Found");
        }

    } else {
        echo "<a href='viewBook.php'>View Product</a>";
        exit("No Book Found");
    }

} else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_date"]));

    if(empty($book["title"])){
        $errors["title"] = "Title is Required";
    }else if ($bookObj->isBookExist($book["title"])){
         $errors["title"] = "Book Title Already Exist";
    }

    if(empty($book["author"])){
        $errors["author"] = "Author is Required";
    }

    if(empty($book["genre"])){
        $errors["genre"] = "Please Select a Genre";
    }

    if(empty($book["publication_year"])){
        $errors["publication_year"] = "Publication Year is Required";
    } else if (!is_numeric($book["publication_year"])){
        $errors["publication_year"] = "Invalid Publication Year Format";
    } else if ($book["publication_year"] > date('Y')){
        $errors["publication_year"] = "Publication Year can't be in the Future";
    }

    if(empty(array_filter($errors))){
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_date = $book["publication_date"];

        if($bookObj->editBook($_GET['id'])){
            header("location: viewBook.php");
        }else {
            echo "FAILED";
        }
    }
}

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>ADD BOOK</h1>
            <form action="" method="POST">
                <label for="" class="form-note">Field with <span>*</span> is required</label>
        
                <label for="title">Book Title: <span>*</span></label>
                <input type="text" name="title" id="" value="<?= $book["title"] ?? "" ?>">
                <p class="errors"><?= $errors["title"] ?? ""?></p>
        
                <label for="author">Book Author: <span>*</span></label>
                <input type="text" name="author" id="" value="<?= $book["author"] ?? ""?>">
                <p class="errors"><?= $errors["author"] ?? ""?></p>
        
                <label for="genre">Genre <span>*</span></label>
                <select name="genre" id="">
                    <option value="">--Select Option--</option>
                    <option value="History" <?= isset($book["genre"]) && ($book["genre"] == "History") ? "selected" : "" ?>>History</option>
                    <option value="Science" <?= isset($book["genre"]) && ($book["genre"] == "Science") ? "selected" : "" ?>>Science</option>
                    <option value="Fiction" <?= isset($book["genre"]) && ($book["genre"] == "Fiction") ? "selected" : "" ?>>Fiction</option>
                </select>
                <p class="errors"><?= $errors["genre"] ?? ""?></p>
        
                <label for="publication_year">Publication Year: <span>*</span></label>
                <input type="text" name="publication_year" id="" value="<?= $book["publication_year"] ?? ""?>">
                <p class="errors"><?= $errors["publication_year"] ?? ""?></p>
                <br>
                <select name="status" id="">
                    <option value="ACTIVE">active</option>
                    <option value="NOT ACTIVE">not active</option>
                </select>
                <input type="submit" value="Save Product">
            </form>
        </div>
    </div>
</body>
</html>