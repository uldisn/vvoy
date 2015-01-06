<?php

class DashboardController extends Controller {
    #public $layout='//layouts/column2';

    public $defaultAction = "view";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "vvoy/dashboard";

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('view'),
                //'roles' => array('Vvoy.Dashboard.View'),
                'users' => array('*'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        return true;
    }

    public function actionView($year = false, $week = false) {

        //validate input params
        $model = new vvoy_dashboard();
        $model->year = $year;
        $model->week = $week;
        
        if(!$model->validate()){
            //var_dump($model);exit;
            throw new CHttpException(400, Yii::t('VvoyModule.crud', 'Invalid request. Please do not repeat this request again.'));
        }        

        //get data
        $data = VvoyVoyageReport::timeline($year, $week);
        
        //render view
        $this->render('view', [
            'body_data' => $data['body_data'],
            'date_from' => $data['header_data']['date_from'],
            'date_to' => $data['header_data']['date_to'],
            'urls' => [
                'period_prev'  => $this->createUrl('', [
                    'year' => $data['header_data']['prev_period_year'], 
                    'week' => $data['header_data']['prev_period_week'],
                    ]),
                'period_next'  => $this->createUrl('', [
                    'year' => $data['header_data']['next_period_year'], 
                    'week' => $data['header_data']['next_period_week'],
                    ]),
                'period_today' => $this->createUrl(''),
            ],
        ]);
    }

}
