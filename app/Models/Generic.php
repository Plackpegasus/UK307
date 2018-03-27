<?php

function getAllData($querystring)
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare($querystring);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFirstColumn($querystring)
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare($querystring);
    $stmt->execute();
    return $stmt->fetchColumn(0);
}