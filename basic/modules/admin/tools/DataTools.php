<?php
namespace app\modules\admin\models;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/12
 * Time: 14:33
 */
class DataTools {

    /**
     * 拼装dataTable的返回列名json字符串
     * @param $columnsArray
     * @return string
     */
    public static function getDataTablesColumns($columnsArray) {
        if(is_array($columnsArray)) {
            $outString = "[";
            foreach($columnsArray as $key => $col) {
                $outString .= "{\"data\": \"$col\"},";
            }
            $outString .= "]";
            return $outString;
        } else {
            return "";
        }
    }

    /**
     * DataTables要求的Ajax Json数据
     * @param $request 请求
     * @param $order   排序
     * @param $columns 列
     * @param $columnVals 列值字段名
     */
    public static function getJsonData ($request,$order,$columns, $columnVals, $object, $searchField) {
        $seach = $request->get('search');
        $data = $object::find();
        if(isset($seach['value'])) {
            $ar = $data->where("$searchField like \"%" . $seach['value'] . "%\"");
        }
        $length = $request->get('length') ? $request->get('length'):"10";
        $start = $request->get('start') ? $request->get('start'):"0";
        $data = $ar->limit($length)->offset($start)->orderBy("id asc")->all();
        $count = $ar->count();
        $jsonArray = array(
            'draw' => $request->get('draw')?$request->get('draw'):"0",
            'recordsTotal' => $object::find()->count(),
            'recordsFiltered' => $count
        );
        if(count($data) == 0) {
            $jsonArray['data'] = [];
        }
        foreach($data as $key=>$val) {
            foreach($columns as $k => $v) {
                if(is_array($columnVals[$k])) {
                    $tempV = $val;
                    for($temp = 0; $temp < count($columnVals[$k]); $temp++) {
                        $tempV = $tempV->$columnVals[$k][$temp];
                    }
                    $array[$v] = $tempV;
                    continue;
                }
                if(isset($columnVals[$k]) && trim($columnVals[$k]) != "") {
                    $array[$v] = $val->$columnVals[$k];
                }
                else
                    $array[$v] = "";
            }
            $jsonArray['data'][] = $array;
        }
        DataTools::jsonEncodeResponse($jsonArray);
    }

    /**
     * 作为json字符串返回
     * @param $json
     */
    public static function jsonEncodeResponse($json) {
        header('Content-Type: text/json; charset=utf-8');
        echo json_encode($json);exit;
    }
}