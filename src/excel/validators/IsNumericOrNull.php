<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 30.09.18
 * Time: 00:30
 */

namespace ExcelGenerator\Validation;

class IsNumericOrNull implements Validator
{
public function isValid($entry, $header)
{
    if(is_numeric($entry) || $entry === null)
        return true;
    return false;
}
}