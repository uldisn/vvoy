<?php
if(!$ajax){
    Yii::app()->clientScript->registerCss('rel_grid',' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');     
}
?>


<?php
if(!$ajax || $ajax == 'vvcl-voyage-client-grid'){
    Yii::beginProfile('vvcl_vvoy_id.view.grid');
?>

<div class="table-header">
    <?=Yii::t('VvoyModule.model', 'Vvcl Voyage Client')?>
    <?php    
        
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'ajaxButton', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vvclVoyageClient/ajaxCreate',
                'field' => 'vvcl_vvoy_id',
                'value' => $modelMain->primaryKey,
                'ajax' => 'vvcl-voyage-client-grid',
            ),
            'ajaxOptions' => array(
                    'success' => 'function(html) {
                                    $.fn.yiiGridView.update(\'vvcl-voyage-client-grid\');
                                    reload_total_grid();
                                 }'
                    ),
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Add new record'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    ?>
</div>
<?php 

    if (empty($modelMain->vvclVoyageClients)) {
        $model = new VvclVoyageClient;
        $model->vvcl_vvoy_id = $modelMain->primaryKey;
        $model->save();
        unset($model);
    } 
    
    $model = new VvclVoyageClient();
    $model->vvcl_vvoy_id = $modelMain->primaryKey;

// render grid view

$this->widget('TbGridView',
    array(
        'id' => 'vvcl-voyage-client-grid',
        'dataProvider' => $model->search(),
        'template' => '{summary}{items}',
        'htmlOptions' => array(
            'class' => 'rel-grid-view'
        ),         
        'summaryText' => '&nbsp;', 
            'columns' => array(
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvcl_ccmp_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvclVoyageClient/editableSaver'),
                        'source' => CHtml::listData(CcmpCompany::model()->userSysCompanyCompanies()->findAll(array('limit' => 1000)), 'ccmp_id', 'itemLabel'),                        
                        //'placement' => 'right',
                    )
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvcl_vcnt_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvclVoyageClient/editableSaver'),
                        'source' => CHtml::listData(VcntContract::model()->findAll(array('limit' => 1000)), 'vcnt_id', 'itemLabel'),                        
                        //'placement' => 'right',
                    )
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvcl_notes',
                    'editable' => array(
                        'type' => 'textarea',
                        'url' => $this->createUrl('//vvoy/vvclVoyageClient/editableSaver'),
                        //'placement' => 'right',
                    )
                ),
                array(
                    'name' => 'vvcl_plan_fcrn_id',
                    //'value' => '$data->vvclPlanFcrn->fcrn_code',
                ),
                array(
                    'name' => 'vvcl_plan_freight',
                    'htmlOptions' => array('class' => 'numeric-column'),                    
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvcl_fcrn_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvclVoyageClient/editableSaver'),
                        'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                        'success' => 'function(response, newValue) { 
                                        reload_total_and_start_end_grid()
                                      }',
                        //'placement' => 'right',
                    )
                ),                
                array(
                    //decimal(8,2)
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvcl_freight',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvclVoyageClient/editableSaver'),
                        //'placement' => 'right',
                        'success' => 'function(response, newValue) { 
                                        reload_total_and_start_end_grid()
                                      }',

                    ),
                    'htmlOptions' => array('class' => 'numeric-column'),
                ),
                array(
                    'class' => 'TbButtonColumn',
                    'buttons' => array(
                        'view' => array('visible' => 'FALSE'),
                        'update' => array('visible' => 'FALSE'),
                        'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.DeletevvclVoyageClients")'),
                    ),
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/vvoy/vvclVoyageClient/delete", array("vvcl_id" => $data->vvcl_id))',
                    'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),                    
                ),
            )
        )
    );


    Yii::endProfile('VvclVoyageClient.view.grid');
}    
?>

<?php
if(!$ajax || $ajax == 'vfue-fuel-grid'){
//if(false){
    Yii::beginProfile('vfue_vvoy_id.view.grid');
    
    /**
     * get payment documents for all drivers
     */
    //get draivers
    $model_persons = $modelMain->vxprVoyageXPeople;
    $persons = array();
    foreach ($model_persons as $mp){
        $persons[] = $mp->vxpr_pprs_id;
    }
    
    //if no drivers, cann not add payment documents
    $warning = '';
    if(count($persons) == 0){
        $warning = Yii::t('VvoyModule.model', 'Pleas add driver(s) to voyage. Can not add payment docoments!');
    }
    
    //get documents
    $payment_doc_type = $this->module->driver_payment_docs;
    $payment_doc = PpxdPersonXDocument::model()->filterByDocTypeAndPerson($payment_doc_type,$persons)->findAll(array('limit' => 1000));
    
    //create list data
    if(count($persons) > 1){
        // if more one driver show document with driver name
        $payment_doc_list_data = CHtml::listData($payment_doc, 'ppxd_id', 'itemLabelExtended');
    }elseif(count($persons) == 1){
        $payment_doc_list_data = CHtml::listData($payment_doc, 'ppxd_id', 'itemLabel');
    }else{
        
    }    
?>

<div class="table-header">
    <?=Yii::t('VvoyModule.model', 'Vfue Fuel')?>
    <?php    
   
    
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'ajaxButton', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vfueFuel/ajaxCreate',
                'field' => 'vfue_vvoy_id',
                'value' => $modelMain->primaryKey,
                'ajax' => 'vfue-fuel-grid',
            ),
            'ajaxOptions' => array(
                    'success' => 'function(html) {
                                    $.fn.yiiGridView.update(\'vfue-fuel-grid\');
                }'
                    ),
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Add new record'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    ?>
    <span class="label label-warning"><?php echo $warning?></span>
