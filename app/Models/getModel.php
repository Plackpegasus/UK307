<?php

function getData($query)
{
    $conn = connectToDatabase();
    $sth = $conn->prepare($query);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}