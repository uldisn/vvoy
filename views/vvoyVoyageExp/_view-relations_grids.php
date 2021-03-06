<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');
}

if (!$ajax || $ajax == 'vvcl-voyage-client-grid') {
    Yii::beginProfile('vvcl_vvoy_id.view.grid');
    ?>

    <div class="table-header">
        <?= Yii::t('VvoyModule.model', 'Vvcl Voyage Client') ?>
        <?php
        $this->widget(
                'bootstrap.widgets.TbButton', array(
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

    $this->widget('TbGridView', array(
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
                'value' => '$data->vvclPlanFcrn->fcrn_code',
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
                'deleteButtonOptions' => array('data-toggle' => 'tooltip'),
            ),
        )
            )
    );


    Yii::endProfile('vvcl_vvoy_id.view.grid');
}
?>

<?php
if (!$ajax || $ajax == 'vfue-fuel-grid') {
//if(false){
    Yii::beginProfile('vfue_vvoy_id.view.grid');

    /**
     * get payment documents for all drivers
     */
    //get draivers
    $model_persons = $modelMain->vxprVoyageXPeople;
    $persons = array();
    foreach ($model_persons as $mp) {
        $persons[] = $mp->vxpr_pprs_id;
    }

    //if no drivers, cann not add payment documents
    $warning = '';
    //get documents
    $payment_doc_type = $this->module->driver_payment_docs;    
    if (empty($persons) == 0) {
        $warning = Yii::t('VvoyModule.model', 'Pleas add driver(s) to voyage. Can not add payment docoments!');
        $payment_doc = array();
    }else{
        $payment_doc = PpxdPersonXDocument::model()->filterByDocTypeAndPerson($payment_doc_type, $persons)->findAll(array('limit' => 1000));
    }

    

    //create list data
    if (count($persons) > 1) {
        // if more one driver show document with driver name
        $payment_doc_list_data = CHtml::listData($payment_doc, 'ppxd_id', 'itemLabelExtended');
    } elseif (count($persons) == 1) {
        $payment_doc_list_data = CHtml::listData($payment_doc, 'ppxd_id', 'itemLabel');
    } else {
        
    }
    ?>

    <div class="table-header">
        <i class="icon-tint"></i>
        <?= Yii::t('VvoyModule.model', 'Fuel receipts') ?>
        <?php
        $this->widget(
                'bootstrap.widgets.TbButton', array(
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
        <span class="label label-large label-warning"><?php echo $warning ?></span>
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
    $this->widget('TbGridView', array(
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
                ),
                'htmlOptions' => array('class' => 'numeric-column'),                                
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
                ),
                'htmlOptions' => array('class' => 'numeric-column'),                                
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
                'deleteConfirmation' => Yii::t('VvoyModule.crud', 'Do you want to delete this item?'),
                'deleteButtonOptions' => array('data-toggle' => 'tooltip'),
            ),
        )
            )
    );
    Yii::endProfile('vfue_vvoy_id.view.grid');
}


if (!$ajax || $ajax == 'vfuf-fuel-finv-grid') {
    Yii::beginProfile('vfuf_vvoy_id.view.grid');
    $is_empty_vfuf = empty($modelMain->vfufFuelFinvs);
    $warning = '';
    if($is_empty_vfuf){
        $warning = Yii::t('VvoyModule.model', 'No exist invoices fueling items attached to this voyage!');
    }
    ?>

    <div class="table-header">
        <i class="icon-tint"></i>
        <?= Yii::t('VvoyModule.model', 'Fuel Invoices') ?>
        <span class="label label-large label-warning"><?php echo $warning ?></span>
    </div>

    <?php
    //grid
    if(!$is_empty_vfuf){
        $model = new VfufFuelFinv();
        $model->vfuf_vvoy_id = $modelMain->primaryKey;

        // render grid view

        $this->widget('TbGridView', array(
            'id' => 'vfuf-fuel-finv-grid',
            'dataProvider' => $model->search(),
            'template' => '{summary}{items}',
            'summaryText' => '&nbsp;',
            'htmlOptions' => array(
                'class' => 'rel-grid-view'
            ),
            'columns' => array(
                array(
                    'name' => 'vfuf_qnt',
                    'htmlOptions' => array('class' => 'numeric-column'),                                
                ),
                array(
                    'name' => 'vfuf_date',
                ),
                array(
                    'header' => Yii::t('VvoyModule.model', 'fcrn_name'),
                    'value' => '$data->vfufFixr->fixrFcrn->itemLabel',
                ),
                array(
                    'name' => Yii::t('VvoyModule.model', 'Amount'),
                    'value' => '$data->vfufFixr->fixr_amt',
                    'htmlOptions' => array('class' => 'numeric-column'),                                
                ),
                array(
                    'name' => 'vfuf_notes',
                ),
                array
                    (
                    'class' => 'TbButtonColumn',
                    'template' => '{show}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => Yii::t('VvoyModule.model', 'Show invoice data'),
                            'icon' => 'external-link',
                            'options' => array('data-toggle' => 'tooltip', 'target' => '_blank'),
                            'url' => 'Yii::app()->controller->createUrl("/d2fixr/FixrFiitXRef/viewFinv", array("finv_id" => $data->vfufFixr->fixrFiit->fiit_finv_id))',
                        ),
                    ),
                ),
            )
        ));
    }

    Yii::endProfile('vfuf_vvoy_id.view.grid');
}

