<?php
include('pdo_connect.php');

if (isset($_POST['delete']) && isset($_POST['track_id']) && isset($_POST['mode'])) {
    $track_id = $_POST['track_id'];
    $mode = $_POST['mode'];
    
    // Prepare and execute SQL statement to delete record
    $sql = "DELETE FROM $mode WHERE track_id = :track_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':track_id', $track_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the previous page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    // Redirect back to the previous page
    echo"<h1>error</h1>";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>
