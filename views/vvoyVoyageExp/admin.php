<?php
$this->setPageTitle(Yii::t('VvoyModule.model', 'Voyages expenses'));
?>

    <h1>
        &nbsp<i class="icon-road"></i>  
        <?php echo Yii::t('VvoyModule.model', 'Voyages expenses'); ?>
    </h1>

<?php 

Yii::beginProfile('VvoyVoyage.view.grid'); 
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
                'name' => 'vvoy_fcrn_id',
                'value' => '$data->vvoyFcrn->fcrn_code',
            ),            
            array(
                'header' => Yii::t('VvoyModule.model', 'Freight'),
                'value' => '$data->freightPlanTotal',
                'htmlOptions' => array('class' => 'numeric-column'),
            ),
            array(
                'header' => Yii::t('VvoyModule.model', 'Expenses'),
                'value' => '$data->expensesPlanTotal',
                'htmlOptions' => array('class' => 'numeric-column'),
            ),
            array(
                'header' => Yii::t('VvoyModule.model', 'Fuel'),
                'value' => '$data->fuelPlanTotalAmt',
                'htmlOptions' => array('class' => 'numeric-column'),
            ),
            array(
                'header' => Yii::t('VvoyModule.model', 'Diff.'),
                'value' => '$data->freightPlanTotal - $data->fuelPlanTotalAmt - $data->expensesPlanTotal',
                'htmlOptions' => array('class' => 'numeric-column'),
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
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'FALSE'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("vvoy_id" => $data->vvoy_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);

Yii::endProfile('VvoyVoyage.view.grid');