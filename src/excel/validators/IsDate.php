<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 30.09.18
 * Time: 00:30
 */

namespace ExcelGenerator\Validation;

class IsDate implements Validator
{
public function isValid($entry, $header)
{
    return strtotime($entry) ? true : false;
}
}