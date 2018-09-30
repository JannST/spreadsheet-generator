<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 29.09.18
 * Time: 20:18
 */

namespace ExcelGenerator\Validation;

interface Validator
{
    public function isValid($entry, $header);
}