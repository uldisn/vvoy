<?php
$this->setPageTitle(
        Yii::t('VvoyModule.model', 'Vpnt Point')
        . ' - '
        . Yii::t('VvoyModule.crud', 'Update')
        . ': '   
        . $model->getItemLabel()
);    
?>

    <h1>
        <?php echo Yii::t('VvoyModule.model','Vpnt Point Update'); ?>
    </h1>

<?php 
$this->renderPartial("_toolbar", array("model"=>$model));
$this->renderPartial('_form', array('model' => $model));
$this->renderPartial("_toolbar", array("model"=>$model)); 