<?php
require_once 'app/Models/getModel.php';

const TEMPLATE ="<option value=\"?index\">?value</option>";

function getHtml($query)
{
    $data = getData($query);
    $html = "";

    for ($i = 0; $i < count($data); $i++)
    {
        foreach ($data["{$i}"] as $key => $value)
        {
            $val = $data["{$i}"]["{$key}"];
            $temp =  str_replace("?value", $val, str_replace("?index", $i, TEMPLATE));
            $html .= $temp;
        }
    }

    return $html;
}

require 'app/Views/new.view.php';