<?php
const CONFIG = [
    "databaseHost" => "localhost",
    "databaseName" => "konsert_tickets",
    "databaseUser" => "root",
    "databasePassword" => "",
    "databaseDumpFileName" => "database/db.sql",
    "mysqlExecutable" => "C:/xampp/mysql/bin/mysql.exe",
    "mysqlDumpExecutable" => "C:/xampp/mysql/bin/mysqldump.exe",
    "nameOfContentTable" => "tickets_tab",
    "content" => [
        /* Wenn nur ein "name"-Feld existiert (also Name und Vorname nicht getrennt sind), kann einfach beide Male das gleiche Feld eingetragen werden. */
        "firstnameField" => ["htmlName" => "name", "databaseName" => "name"],
        "lastnameField" => ["htmlName" => "name", "databaseName" => "name"],
        "emailField" => ["htmlName" => "user-email", "databaseName" => "email"],
        "telField" => ["htmlName" => "user-phonenumber", "databaseName" => "phonenumber"],
        /*dynamicallyCalculatedField: Feld wo Mitgliedschafts-Status, Dringlichkeit, Treuebonus, Risikostufe oder Anzahl Raten gespeichert wird. */
        "dynamicallyCalculatedField" => ["htmlName" => "procends", "databaseName" => "fk_id_discount"],
        /*choosableItemField: Fled wo Ausgeleihtes Video, Betreffendes Werkzeug, Konzert, Hypo-Paket, Kredit-Paket oder Frucht gespeichert wird. */
        "choosableItemField" => ["htmlName" => "conzertds", "databaseName" => "fk_id_concert"],
        "calculatedDateField" => ["databaseName" => "buy_date"],
        "stateField" => ["htmlName" => "status", "databaseName" => "fk_id_status"],
    ],
    "contentValuesSuccessful" => [
        /* Wenn nur ein "name"-Feld existiert (also Name und Vorname nicht getrennt sind), kann einfach beide Male das gleiche Feld eingetragen werden. */
        "firstnameField" => "Hans",
        "lastnameField" => "Muster",
        "emailField" => "hans.muster@musterdomain.com",
        "telField" => "041 123 45 66",
        /*dynamicallyCalculatedField: Feld wo Mitgliedschafts-Status, Dringlichkeit, Treuebonus, Risikostufe oder Anzahl Raten gespeichert wird. */
        "dynamicallyCalculatedField" => "2",
        /*choosableItemField: Fled wo Ausgeleihtes Video, Betreffendes Werkzeug, Konzert, Hypo-Paket, Kredit-Paket oder Frucht gespeichert wird. */
        "choosableItemField" => "2",
        "stateField" => "0"
    ],
    "routes" => [
        "listItemRoute" => "EDIT",
        "addItemRoute" => "NEWORDER",
        "editItemRoute" => "EDIT"
    ]
];