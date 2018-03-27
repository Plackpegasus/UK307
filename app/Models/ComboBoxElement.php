<?php
class ComboBoxElement
{
    public function renderComboBoxTemplate($value, $text)
    {
      $temp = "<option value=\"?value\">?text</option>";
      $html =  str_replace("?text",  $text, str_replace("?value", $value, $temp));

      return $html;
    }
}