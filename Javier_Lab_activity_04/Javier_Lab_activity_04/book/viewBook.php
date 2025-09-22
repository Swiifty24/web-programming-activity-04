<?php

require_once "../classes/library.php";
$bookObj = new library();

$search = "";
$genre = "";

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $search = isset($_GET["search"]) ? trim(htmlspecialchars($_GET["search"])) : "";
    $genre = isset($_GET["genre"]) ? trim(htmlspecialchars($_GET["genre"])) : "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
</head>
<body>
    <h2>Search</h2>
    <form action="" method="GET">
                <label for="search">Search: </label>
                <input type="search" name="search" id="search" value="<?= $search ?>">
                <select name="genre" id="genre">
                    <option value="" <?= empty($genre) ? "selected" : ""; ?>>-- Select Option --</option>
                    <option value="History" <?= $genre == "history" ? "selected" : ""; ?>>History</option>
                    <option value="Science" <?= $genre == "adventure" ? "selected" : ""; ?>>Science</option>
                    <option value="Fiction" <?= $genre == "fiction" ? "selected" : ""; ?>>Fiction</option>
                </select>
                <input type="submit" value="Search">
    <h1>List of Books</h1>
    <table border="1">
        <tr>
            <td>No.</td>
            <td>Title</td>
            <td>Author</td>
            <td>Genre</td>
            <td>Publication Date</td>
        </tr>
        <?php
        $no = 1;
        foreach($bookObj->viewBook() as $book)
        {
        ?>
        <tr>
            <td><?= $no++?>.</td>
            <td><?= $book["title"] ?></td>
            <td><?= $book["author"] ?></td>
            <td><?= $book["genre"] ?></td>
            <td><?= $book["publication_date"] ?></td>
        </tr>
        <?php
        }
        ?>  
         <a href="addBook.php"><button>Add book</button></a>
    </table>
</body>
</html>