if (!$ajax || $ajax == 'vexp-expenses-grid') {
    Yii::beginProfile('vexp_vvoy_id.view.grid');
    $is_empty_vexp = empty($modelMain->vexpExpenses);
    $warning = '';
    if($is_empty_vexp){
        $warning = Yii::t('VvoyModule.model', 'No exist invoices items attached to this voyage!');
    }    
    ?>

    <div class="table-header">
        <?= Yii::t('VvoyModule.model', 'Expenses (Invoices)') ?>
        <span class="label label-large label-warning"><?php echo $warning ?></span>
    </div>

    <?php
    if(!$is_empty_vexp){
    //    if (empty($modelMain->vexpExpenses)) {
    //        $model = new VexpExpenses;
    //        $model->vexp_vvoy_id = $modelMain->primaryKey;
    //        $model->save();
    //        unset($model);
    //    }

        $model = new VexpExpenses();
        $model->vexp_vvoy_id = $modelMain->primaryKey;

        // render grid view

        $this->widget('TbGridView', array(
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
                    'header' => Yii::t('VvoyModule.model', 'fcrn_name'),
                    'value' => '$data->vexpFixr->fixrFcrn->itemLabel',
                ),
                array(
                    'name' => Yii::t('VvoyModule.model', 'Amount'),
                    'value' => '$data->vexpFixr->fixr_amt',
                    'htmlOptions' => array('class' => 'numeric-column'),                
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
                array(
                    'header' => Yii::t('VvoyModule.model', 'Invoice'),
                    'value' => '$data->vexpFixr->fixrFiit->fiitFinv->itemLabel',
                ),
                array
                    (
                    'class' => 'TbButtonColumn',
                    'template' => '{show}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => Yii::t('VvoyModule.model', 'Show invoice data'),
                            'icon' => 'external-link',
                            'options' => array('data-toggle' => 'tooltip', 'target' => '_blank'),
                            'url' => 'Yii::app()->controller->createUrl("/d2fixr/FixrFiitXRef/viewFinv", array("finv_id" => $data->vexpFixr->fixrFiit->fiit_finv_id))',
                        ),
                    ),
                ),
            )
                )
        );
    }
    Yii::endProfile('vexp_vvoy_id.view.grid');
}

if(!$ajax || $ajax == 'vdim-dimension-grid'){
    Yii::beginProfile('vdim_vvoy_id.view.grid');

    //try add records
    if (empty($modelMain->vdimDimensions)) {
        $show_grid = VdimDimension::recalcVvoyData($modelMain->primaryKey);
    }else{
        $show_grid = true;
    }

    $model = new VdimDimension();
    $model->vdim_vvoy_id = $modelMain->primaryKey;

    // render grid view
    if (!$show_grid) {
?>

<div class="table-header">
    <?=Yii::t('VvoyModule.model', 'Fixed expenses')?>
    <?php    
        
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'link', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-refresh',
            'url' => array(
                '',
                'vvoy_id' => $modelMain->primaryKey,
            ),            
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Recalc'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    ?>
</div>
 
<?php         
        
    } else {
?>

<div class="table-header">
    <?=Yii::t('VvoyModule.model', 'Fixed expenses')?>
    <?php    
        
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'ajaxButton', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-refresh',
            'url' => array(
                '//vvoy/vdimDimension/ajaxRecalc',
                'vvoy_id' => $modelMain->primaryKey,
                'ajax' => 'vdim-dimension-grid',
            ),
            'ajaxOptions' => array(
                    'success' => '
                        function(html) {
                            $.fn.yiiGridView.update(\'vdim-dimension-grid\');
                            reload_total_grid();  
                        }
                                '
                    ),
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Recalc'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    ?>
</div>
 
<?php         
        $this->widget('TbGridView', array(
            'id' => 'vdim-dimension-grid',
            'dataProvider' => $model->search(),
            'template' => '{summary}{items}',
            'summaryText' => '&nbsp;',
            'htmlOptions' => array(
                'class' => 'rel-grid-view'
            ),
            'columns' => array(
                array(
                    'name' => 'vdim_fdm2_id',
                    'value' => '$data->vdimFdm2->fdm2_name'
                ),
                array(
                    'name' => 'vdim_base_amt',
                    'htmlOptions' => array('class' => 'numeric-column'),
                ),
            )
                )
        );
    }
    Yii::endProfile('vdim_vvoy_id.view.grid');
}    
