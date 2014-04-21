<?php


class VxprVoyageXPersonController extends Controller
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
            'roles' => array('Vvoy.VxprVoyageXPerson.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('Vvoy.VxprVoyageXPerson.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('Vvoy.VxprVoyageXPerson.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('Vvoy.VxprVoyageXPerson.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('Vvoy.VxprVoyageXPerson.Delete'),
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

    public function actionView($vxpr_id)
    {
        $model = $this->loadModel($vxpr_id);
        $this->render('view', array('model' => $model,));
    }

    public function actionCreate()
    {
        $model = new VxprVoyageXPerson;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'vxpr-voyage-xperson-form');

        if (isset($_POST['VxprVoyageXPerson'])) {
            $model->attributes = $_POST['VxprVoyageXPerson'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'vxpr_id' => $model->vxpr_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('vxpr_id', $e->getMessage());
            }
        } elseif (isset($_GET['VxprVoyageXPerson'])) {
            $model->attributes = $_GET['VxprVoyageXPerson'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($vxpr_id)
    {
        $model = $this->loadModel($vxpr_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'vxpr-voyage-xperson-form');

        if (isset($_POST['VxprVoyageXPerson'])) {
            $model->attributes = $_POST['VxprVoyageXPerson'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'vxpr_id' => $model->vxpr_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('vxpr_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model,));
    }

    public function actionEditableSaver()
    {
        Yii::import('TbEditableSaver');
        $es = new TbEditableSaver('VxprVoyageXPerson'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value, $no_ajax = 0) 
    {
        $model = new VxprVoyageXPerson;
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
    
    public function actionDelete($vxpr_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($vxpr_id)->delete();
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
        $model = new VxprVoyageXPerson('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['VxprVoyageXPerson'])) {
            $model->attributes = $_GET['VxprVoyageXPerson'];
        }

        $this->render('admin', array('model' => $model,));
    }

    public function loadModel($id)
    {
        $m = VxprVoyageXPerson::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vxpr-voyage-xperson-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
