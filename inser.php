<?php
include('pdo_connect.php');
//header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000');

// Get search input from query parameters
$search = isset($_GET['search']) ? $_GET['search'] : 'test';
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'wrong';
echo "<h1> Search Results for $mode: $search</h1>";
echo "<a href='add_song.php'><button class='button'>Add New Song</button></a>";
echo "<a href='http://localhost/App.html'><button class='button'>Back to Search</button></a>"; // Back button
$sql = "";
$parametervalues = array(':search' => '%' . $search . '%');

switch ($mode) {
    case 'artist':

        $sql = "SELECT DISTINCT a.track_artist, s.track_id
        FROM artist a
        INNER JOIN (
            SELECT track_artist, MAX(track_popularity) AS max_popularity
            FROM song
            GROUP BY track_artist
        ) AS s_max ON a.track_artist = s_max.track_artist
        INNER JOIN song s ON a.track_artist = s.track_artist AND s.track_popularity = s_max.max_popularity
        WHERE a.track_artist LIKE CONCAT('%', :search, '%')
        ORDER BY s_max.max_popularity DESC
        LIMIT 100;";

        $results = fetchResults($db, $sql, $parametervalues);
        displayResults($results, 'artist');

        break;

    case 'song':

        $sql =
            "SELECT DISTINCT track_name, track_id
            FROM song
            WHERE track_name LIKE CONCAT('%', :search, '%')
            ORDER BY track_popularity DESC
            LIMIT 100;";

        $results = fetchResults($db, $sql, $parametervalues);
        displayResults($results, 'song');

        break;
    case 'albums':

        $sql =
            "SELECT a.track_album_name, s.track_id
            FROM album a
            INNER JOIN (
                SELECT track_album_id, MAX(track_popularity) AS max_popularity
                FROM song
                GROUP BY track_album_id
            ) AS s_max ON a.track_album_id = s_max.track_album_id
            INNER JOIN song s ON a.track_album_id = s.track_album_id AND s.track_popularity = s_max.max_popularity
            WHERE a.track_album_name LIKE CONCAT('%', :search, '%')
            LIMIT 100;";

        $results = fetchResults($db, $sql, $parametervalues);
        displayResults($results, 'album');
        break;

    case 'genre':
        $sql = "SELECT DISTINCT s.track_name, s.track_id
        FROM playlist p
        JOIN song s ON p.playlist_id = s.playlist_id
        WHERE p.playlist_genre LIKE CONCAT('%', :search, '%')  
            OR p.playlist_subgenre LIKE CONCAT('%', :search, '%')  
        ORDER BY s.track_popularity DESC  
        LIMIT 100";
        $result = fetchResults($db, $sql, $parametervalues);
        displayResults($result, 'playlist');
        break;
    default:
        $sql = "SELECT track_name, track_artist, track_id FROM song WHERE track_name LIKE :search";
        break;
}

function fetchResults($db, $sql, $parametervalues)
{
    //prepare statement class
    $stm = $db->prepare($sql);

    // Execute the statement with named parameters
    $stm->execute($parametervalues);

    // Fetch the result set
    $list = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Return the result set
    return $list;
}

function displayResults($list, $mode)
{
    echo "<style>
            body {
                background-color: #222;
                color: white;
                font-family: Arial, sans-serif;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                background-color: #333;
                color: white;
            }

            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #444;
            }

            .button {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 5px;
            }
        </style>";

    echo "<table>";
    foreach ($list as $item) {
        echo "<tr>";
        foreach ($item as $key => $value) {
            if ($key != 'track_id') {
                echo "<td>$value</td>";
            }
        }
        echo "<td><form method='POST' action='delete.php'><input type='hidden' name='track_id' value='{$item['track_id']}'><input type='hidden' name='mode' value='$mode'><button class='button' type='submit' name='delete'>Delete</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

