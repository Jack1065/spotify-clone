<?php
include('pdo_connect.php'); // Include your PDO connection script

function generateRandomId($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $maxIndex = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $maxIndex)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $songName = $_POST['song_name'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];

    // Generate a random track_id
    $trackId = generateRandomId(20);

    // Insert into 'song' table
    $insertSongSql = "INSERT INTO song (track_id, track_name, track_artist) VALUES (:trackId, :songName, :artist)";
    $stmtSong = $db->prepare($insertSongSql);
    $stmtSong->bindParam(':trackId', $trackId);
    $stmtSong->bindParam(':songName', $songName);
    $stmtSong->bindParam(':artist', $artist);
    $stmtSong->execute();

    // Insert into 'album' table (if album name is provided)
    if (!empty($album)) {
        $trackAlbumName = $album;
        $insertAlbumSql = "INSERT INTO album (track_album_name) VALUES (:trackId, :trackAlbumName)";
        $stmtAlbum = $db->prepare($insertAlbumSql);
        $stmtAlbum->bindParam(':trackAlbumName', $trackAlbumName);
        $stmtAlbum->execute();
    }

    // Redirect back to app.php after adding song
    header("Location: app.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Song</title>
    <style>
        body {
            background-color: #222;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            color: #4CAF50;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #4CAF50;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            background-color: #333;
            color: white;
        }

        button[type="submit"], button[type="button"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }

        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h2>Add New Song</h2>
    <form method="POST" action="add_song.php">
        <label for="song_name">Song Name:</label>
        <input type="text" id="song_name" name="song_name" required>

        <label for="artist">Artist:</label>
        <input type="text" id="artist" name="artist" required>

        <label for="album">Album:</label>
        <input type="text" id="album" name="album">

        <button type="submit">Add Song</button>
        <a href="app.html"><button type="button">Back to App</button></a>
    </form>
</body>

</html>