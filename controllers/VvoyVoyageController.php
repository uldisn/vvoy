<?php


class VvoyVoyageController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "vvoy/vvoyVoyage";  


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
            'roles' => array('Vvoy.VvoyVoyage.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('Vvoy.VvoyVoyage.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('Vvoy.VvoyVoyage.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('Vvoy.VvoyVoyage.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('Vvoy.VvoyVoyage.Delete'),
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

    public function actionView($vvoy_id,$ajax = false)
    {
        $model = $this->loadModel($vvoy_id);
        
        if($ajax){
            //ajax
            if($ajax == 'vvoy-voyage-total-grid'){
                //$total_model = VvoyVoyage::model()->findByPk($vvoy_id);
                $this->renderPartial('/vvoyVoyageExp/_total', 
                        array(
                            'model' => $model,
                            'ajax' => $ajax,
                            )
                        );                
            }elseif($ajax == 'vcrt-vvoy-currency-rate-grid'){
                $this->renderPartial('_grid_vcrt', 
                        array(
                            'modelMain' => $model,
                            'ajax' => $ajax,
                            )
                        );
            }else{
                $this->renderPartial('_view-relations_grids', 
                        array(
                            'modelMain' => $model,
                            'ajax' => $ajax,
                            )
                        );
            }
        }else{
            //full
            $total_model = VvoyVoyage::model()->findByPk($vvoy_id);
            $this->render('view', array(
                                    'model' => $model,
                                )
                            );
        }
    }

    public function actionCreate()
    {
        $model = new VvoyVoyage;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'vvoy-voyage-form');

        if (isset($_POST['VvoyVoyage'])) {
            $model->attributes = $_POST['VvoyVoyage'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'vvoy_id' => $model->vvoy_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('vvoy_id', $e->getMessage());
            }
        } elseif (isset($_GET['VvoyVoyage'])) {
            $model->attributes = $_GET['VvoyVoyage'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($vvoy_id)
    {
        $model = $this->loadModel($vvoy_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'vvoy-voyage-form');

        if (isset($_POST['VvoyVoyage'])) {
            $model->attributes = $_POST['VvoyVoyage'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'vvoy_id' => $model->vvoy_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('vvoy_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model,));
    }

    public function actionEditableSaver()
    {
        //Yii::import('EditableSaver');
        $es = new EditableSaver('VvoyVoyage'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value, $no_ajax = false) 
    {
        $model = new VvoyVoyage;
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
    
    public function actionDelete($vvoy_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($vvoy_id)->delete();
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
        $model = new VvoyVoyage('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['VvoyVoyage'])) {
            $model->attributes = $_GET['VvoyVoyage'];
        }

        $this->render('admin', array('model' => $model,));
    }

    public function loadModel($id)
    {
        $m = VvoyVoyage::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vvoy-voyage-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
