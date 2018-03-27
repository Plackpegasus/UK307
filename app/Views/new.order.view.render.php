<?php
const TEMPLATE ="<option value=\"?index\">?value</option>";

function getRenderdHtml($data)
{
    $html = "";
    for ($i = 0; $i < count($data); $i++)
    {
        $html .=  str_replace("?index", $data["{$i}"]["id"], str_replace("?value", $data["{$i}"]["text"], TEMPLATE));
    }
    return $html;
}