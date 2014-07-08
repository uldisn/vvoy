<?php


class DashboardController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "view";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "vvoy/dashboard";  


public function filters()
{
    return array(
        'accessControl',
    );
}

public function accessRules()
{
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

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        return true;
    }

    public function actionView($partial = false)
    {
        $criteria = new CDbCriteria;
        $status = array(
            VvoyVoyage::VVOY_STATUS_NEW,
            VvoyVoyage::VVOY_STATUS_WAY,
            VvoyVoyage::VVOY_STATUS_FINISH,
            );
        $criteria->compare('t.vvoy_status', $status, true);
        $criteria->join .= ' inner join vtrc_truck on vvoy_vtrc_id = vtrc_id';
        $criteria->order = "
                vtrc_car_reg_nr,
                case vvoy_status
                when '".VvoyVoyage::VVOY_STATUS_NEW."' then 1
                when '".VvoyVoyage::VVOY_STATUS_WAY."' then 2
                when '".VvoyVoyage::VVOY_STATUS_FINISH."' then 3
                else 0
                end desc
                 ";
        $vvoy = VvoyVoyage::model()->findAll($criteria);
        
        if($partial){
            $this->renderPartial('view',array('vvoy' => $vvoy));
        }else{
            $this->render('view', array('vvoy' => $vvoy));
        }
    }

}
