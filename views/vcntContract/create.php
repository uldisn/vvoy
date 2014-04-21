<?php
$this->setPageTitle(
    Yii::t('VvoyModule.model', 'Vcnt Contract')
    . ' - '
    . Yii::t('VvoyModule.crud', 'Create')
);

?>

    <h1>
        <?php echo Yii::t('VvoyModule.model', 'Vcnt Contract Create'); ?>
    </h1>

<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
<?php $this->renderPartial('_form', array('model' => $model, 'buttons' => 'create')); ?>
<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>