</div>
 
<?php 

    if (empty($modelMain->vfueFuels)) {
        $model = new VfueFuel;
        $model->vfue_vvoy_id = $modelMain->primaryKey;
        $model->save();
        unset($model);
    } 
    
    $model = new VfueFuel();
    $model->vfue_vvoy_id = $modelMain->primaryKey;

    // render grid view
    $this->widget('TbGridView',
        array(
            'id' => 'vfue-fuel-grid',
            'dataProvider' => $model->search(),
            'template' => '{summary}{items}',
            'summaryText' => '&nbsp;',
            'htmlOptions' => array(
                'class' => 'rel-grid-view'
            ),            
            'columns' => array(
                array(
                //varchar(100)
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_number',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_date',
                'editable' => array(
                    'type' => 'date',
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    'success' => 'function(response, newValue) { 
                                    reload_total_and_start_end_grid()
                    }',                    
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_fcrn_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),
                    'success' => 'function(response, newValue) { 
                                    reload_total_and_start_end_grid()
                    }',                                        
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(10)
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_fuel_type',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(10,2)
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_qnt',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                    'success' => 'function(response, newValue) { 
                                    reload_total_and_start_end_grid()
                    }',                                        
                )
            ),
            array(
                //decimal(10,2) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_amt',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                    'success' => 'function(response, newValue) { 
                                    reload_total_and_start_end_grid()
                    }',                                        
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_ppxd_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    'source' => $payment_doc_list_data,
                    //'placement' => 'right',
                )
            ),                
            /*    
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_base_fcrn_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(10,2) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_base_amt',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            */
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vfue_notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('//vvoy/vfueFuel/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            

                array(
                    'class' => 'TbButtonColumn',
                    'buttons' => array(
                        'view' => array('visible' => 'FALSE'),
                        'update' => array('visible' => 'FALSE'),
                        'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.DeletevfueFuels")'),
                    ),
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/vvoy/vfueFuel/delete", array("vfue_id" => $data->vfue_id))',
                    'deleteConfirmation'=>Yii::t('VvoyModule.crud','Do you want to delete this item?'),   
                    'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),                    
                ),
            )
        )
    );
    ?>

<?php
    Yii::endProfile('VfueFuel.view.grid');
}

if(!$ajax || $ajax == 'vexp-expenses-grid'){
    Yii::beginProfile('vexp_vvoy_id.view.grid');
?>

<div class="table-header">
    <?=Yii::t('VvoyModule.model', 'Vexp Expenses')?>
    <?php    
        
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'ajaxButton', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vexpExpenses/ajaxCreate',
                'field' => 'vexp_vvoy_id',
                'value' => $modelMain->primaryKey,
                'ajax' => 'vexp-expenses-grid',
            ),
            'ajaxOptions' => array(
                    'success' => 'function(html) {$.fn.yiiGridView.update(\'vexp-expenses-grid\');}'
                    ),
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Add new record'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    ?>
</div>
 
<?php 

    if (empty($modelMain->vexpExpenses)) {
        $model = new VexpExpenses;
        $model->vexp_vvoy_id = $modelMain->primaryKey;
        $model->save();
        unset($model);
    } 
    
    $model = new VexpExpenses();
    $model->vexp_vvoy_id = $modelMain->primaryKey;

    // render grid view

    $this->widget('TbGridView',
        array(
            'id' => 'vexp-expenses-grid',
            'dataProvider' => $model->search(),
            'template' => '{summary}{items}',
            'summaryText' => '&nbsp;',
            'htmlOptions' => array(
                'class' => 'rel-grid-view'
            ),            
            'columns' => array(
                array(
                'name' => 'vepo_name',
                'value' => '$data->vexpVepo->itemLabel',
                ),
                array(
                    'name' => 'fcrn_name',
                    'value' => '$data->vexpFixr->fixrFcrn->itemLabel',
                ),
                array(
                    'name' => 'fixr_amt',
                    'value' => '$data->vexpFixr->fixr_amt',
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vexp_notes',
                    'editable' => array(
                        'type' => 'textarea',
                        'url' => $this->createUrl('//vvoy/vexpExpenses/editableSaver'),
                        //'placement' => 'right',
                    )
                ),

            )
        )
    );
    ?>

<?php
    Yii::endProfile('VexpExpenses.view.grid');
}