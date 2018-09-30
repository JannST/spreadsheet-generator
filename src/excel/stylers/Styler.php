<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 29.09.18
 * Time: 20:20
 */

namespace ExcelGenerator\Style;

interface Styler
{
    public function applyStyle(\PhpOffice\PhpSpreadsheet\Cell\Cell $cell, $entry, $header);
}