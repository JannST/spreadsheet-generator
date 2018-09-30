<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 29.09.18
 * Time: 19:26
 */

namespace ExcelGenerator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class SpreadsheetReader
{

    private $spreadsheet;
    private $data;

    function __construct(Spreadsheet $spreadsheet, DataStruct $data = null)
    { //throws exception
        $this->spreadsheet = $spreadsheet;
        $this->data = $data;
    }

    public function getData() {
        $header = $this->readHeader();
        if($this->data != null) {
            if($this->data->getHeader() != $header) {
                throw new \Exception("Header of input does not match header of given structure");
            }
        } else
            $this->data = new DataStruct($header);

        $values = $this->readeValues($this->data->headerSize());
        $this->data->setEntries($values);
        return $this->data;
    }

    private function readHeader() {
        $header = array();

        $i = 1;
        while(true) {
            $cell = $this->spreadsheet->getActiveSheet()->getCellByColumnAndRow(1,$i);
            if($cell->getValue() !== null) {
                $header[] = $cell->getValue();
            } else {
                break;
            }
            $i++;
        }
        return $header;
    }

    private function readeValues($hSize) {
        $values = array();

        $i = 2;
        while(true) {
            $isNull = true;
            $row = array();
            for($j = 1; $j <= $hSize; $j++) {
                $entry = $this->spreadsheet->getActiveSheet()->getCellByColumnAndRow($i,$j)->getValue();
                if($entry !== null)
                    $isNull = false;
                $row[] = $entry;
            }

            if(!$isNull) {
                $values[] = $row;
            } else
                break;
            $i++;
        }
        return $values;
    }
}