<?php
include('pdo_connect.php');
header('Access-Control-Allow-Origin: http://localhost:3000');
$user=$_GET['search'];

echo 'hello From server '.$user;
echo'<h1>Test</h1>';








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


