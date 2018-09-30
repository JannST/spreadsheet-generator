<?php
/**
 * Created by PhpStorm.
 * User: pfand
 * Date: 28.09.18
 * Time: 17:30
 */

require_once __DIR__.'/../vendor/autoload.php';

use ExcelGenerator\SpreadsheetGenerator;
use ExcelGenerator\DataStruct;
use ExcelGenerator\Style\NullColor;
use ExcelGenerator\Style\WarnIfBiggerThanZero;
use ExcelGenerator\Style\HyperlinkConverter;
use ExcelGenerator\Validation\IsNumericOrNull;
use ExcelGenerator\Validation\IsDate;
use ExcelGenerator\SpreadsheetReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



$dummyData = [["John","22-12-1996", 24.386592, "https://www.google.de",0],["Albert","24-01-1996 16:22:59", 13, "https://myhouse.com",0],["Mickey", "24-01-1996 16:22:59", 20.5, "https://www.wichmann-geigen.de",3], ["Gustav", "24-01-1996 16:22:59", null, "https://www.gustav.de",0]];
$data = genExampleStruct();
$data->setEntries($dummyData);
//write($data);

$data = genExampleStruct();
read($data);

function genExampleStruct() {
    $header = ["Name", "Birthday", "Age", "HomePage", "Failures in life"];
    $data = new DataStruct($header);

    $data->addValidator("Age", new IsNumericOrNull());
    $data->addValidator("Birthday", new IsDate());

    $data->addStylerAll(new NullColor("bfc1d5"));
    $data->addStylerAll(new HyperlinkConverter());
    $data->addStyler("Failures in life", new WarnIfBiggerThanZero());

    return $data;
}

function write(DataStruct $data) {
    $writer = new SpreadsheetGenerator($data);

    $writer = new Xlsx($writer->generateSpreadsheet());
    $writer->save('excel_example.xlsx');
    echo "======================================== Wrote this data\n";
    print_r($data);
}

function read(DataStruct $data) {
    $spreadsheet = IOFactory::load('excel_example.xlsx');
    $reader = new SpreadsheetReader($spreadsheet, $data);
    $data = $reader->getData();
    echo "======================================== Read this data\n";
    print_r($data);
}