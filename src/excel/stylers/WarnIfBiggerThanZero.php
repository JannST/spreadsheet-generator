<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 29.09.18
 * Time: 23:01
 */

namespace ExcelGenerator\Style;

use PhpOffice\PhpSpreadsheet\Style\Fill;

class WarnIfBiggerThanZero implements Styler
{

    public function applyStyle(\PhpOffice\PhpSpreadsheet\Cell\Cell $cell, $entry, $header)
    {
        if($entry == 0) {
            $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB("bcff6b");
        }
        else if($entry > 0) {
            $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB("ff4f4f");
        }
    }
}