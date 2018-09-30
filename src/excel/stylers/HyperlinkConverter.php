<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 29.09.18
 * Time: 23:01
 */

namespace ExcelGenerator\Style;

use PhpOffice\PhpSpreadsheet\Style\Fill;

class HyperlinkConverter implements Styler
{
    public function applyStyle(\PhpOffice\PhpSpreadsheet\Cell\Cell $cell, $entry, $header)
    {
        if(substr($entry, 0, 4 ) === "http") {
            $cell->setValue("Link")->getHyperlink()->setUrl($entry);
        }
    }
}