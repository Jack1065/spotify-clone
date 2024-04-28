<?php
include('pdo_connect.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000');

echo 'hello From server '.$user;
echo'<h1>Test</h1>';

// Get search input from query parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'song';

//Placeholder Query
$sql = "";

switch ($filter) {
    case 'artist':
        $sql = "SELECT * FROM artist WHERE track_artist_name LIKE :search";
        break;
    case 'song':
        $sql = "SELECT * FROM song WHERE track_name LIKE :search";
        break;
    case 'albums':
        $sql = "SELECT * FROM albums WHERE track_album_name LIKE :search";
        break;
    case 'genre':
        $sql = "SELECT * FROM playlists WHERE playlist_name LIKE :search";
        break;
    default:
        $sql = "SELECT * FROM song WHERE track_name LIKE :search";
}

$parametervalues = array(':search' => '%' . $search . '%');

$results = fetchResults($db, $sql, $parametervalues);
echo json_encode($results);


function fetchResults($db, $sql, $parametervalues = null)
{
    //prepare statement class
    $stm = $db->prepare($sql);

    // Execute the ststement with named parameters
    $stm->execute($parametervalues);

    // Fetch the result set
    $list = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Return the result set
    return $list;
}




?>


