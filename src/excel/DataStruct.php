<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 29.09.18
 * Time: 19:59
 */

namespace ExcelGenerator;


use ExcelGenerator\Style\Styler;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

class DataStruct
{
    private $header;
    private $validators;
    private $stylers;
    private $entries;

    function __construct(array $header)
    {
        if(count($header) == 0) {
            throw new \Exception("There must be a least one entry in header");
        }

        $this->header = $header;


        $this->stylers = array();
        $this->validators = array();
    }

    public function setEntries(array $data) {
        $hCount = count($this->header);
        for($i = 0; $i < count($data); $i++) {

            $entry = $data[$i];
            if(!is_array($entry)) {

                throw new \Exception("all items in data must be of type array but is of type " . get_class($entry));
            }
            if(count($entry) != $hCount) {
                throw new \Exception("all items in data must have length $hCount");
            }
            for ($j = 0; $j < $hCount; $j++) {
                $this->validateValue($j, $data[$i][$j]);
            }
        }
        $this->entries = $data;
    }

    public function applyEntryToCell($row, $col, Cell $cell) {
        $entry = $this->getEntryAt($row, $col);

        $cell->setValue($entry);
        $this->applyStyle($col, $cell, $entry);
    }

    function applyStyle($index, Cell $cell, $entry) {
        $header = $this->getHeaderAt($index);
        if(array_key_exists($header, $this->stylers)) {
            foreach ($this->stylers[$header] as $styler) {
                $styler->applyStyle($cell, $entry, $header);
            }
        }
    }

    private function validateValue($index, $entry) {
        $header = $this->getHeaderAt($index);

        if(array_key_exists($header, $this->validators)) {
            foreach ($this->validators[$header] as $validator) {
                if(!$validator->isValid($entry, $header))
                    throw new \Exception("value \"$entry\" under header \"$header\" does not match ".get_class($validator));
            }
        }
        return true;
    }

    public function addStyler($headValue, Styler $styler) {
        if(!in_array($headValue, $this->header))
            throw new \Exception("$headValue is not a value in header");

        $this->stylers[$headValue][] = $styler;
    }

    public function addStylerAll(Styler $styler) {
        foreach ($this->header as $headerValue) {
            $this->addStyler($headerValue, $styler);
        }
    }

    public function addValidator($headValue, $validator) {
        if(!in_array($headValue, $this->header))
            throw new \Exception("$headValue is not a value in header");
        $this->validators[$headValue][] = $validator;
    }

    public function entriesSize() {
        return count($this->entries);
    }

    public function headerSize() {
        return count($this->header);
    }

    public function getHeader() {
        return $this->header;
    }

    public function getValues() {
        return $this->entries;
    }

    function getHeaderAt($index) {
        if($index >= count($this->header))
            throw new \Exception("Index out of bounds");

        return $this->header[$index];
    }

    public function getEntryAt($row, $col) {
        if($row >= count($this->entries) || $col >= count($this->header))
            throw new \Exception("Index out of bounds");

        return $this->entries[$row][$col];
    }
}