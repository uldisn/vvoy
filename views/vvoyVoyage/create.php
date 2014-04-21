<?php
$this->setPageTitle(
    Yii::t('VvoyModule.model', 'Vvoy Voyage')
    . ' - '
    . Yii::t('VvoyModule.crud', 'Create')
);

?>
    <h1>
        <?php echo Yii::t('VvoyModule.model', 'Vvoy Voyage Create'); ?>
    </h1>

<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
<?php $this->renderPartial('_form', array('model' => $model, 'buttons' => 'create')); ?>
<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>