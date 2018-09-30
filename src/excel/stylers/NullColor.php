<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 29.09.18
 * Time: 23:01
 */

namespace ExcelGenerator\Style;

use PhpOffice\PhpSpreadsheet\Style\Fill;

class NullColor implements Styler
{

    private $color;

    function __construct($hexColor)
    {
        $this->color = $hexColor;
    }

    public function applyStyle(\PhpOffice\PhpSpreadsheet\Cell\Cell $cell, $entry, $header)
    {
        if($entry === null) {
            $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->color);
        }
    }
}