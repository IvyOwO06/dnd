<?php

function dbConnect()
{
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $dbName = "personal";

    $conn = new mysqli($serverName, $userName, $password, $dbName, 3307);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function getNotes()
{
    $db = dbConnect();
    $sql = "SELECT * FROM dnd";
    $result = $db->query($sql);
    $notes = $result->fetch_all(MYSQLI_ASSOC);
    return $notes;
}

function displayNotes()
{
    $notes = getNotes();
    foreach ($notes as $note) {
        echo "<div class='note'>";
        echo "<h2>Session: " . htmlspecialchars($note['session']) . "</h2>";
        // Apply nl2br to render <br> for newlines
        echo "<p>" . nl2br(htmlspecialchars($note['note'])) . "</p>";
        echo "</div>";
    }
}