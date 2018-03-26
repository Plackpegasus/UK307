<?php
/**
 * Stellt eine Verbindung zur Datenbank her und gibt die
 * Datenbankverbindung als PDO zurück.
 *
 * @return PDO
 */
function connectToDatabase($includeDbName = true)
{
    $dbName = $includeDbName ? ';dbname=' . CONFIG["databaseName"] : '';
    return new PDO('mysql:host=' . CONFIG["databaseHost"] . $dbName, CONFIG["databaseUser"], CONFIG["databasePassword"], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]);
}