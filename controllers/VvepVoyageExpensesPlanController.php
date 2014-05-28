<?php


class VvepVoyageExpensesPlanController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";


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
            'actions' => array('create', 'admin', 'view', 'update', 'editableSaver', 'delete','ajaxCreate'),
            'roles' => array('Vvoy.VvepVoyageExpensesPlan.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('Vvoy.VvepVoyageExpensesPlan.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('Vvoy.VvepVoyageExpensesPlan.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('Vvoy.VvepVoyageExpensesPlan.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('Vvoy.VvepVoyageExpensesPlan.Delete'),
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
        if ($this->module !== null) {
            $this->breadcrumbs[$this->module->Id] = array('/' . $this->module->Id);
        }
        return true;
    }

    public function actionView($vvep_id, $ajax = false)
    {
        $model = $this->loadModel($vvep_id);
        if($ajax){
            $this->renderPartial('_view-relations_grids', 
                    array(
                        'modelMain' => $model,
                        'ajax' => $ajax,
                        )
                    );
        }else{
            $this->render('view', array('model' => $model,));
        }
    }

    public function actionCreate()
    {
        $model = new VvepVoyageExpensesPlan;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'vvep-voyage-expenses-plan-form');

        if (isset($_POST['VvepVoyageExpensesPlan'])) {
            $model->attributes = $_POST['VvepVoyageExpensesPlan'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'vvep_id' => $model->vvep_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('vvep_id', $e->getMessage());
            }
        } elseif (isset($_GET['VvepVoyageExpensesPlan'])) {
            $model->attributes = $_GET['VvepVoyageExpensesPlan'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($vvep_id)
    {
        $model = $this->loadModel($vvep_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'vvep-voyage-expenses-plan-form');

        if (isset($_POST['VvepVoyageExpensesPlan'])) {
            $model->attributes = $_POST['VvepVoyageExpensesPlan'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'vvep_id' => $model->vvep_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('vvep_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model,));
    }

    public function actionEditableSaver()
    {
        Yii::import('TbEditableSaver');
        $es = new TbEditableSaver('VvepVoyageExpensesPlan'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new VvepVoyageExpensesPlan;
        $model->$field = $value;
        try {
            if ($model->save()) {
                return TRUE;
            }else{
                return var_export($model->getErrors());
            }            
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
    }
    
    public function actionDelete($vvep_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($vvep_id)->delete();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }

            if (!isset($_GET['ajax'])) {
                if (isset($_GET['returnUrl'])) {
                    $this->redirect($_GET['returnUrl']);
                } else {
                    $this->redirect(array('admin'));
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('VvoyModule.crud', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionAdmin()
    {
        $model = new VvepVoyageExpensesPlan('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['VvepVoyageExpensesPlan'])) {
            $model->attributes = $_GET['VvepVoyageExpensesPlan'];
        }

        $this->render('admin', array('model' => $model,));
    }

    public function loadModel($id)
    {
        $m = VvepVoyageExpensesPlan::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('VvoyModule.crud', 'The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vvep-voyage-expenses-plan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
