<?php

class VdimDimensionController extends Controller {
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('ajaxRecalc'),
                'roles' => array('Vvoy.VdimDimension.Create'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionAjaxRecalc($vvoy_id) {
        VdimDimension::recalcVvoyData($vvoy_id, 1);
    }

}
