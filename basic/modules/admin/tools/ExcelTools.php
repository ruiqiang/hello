<?php
namespace app\modules\admin\models;

include '/../vendor/phpexcel/Classes/PHPExcel/IOFactory.php';

class ExcelTools
{
    public static function getExcelObject($inputFileName) {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
        return $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    }

    /**
     * 这个方法待完善company_id没写
     * @param $excel
     */
    public static function setDataIntoCommunity($excel) {
        $sql = 'insert into p_community values ';
        $array = array('A','C','V','G','H','W','AB','<1>','AA','AE','O','P','AH','BQ','<null>','<null>','<null>','Z','AG','AK','F','<null>','<null>','<null>','<null>','<null>','<null>');
        foreach($excel as $key=>$value) {
            if($key > 2) {
                if($value['A'] == '') {
                    continue;
                }
                $sql .= '(null,';
                foreach($array as $k=>$v) {
                    if($v == 'BQ') {
                        $xy = explode(",",$value[$v]);
                        if (count($xy) > 1) {
                            $sql .= '"' . $xy[0] . '",';
                            $sql .= '"' . $xy[1] . '",';
                        } else {
                            $sql .= '"' . 'null' . '",';
                            $sql .= '"' . 'null' . '",';
                        }
                    } else {
                        if (strpos($v, ">") <= 0) {
                            $sql .= '"' . $value[$v] . '",';
                        } else {
                            $v = str_replace("<", "", $v);
                            $v = str_replace(">", "", $v);
                            if($v != 'null') {
                                $sql .= '"' . $v . '",';
                            } else {
                                $sql .= 'null,';
                            }
                        }
                    }
                }
                $sql = substr($sql,0,strlen($sql) - 1);
                $sql .= '),';
            }
        }
        $sql = substr($sql,0,strlen($sql) - 1);
        \Yii::$app->db->createCommand($sql)->execute();
    }
}