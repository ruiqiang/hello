<?php
namespace app\modules\admin\models;

include '/../vendor/phpexcel/Classes/PHPExcel/IOFactory.php';

class ExcelTools
{
    public static function getExcelObject($inputFileName) {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
        return $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    }

    public static function getData() {
        $excel = ExcelTools::getExcelObject('C:\Users\ruiqiang\Desktop\1.xlsx');
        foreach($excel as $key=>$value) {
            if($key > 2) {
                echo $value['V'] . "....<br>";
            }
        }
        exit;
    }
}