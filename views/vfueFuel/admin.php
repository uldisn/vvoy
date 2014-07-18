<?php
$this->setPageTitle(
    Yii::t('VvoyModule.model', 'Vfue Fuels')
    . ' - '
    . Yii::t('VvoyModule.crud', 'Manage')
);

$this->breadcrumbs[] = Yii::t('VvoyModule.model', 'Vfue Fuels');
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update(
            'vfue-fuel-grid',
            {data: $(this).serialize()}
        );
        return false;
    });
    ");
?>

<?php $this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
    <h1>

        <?php echo Yii::t('VvoyModule.model', 'Vfue Fuels'); ?>
        <small><?php echo Yii::t('VvoyModule.crud', 'Manage'); ?></small>

    </h1>


<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
<?php Yii::beginProfile('VfueFuel.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'vfue-fuel-grid',
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
                'class' => 'CLinkColumn',
                'header' => '',
                'labelExpression' => '$data->itemLabel',
                'urlExpression' => 'Yii::app()->controller->createUrl("view", array("vfue_id" => $data["vfue_id"]))'
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_id',
                'editable' => array(
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_vvoy_id',
                'value' => 'CHtml::value($data, \'vfueVvoy.itemLabel\')',                    
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    'source' => CHtml::listData(VvexVoyageExpenses::model()->findAll(array('limit' => 1000)), 'vvex_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_number',
                'editable' => array(
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_date',
                'editable' => array(
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_fcrn_id',
                'value' => 'CHtml::value($data, \'vfueFcrn.itemLabel\')',                    
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_fuel_type',
                'editable' => array(
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_qnt',
                'editable' => array(
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_amt',
                'editable' => array(
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            /*
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_base_fcrn_id',
                'value' => 'CHtml::value($data, \'vfueBaseFcrn.itemLabel\')',                    
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'vfue_base_amt',
                'editable' => array(
                    'url' => $this->createUrl('/vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            #'vfue_notes',
            */

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VfueFuel.View")'),
                    'update' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VfueFuel.Update")'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VfueFuel.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("vfue_id" => $data->vfue_id))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update", array("vfue_id" => $data->vfue_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("vfue_id" => $data->vfue_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'updateButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('VfueFuel.view.grid'); ?>