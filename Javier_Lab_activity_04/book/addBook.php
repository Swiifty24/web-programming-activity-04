<?php

require_once "../classes/library.php";
$bookObj = new library();

$book = ["title"=>"", "author"=>"", "genre"=>"", "publication_date"=>""];
$bookError = ["title"=>"", "author"=>"", "genre"=>"", "publication_date"=>""];

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_date"] = trim(htmlspecialchars($_POST["publication_date"]));

    if(empty($book["title"]))
    {
        $bookError["title"] = "Book title is required";
    }
    if(empty($book["author"]))
    {
        $bookError["author"] = "Book author is required";
    }
    if(empty($book["genre"]))
    {
        $bookError["genre"] = "Book genre is required";
    }
    if(empty($book["publication_date"]))
    {
        $bookError["publication_date"] = "Book publication date must be provided";
    }
    if(strtotime($book["publication_date"]) < strtotime(date("Y-d-M")))
    {
        echo "publication date should not be greater than the date today";
    }

    if(empty(array_filter($bookError)))
    {
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_date = $book["publication_date"];

        if($bookObj->addBook())
        {
            header("Location: viewBook.php");
        }
        else
        {
            echo "failed";
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h1>Add Book</h1>
        <form action="addBook.php" method="POST">
        <label for="">For field with <span>*</span> is required</label><br><br>
        <label for="title">Book Title:</label>
            <input type="text" name="title" id="title">
            <p class="error"><span>*</span> <?= $bookError["title"] ?></p>
            <label for="author">Book Author:</label>
            <input type="text" name="author" id="author">
            <p class="error"><span>*</span> <?= $bookError["author"] ?></p>
            <label for="genre">Book Genre:</label>
            <select name="genre" id="genre">
                <option value="no_genre">--Select a Genre--</option>
                <option value="fiction">fiction</option>
                <option value="history">history</option>
                <option value="adventure">adventure</option>
            </select>
            <p class="error"><span>*</span> <?= $bookError["genre"] ?></p>
            <label for="publication_date">Publication Date:</label>
            <input type="date" name="publication_date" id="publication_date">
            <p class="error"><span>*</span> <?= $bookError["publication_date"] ?></p>
            <input type="submit" value="Add Book">
    </div>
   
    </form>
</body>
</html>