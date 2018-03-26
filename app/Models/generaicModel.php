<?php

function getAllData($querystring)
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare($querystring);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}