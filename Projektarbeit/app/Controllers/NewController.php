<?php
require_once 'app/Models/getModel.php';

const TEMPLATE ="<option value=\"?value\">?value</option>";

function getHtml($query)
{
    $data = getData($query);
    $html = "";

    for ($i = 0; $i < count($data); $i++)
    {
        foreach ($data["{$i}"] as $key => $value)
        {
            $val = $data["{$i}"]["{$key}"];
            $html .=  str_replace("?value", $val, TEMPLATE);
        }
    }

    return $html;
}

require 'app/Views/new.view.php';