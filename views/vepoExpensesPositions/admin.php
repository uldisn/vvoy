<?php
$this->setPageTitle(
    Yii::t('VvoyModule.model', 'Vepo Expenses Positions')
    . ' - '
    . Yii::t('VvoyModule.crud', 'Manage')
);

?>
    <h1>
        <?php                    
        $this->widget("bootstrap.widgets.TbButton", array(
                        "label"=>Yii::t("VvoyModule.crud","Create"),
                        "icon"=>"icon-plus",
                        "size"=>"large",
                        "type"=>"success",
                        "url"=>array("create"),
                        "visible"=>(Yii::app()->user->checkAccess("Vvoy.VepoExpensesPositions.*") || Yii::app()->user->checkAccess("Vvoy.VepoExpensesPositions.Create"))
                   ));
        ?>
        <?php echo Yii::t('VvoyModule.model', 'Vepo Expenses Positions'); ?>
    </h1>

<div class="row">
    <div class="span7">
<?php Yii::beginProfile('VepoExpensesPositions.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'vepo-expenses-positions-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{summary}{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
            array(
                'name' => 'vepo_name',
            ),
            array(
                'name' => 'vepo_default',
            ),            
            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'false'),
                    'update' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VepoExpensesPositions.Update")'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VepoExpensesPositions.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("vepo_id" => $data->vepo_id))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update", array("vepo_id" => $data->vepo_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("vepo_id" => $data->vepo_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'updateButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('VepoExpensesPositions.view.grid'); ?>
    </div>
</div>