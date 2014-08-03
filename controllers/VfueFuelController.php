<?php


class VfueFuelController extends Controller
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
            'roles' => array('Vvoy.VfueFuel.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('Vvoy.VfueFuel.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('Vvoy.VfueFuel.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('Vvoy.VfueFuel.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('Vvoy.VfueFuel.Delete'),
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

    public function actionView($vfue_id)
    {
        $model = $this->loadModel($vfue_id);
        $this->render('view', array('model' => $model));
    }

    public function actionCreate()
    {
        $model = new VfueFuel;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'vfue-fuel-form');

        if (isset($_POST['VfueFuel'])) {
            $model->attributes = $_POST['VfueFuel'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'vfue_id' => $model->vfue_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('vfue_id', $e->getMessage());
            }
        } elseif (isset($_GET['VfueFuel'])) {
            $model->attributes = $_GET['VfueFuel'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($vfue_id)
    {
        $model = $this->loadModel($vfue_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'vfue-fuel-form');

        if (isset($_POST['VfueFuel'])) {
            $model->attributes = $_POST['VfueFuel'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'vfue_id' => $model->vfue_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('vfue_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('VfueFuel'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value, $no_ajax = 0) 
    {
        $model = new VfueFuel;
        $model->$field = $value;
        try {
            if ($model->save()) {
                if($no_ajax){
                    $this->redirect(Yii::app()->request->urlReferrer);
                }            
                return TRUE;
            }else{
                return var_export($model->getErrors());
            }            
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
    }
    
    public function actionDelete($vfue_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($vfue_id)->delete();
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
        $model = new VfueFuel('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['VfueFuel'])) {
            $model->attributes = $_GET['VfueFuel'];
        }

        $this->render('admin', array('model' => $model));
    }

    public function loadModel($id)
    {
        $m = VfueFuel::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vfue-fuel-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
