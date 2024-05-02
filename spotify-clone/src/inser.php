<?php
include('pdo_connect.php');
//header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000');

// Get search input from query parameters
$search = isset($_GET['search']) ? $_GET['search'] : 'test';
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'wrong';
echo "<h1> Search Results for $mode: $search</h1>";
echo "<button class='button'>Add New Song</button>";
echo "<a href='http://localhost/app.html'><button class='button'>Back to Search</button></a>"; // Back button
$sql = "";
$parametervalues = array(':search' => '%' . $search . '%');

switch ($mode) {
    case 'artist':

        $sql = "SELECT DISTINCT track_artist, track_id FROM artist 
        WHERE track_artist LIKE :search
        LIMIT 100";

        $results = fetchResults($db, $sql, $parametervalues);
        displayResults($results, 'artist');

        break;

    case 'song':

        $sql =
            "SELECT DISTINCT track_name, DISTINCT track_id 
        FROM song 
        WHERE track_name LIKE :search
        LIMIT 100;";

        $results = fetchResults($db, $sql, $parametervalues);
        displayResults($results, 'song');

        break;
    case 'albums':

        $sql =
            "SELECT track_album_name, track_id FROM album
         WHERE track_album_name LIKE :search
         LIMIT 100;";

        $results = fetchResults($db, $sql, $parametervalues);
        displayResults($results, 'album');
        break;

    case 'genre':
        $sql = "SELECT track_name, track_id FROM playlist WHERE playlist_genre LIKE :search OR playlist_subgenre LIKE :search";
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

