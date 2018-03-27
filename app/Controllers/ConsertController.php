<?php

$conserts = [];

createAllConserts();

function getAllConserts()
{
    return getAllData(SELECTS_CONSERTS["CONSTRUCTOR"]["ALL"]);
}

function createAllConserts()
{
    global $conserts;

    $conserts = [];
    $data = getAllConserts();

    for ($index = 0; $index < count($data); $index++)
    {
        $consert = new Concert($data["{$index}"]["id"], $data["{$index}"]["name"]);
        array_push($conserts, $consert);
    }
}

function renderConsertComboxBoxElements()
{
    global $conserts;
    $html = "";

    for ($index = 0; $index < count($conserts); $index++)
    {
        $consert = $conserts[$index];
        $html .=  $consert->renderComboBoxTemplate($consert->getId(), $consert->getConcert());
    }

    return $html;
}