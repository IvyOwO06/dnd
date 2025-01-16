<?php

require("inc/functions.php");

$conn = dbConnect(); // Assign the return value to $conn

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['notesFile'])) {
    // File upload details
    $fileTmpPath = $_FILES['notesFile']['tmp_name'];
    $fileName = $_FILES['notesFile']['name'];
    $fileSize = $_FILES['notesFile']['size'];
    $fileType = $_FILES['notesFile']['type'];
    $fileError = $_FILES['notesFile']['error'];

    // Check if the file is a valid .txt file
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    if ($fileExtension !== 'txt') {
        die("Invalid file type. Only .txt files are allowed.");
    }

    // Read the file content
    $notes = file_get_contents($fileTmpPath);
    if ($notes === false) {
        die("Failed to read the uploaded file.");
    }

    // Remove any carriage return and newline characters (\r, \n)
    $notes = str_replace(array("\r", "\n"), ' ', $notes);  // Replace them with spaces or remove as needed

    // Escape the text to prevent SQL issues
    $notes = mysqli_real_escape_string($conn, $notes);

    // Current timestamp
    $time = date("Y-m-d H:i:s");

    // Get session name from the form
    $session = $_POST['session'];

    // Use a prepared statement to insert into the database
    $stmt = $conn->prepare("INSERT INTO dnd (note, session, date) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    // Bind parameters and execute the query
    $stmt->bind_param("sss", $notes, $session, $time);

    // Execute and check for errors
    if ($stmt->execute()) {
        header('Location: success.php');
        exit();
    } else {
        die("Database error: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}

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
    <h2>Upload your dnd notes here</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>Which session?</p>
        <input type="text" name="session" required><br>
        <label for="notesFile">Upload a .txt file:</label>
        <input type="file" name="notesFile" accept=".txt" required><br>
        <input type="submit"><br>
        <a href="notes.php">notes</a>
    </form>
</body>

</html>