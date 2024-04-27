<?php
include('pdo_connect.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000');
$user=$_GET['search'];

echo 'hello From server '.$user;
echo'<h1>Test</h1>';

// Get search input from query parameters
$search = isset($_POST['search']) ? $_POST['search'] : '';
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'songs';

//Placeholder Query
$sql = "";

switch ($filter) {
    case 'artist':
        $sql = "SELECT * FROM artist WHERE track_artist_name LIKE :search";
        break;
    case 'songs':
        $sql = "SELECT * FROM songs WHERE track_name LIKE :search";
        break;
    case 'albums':
        $sql = "SELECT * FROM albums WHERE track_album_name LIKE :search";
        break;
    case 'genre':
        $sql = "SELECT * FROM playlists WHERE playlist_name LIKE :search";
        break;
    default:
        $sql = "SELECT * FROM songs WHERE track_name LIKE :search";
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


