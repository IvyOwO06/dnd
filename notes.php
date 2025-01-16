<?php

require('inc/functions.php');

$conn = dbConnect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <h1>D&D Notes</h1>
    <h2>The dnd notes will be displayed here</h2>
    <?php 
    displayNotes();
    ?>
    <a href="index.php">Return</a>
</body>
</html>