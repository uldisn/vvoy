<?php
$this->setPageTitle(
    Yii::t('VvoyModule.model', 'Vvoy Voyages')
    . ' - '
    . Yii::t('VvoyModule.crud', 'Manage')
);
?>

    <h1>
        <?php echo Yii::t('VvoyModule.model', 'Vvoy Voyages Manage'); ?>
    </h1>


<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
<?php Yii::beginProfile('VvoyVoyage.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'vvoy-voyage-grid',
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
                'name' => 'vvoy_ccmp_id',
                'value' => '$data->vvoyCcmp->ccmp_name',                
            ),
            array(
                'name' => 'vvoy_number',
            ),
            array(
                'name' => 'vvoy_vtrc_id',
                'value' => '$data->vvoyVtrc->vtrc_car_reg_nr',                                
            ),
            array(
                'name' => 'vvoy_vtrl_id',
                'value' => '$data->vvoyVtrl->vtrl_reg_nr',                                                

            ),
            array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvoy_status',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                        'source' => $model->getEnumFieldLabels('vvoy_status'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('vvoy_status'),
                ),
            array(
                'name' => 'vvoy_start_date',
            ),
            array(
                'name' => 'vvoy_end_date',
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vvoy_notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                    //'placement' => 'right',
                )
            ),            
            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.View")'),
                    'update' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.Update")'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("vvoy_id" => $data->vvoy_id))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update", array("vvoy_id" => $data->vvoy_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("vvoy_id" => $data->vvoy_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'updateButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('VvoyVoyage.view.grid'); ?>