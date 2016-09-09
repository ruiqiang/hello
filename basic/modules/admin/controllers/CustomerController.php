<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\IsNavigation;

class CustomerController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        return $this->render('customerManager');
    }

    public function actionJson($draw = 1, $start = 0, $length = 10)
    {
        $seach = \Yii::$app->request->get('search');
        $data = IsNavigation::find();
        if(isset($seach['value'])) {
            $ar = $data->where("id like \"%" . $seach['value'] . "%\"");
        }
        $data = $ar->limit($length)->offset($start)->orderBy("id asc")->all();
        $count = $ar->count();
        $jsonArray = array(
            'draw' => $draw,
            'recordsTotal' => IsNavigation::find()->count(),
            'recordsFiltered' => $count
        );
        if(count($data) == 0) {
            $jsonArray['data'] = [];
        }
        foreach($data as $key=>$nav) {
            $array = array (
                "company" => $nav->id,
                "contact" => $nav->navi_name,
                "edit" => $nav->content,
                "name" => $nav->last_modified,
                "phone" => "13851871381",
            );
            $jsonArray['data'][] = $array;
        }
        header('Content-Type: text/json; charset=utf-8');
        echo json_encode($jsonArray);
        exit;
    }
}
