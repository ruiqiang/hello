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
        $seach = $request->get('search', "");
        $data = $object::find();
        $ar = $data;
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
                        if($tempV != null) {
                            if(is_array($columnVals[$k][$temp])) {
                                foreach($columnVals[$k][$temp] as $kkk=>$vvv) {
                                    $tempV = $tempV->$kkk->$vvv;
                                }
                            } else {
                                $tempV = $tempV->$columnVals[$k][$temp];
                            }
                        } else {
                            $tempV = "";
                        }
                    }
                    $array[$v] = $tempV;
                    continue;
                }
                if(isset($columnVals[$k]) && trim($columnVals[$k]) != "" && strpos($columnVals[$k], '<') !== 0) {
                    $array[$v] = $val->$columnVals[$k];
                }
                else {
                    $array[$v] = "";
                    $bindRoleHtml = "<a href='javascript:;' staff_id='" . $val->id . "' class='btn btn-success btn-xs bindRole'>关联角色</a>";
                    $editRoleHtml = "<a href='javascript:;' role_id='" . $val->id . "' class='btn btn-success btn-xs roleEditName'>更新权限名</a>";
                    $editHtml = "<a href='javascript:;' role_id='" . $val->id . "' class='btn btn-success btn-xs roleEdit'>编辑</a>";
                    $deleteHtml = '<a href=\'javascript:;\' role_id=\'\" . $val->id . \"\' class=\'btn btn-danger btn-xs roleDelete\'>删除</a>';
                    $nbsp = "&nbsp;&nbsp;";
                    if(strpos($columnVals[$k], '<') === 0) {
                        $html = substr($columnVals[$k],1);
                        $html = substr($html,0,strlen($html)-1);
                        $htmlArray = explode(',',$html);
                        foreach($htmlArray as $element) {
                            if($element == 'editrole')
                                $array[$v] .= $editRoleHtml . $nbsp;
                            if($element == 'edit')
                                $array[$v] .= $editHtml . $nbsp;
                            if($element == 'delete')
                                $array[$v] .= $deleteHtml . $nbsp;
                            if($element == 'bindrole')
                                $array[$v] .= $bindRoleHtml . $nbsp;
                        }
                    } else {
                        $array[$v] = $editHtml . $nbsp . $deleteHtml;
                    }
                }
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

    /**
     * 将2维的单列数组写成1维的有序数组
     * array('0'=>array('menu_id' = > 1)) ==> array(1)
     * @param $d2array
     * @return array
     */
    public static function put2dArrayTo1d($d2array) {
        $array = array();
        foreach($d2array as $d1array) {
            foreach($d1array as $value) {
                $array[] = $value;
            }
        }
        return $array;
    }
}