<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 28.09.18
 * Time: 19:15
 */

namespace ExcelGenerator;

use Complex\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SpreadsheetGenerator
{
    private $data;
    private $spreadsheet;

    function __construct(DataStruct $data) {
        if($data->entriesSize() < 1)
            throw new Exception("data must have at least 1 entry in it");

        $this->data = $data;
        $this->spreadsheet = new Spreadsheet();
        $this->spreadsheet->setActiveSheetIndex(0);
    }

    public function generateSpreadsheet() {
        $this->writeHeader();
        $this->writeValues();
        $this->applyStyle();
        return $this->spreadsheet;
    }

    private function writeHeader() {
        $worksheet = $this->spreadsheet->getActiveSheet();

        for($i = 0; $i < $this->data->headerSize(); $i++) {
            $worksheet->getCellByColumnAndRow(1, $i+1)->setValue($this->data->getHeaderAt($i));
        }
    }

    private function writeValues() {
        $worksheet = $this->spreadsheet->getActiveSheet();

        for($i = 0; $i < $this->data->entriesSize(); $i++) {
            for($j = 0; $j < $this->data->headerSize(); $j++) {
                $worksheet->getColumnDimensionByColumn($i+2)->setAutoSize(true);
                $cell = $worksheet->getCellByColumnAndRow($i+2, $j+1);
                $cell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $this->data->applyEntryToCell($i,$j,$cell);
            }
        }
    }

    private function applyStyle() {
        $this->spreadsheet->getActiveSheet()->freezePane('B1');

        $this->spreadsheet->getActiveSheet()->getStyle("A1:"."A".$this->data->headerSize())->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFC300');
        $this->spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->spreadsheet->getActiveSheet()->getStyle("A1:"."A".$this->data->headerSize())->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}