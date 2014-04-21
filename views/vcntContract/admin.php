<?php
$this->setPageTitle(
    Yii::t('VvoyModule.model', 'Vcnt Contracts')
    . ' - '
    . Yii::t('VvoyModule.crud', 'Manage')
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update(
            'vcnt-contract-grid',
            {data: $(this).serialize()}
        );
        return false;
    });
    ");
?>

    <h1>
        <?php echo Yii::t('VvoyModule.model', 'Vcnt Contracts Manage'); ?>
    </h1>


<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
<?php Yii::beginProfile('VcntContract.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'vcnt-contract-grid',
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
                'name' => 'vcnt_client_ccmp_id',
                'value' => '$data->vcntClientCcmp->ccmp_name',
            ),
            array(
                'name' => 'vcnt_date_from',
            ),
            array(
                'name' => 'vcnt_date_to',
            ),
            array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vcnt_status',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/vvoy/vcntContract/editableSaver'),
                        'source' => $model->getEnumFieldLabels('vcnt_status'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('vcnt_status'),
                ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vcnt_notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('/vvoy/vcntContract/editableSaver'),
                    //'placement' => 'right',
                )
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'false'),
                    'update' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VcntContract.Update")'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VcntContract.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("vcnt_id" => $data->vcnt_id))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update", array("vcnt_id" => $data->vcnt_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("vcnt_id" => $data->vcnt_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'updateButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('VcntContract.view.grid'); ?>