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
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $user_id = \Yii::$app->session['loginUser']->id;
        $sql = 'insert into p_community values ';
        $array = array('A','C','V','G','H','W','AB','<1>','AA','AE','O','P','AH','BQ','<null>','<null>','<null>','Z','AG','AK','F','<company>','<0>','<userid>','<now>','<userid>','<now>');
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
                            if($v == 'null') {
                                $sql .= 'null,';

                            } else if($v == 'company') {
                                $sql .= '"' . $company_id . '",';
                            } else if($v == 'userid') {
                                $sql .= '"' . $user_id . '",';
                            } else if($v == 'now') {
                                $sql .= '"' . date('Y-m-d H:i:s') . '",';
                            } else {
                                $sql .= '"' . $v . '",';
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