<?php

require_once "../classes/library.php";
$bookObj = new library();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
</head>
<body>
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