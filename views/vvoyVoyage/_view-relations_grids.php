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
                        'source' => CHtml::listData(CcmpCompany::model()->userSysCompanyComanies()->findAll(array('limit' => 1000)), 'ccmp_id', 'itemLabel'),                        
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
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvcl_fcrn_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvclVoyageClient/editableSaver'),
                        'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                        'success' => 'function(response, newValue) {$.fn.yiiGridView.update("vvoy-voyage-total-grid");}',
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
                        'success' => 'function(response, newValue) {$.fn.yiiGridView.update("vvoy-voyage-total-grid");}',
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
if(!$ajax || $ajax == 'vvep-voyage-expenses-plan-grid'){
    Yii::beginProfile('vvep_vvoy_id.view.grid');
?>

<div class="table-header">
    <i class="icon-money"></i>
    <?=Yii::t('VvoyModule.model', 'Vvep Voyage Expenses Plan')?>
    <?php    
        
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'ajaxButton', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vvepVoyageExpensesPlan/ajaxCreate',
                'field' => 'vvep_vvoy_id',
                'value' => $modelMain->primaryKey,
                'ajax' => 'vvep-voyage-expenses-plan-grid',
            ),
            'ajaxOptions' => array(
                    'success' => 'function(html) {$.fn.yiiGridView.update(\'vvep-voyage-expenses-plan-grid\');}'
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

    if (empty($modelMain->vvepVoyageExpensesPlans)) {
        $model = new VvepVoyageExpensesPlan;
        $model->vvep_vvoy_id = $modelMain->primaryKey;
        $model->save();
        unset($model);
    } 
    
    $model = new VvepVoyageExpensesPlan();
    $model->vvep_vvoy_id = $modelMain->primaryKey;

    // render grid view
    $this->widget('TbGridView',
        array(
            'id' => 'vvep-voyage-expenses-plan-grid',
            'dataProvider' => $model->search(),
            'template' => '{summary}{items}',
            'summaryText' => '&nbsp;', 
            'htmlOptions' => array(
                'class' => 'rel-grid-view'
            ),            
            'columns' => array(
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvep_vepo_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                        'source' => CHtml::listData(VepoExpensesPositions::model()->findAll(array('limit' => 1000)), 'vepo_id', 'itemLabel'),    
                        'success' => 'function(response, newValue) {
                                            if(newValue == "'.$this->module->vepo_postion_eur_km.'"){
                                                $.fn.yiiGridView.update("vvep-voyage-expenses-plan-grid");
                                                $.fn.yiiGridView.update("vvoy-voyage-total-grid");                                            
                                            }
                                     }',                           
                        //'placement' => 'right',
                    )
                ),
                array(
                    //decimal(10,3) unsigned
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvep_count',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                        'success' => 'function(response, newValue) {
                                            $.fn.yiiGridView.update("vvep-voyage-expenses-plan-grid");
                                            $.fn.yiiGridView.update("vvoy-voyage-total-grid");                                            
                                      }',                        
                    ),
                    'htmlOptions' => array('class' => 'numeric-column'),
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvep_fcrn_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                        'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),   
                        'success' => 'function(response, newValue) {
                                            $.fn.yiiGridView.update("vvep-voyage-expenses-plan-grid");
                                            $.fn.yiiGridView.update("vvoy-voyage-total-grid");                                            
                                      }',                                                
                        //'placement' => 'right',
                    )
                ),                
                array(
                    //decimal(10,2) unsigned
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvep_price',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                        'success' => 'function(response, newValue) {
                                            $.fn.yiiGridView.update("vvep-voyage-expenses-plan-grid");
                                            $.fn.yiiGridView.update("vvoy-voyage-total-grid");                                            
                                      }',                        
                        //'placement' => 'right',
                    ),
                    'htmlOptions' => array('class' => 'numeric-column'),
                ),
                array(
                    //decimal(10,2)
                    'name' => 'vvep_total',
                    'htmlOptions' => array('class' => 'numeric-column'),
                ),
                /*
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvep_base_fcrn_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                        'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                        //'placement' => 'right',
                    )
                ),
                array(
                    //decimal(10,2)
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvep_base_total',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                        //'placement' => 'right',
                    )
                ),
                */
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvep_notes',
                    'editable' => array(
                        'type' => 'textarea',
                        'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                        //'placement' => 'right',
                    )
                ),
                array(
                    'class' => 'TbButtonColumn',
                    'buttons' => array(
                        'view' => array('visible' => 'FALSE'),
                        'update' => array('visible' => 'FALSE'),
                        'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.DeletevvepVoyageExpensesPlans")'),
                    ),
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/vvoy/vvepVoyageExpensesPlan/delete", array("vvep_id" => $data->vvep_id))',
                    'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),           
                    'afterDelete' => 'function() {$.fn.yiiGridView.update("vvoy-voyage-total-grid");}',                    
                ),
            )
        )
    );

   ?>

<?php
    Yii::endProfile('VvexVoyageExpenses.view.grid');
}    
?>

<?php
if(!$ajax || $ajax == 'vvpo-voyage-point-grid'){
    Yii::beginProfile('vvpo_vvoy_id.view.grid');
?>

<div class="table-header">   
    <i class="icon-map-marker"></i>
    <?=Yii::t('VvoyModule.model', 'Vvpo Voyage Point')?>
    <?php    
        
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'ajaxButton', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vvpoVoyagePoint/ajaxCreate',
                'field' => 'vvpo_vvoy_id',
                'value' => $modelMain->primaryKey,
                'ajax' => 'vvpo-voyage-point-grid',
            ),
            'ajaxOptions' => array(
                    'success' => 'function(html) {$.fn.yiiGridView.update(\'vvpo-voyage-point-grid\');}'
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

    if (empty($modelMain->vvpoVoyagePoints)) {
        $model = new VvpoVoyagePoint;
        $model->vvpo_vvoy_id = $modelMain->primaryKey;
        $model->save();
        unset($model);
    } 
    
    $model = new VvpoVoyagePoint();
    $model->vvpo_vvoy_id = $modelMain->primaryKey;

    // render grid view

    $this->widget('TbGridView',
        array(
            'id' => 'vvpo-voyage-point-grid',
            'dataProvider' => $model->search(),
            'template' => '{summary}{items}',
            'summaryText' => '&nbsp;', 
            'htmlOptions' => array(
                'class' => 'rel-grid-view'
            ),            
            'columns' => array(
                array(
                    //tinyint(3) unsigned
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_sqn',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        //'placement' => 'right',
                    ),
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_vpnt_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        'source' => CHtml::listData(VpntPoint::model()->findAll(array('limit' => 1000)), 'vpnt_id', 'itemLabel'),                        
                        //'placement' => 'right',
                    )
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_plan_start_date',
                    'editable' => array(
                        'type'        => 'combodate',
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        'viewformat'  => 'YYYY-MM-DD HH', //in this format date is displayed
                        'template' => 'YYYY-MM-DD HH', //template for dropdowns
                        'combodate' => array('minYear' => date('Y')-1, 'maxYear' => date('Y')+1),                     
                        //'placement' => 'right',
                    )
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_plan_end_date',
                    'editable' => array(
                        'type'        => 'combodate',
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        'viewformat'  => 'YYYY-MM-DD HH', //in this format date is displayed
                        'template' => 'YYYY-MM-DD HH', //template for dropdowns
                        'combodate' => array('minYear' => date('Y')-1, 'maxYear' => date('Y')+1),                                         
                        //'placement' => 'right',
                    )
                ),
                array(
                    //smallint(5) unsigned
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_plan_km',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        'success' => 'function(response, newValue) {
                                            $.fn.yiiGridView.update("vvpo-voyage-point-grid");
                                            $.fn.yiiGridView.update("vvoy-voyage-total-grid");                                            
                                      }',
                        //'placement' => 'right',
                    ),
                    'htmlOptions' => array('class' => 'numeric-column'),
                ),
                array(
                    //decimal(4,1) unsigned
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_plan_weight',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        //'placement' => 'right',
                    ),
                    'htmlOptions' => array('class' => 'numeric-column'),                    
                ),                
                array(
                    //decimal(2,2)
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_plan_fuel_coefficient',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        'success' => 'function(response, newValue) {
                                            $.fn.yiiGridView.update("vvpo-voyage-point-grid");
                                            $.fn.yiiGridView.update("vvoy-voyage-total-grid");                                            
                                      }',                    
                        //'placement' => 'right',
                    ),
                    'htmlOptions' => array('class' => 'numeric-column'),
                ),
               array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_plan_fcrn_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                        'success' => 'function(response, newValue) {
                                            $.fn.yiiGridView.update("vvpo-voyage-point-grid");
                                            $.fn.yiiGridView.update("vvoy-voyage-total-grid");                                            
                                      }',                        
                        //'placement' => 'right',
                    )
                ),                
                array(
                    //decimal(10,2)
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_plan_fuel_price',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        'success' => 'function(response, newValue) {
                                            $.fn.yiiGridView.update("vvpo-voyage-point-grid");
                                            $.fn.yiiGridView.update("vvoy-voyage-total-grid");                                            
                                      }',
                        //'placement' => 'right',
                    ),
                    'htmlOptions' => array('class' => 'numeric-column'),
                ),
                array(
                    'name' => 'vvpo_plan_amt',
                    'htmlOptions' => array('class' => 'numeric-column'),
                    ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_notes',
                    'editable' => array(
                        'type' => 'textarea',
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        //'placement' => 'right',
                    ),
                ),
                /*            
                array(
                    //int(10) unsigned
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_start_odo',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        //'placement' => 'right',
                    )
                ),
                array(
                    //int(10) unsigned
                    'class' => 'editable.EditableColumn',
                    'name' => 'vvpo_end_odo',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        //'placement' => 'right',
                    )
                ),
                array(
                    'class' => 'TbEditableColumn',
                    'name' => 'vvpo_real_start_date',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        //'placement' => 'right',
                    )
                ),
                array(
                    'class' => 'TbEditableColumn',
                    'name' => 'vvpo_real_end_date',
                    'editable' => array(
                        'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                        //'placement' => 'right',
                    )
                ),
                */

                array(
                    'class' => 'TbButtonColumn',
                    'buttons' => array(
                        'view' => array('visible' => 'FALSE'),
                        'update' => array('visible' => 'FALSE'),
                        'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.DeletevvpoVoyagePoints")'),
                    ),
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/vvoy/vvpoVoyagePoint/delete", array("vvpo_id" => $data->vvpo_id))',
                    'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
                    'afterDelete' => 'function() {$.fn.yiiGridView.update("vvoy-voyage-total-grid");}',
                ),
            )
        )
    );

    ?>

<?php
    Yii::endProfile('VvpoVoyagePoint.view.grid');
}    
?>

<?php
if(!$ajax || $ajax == 'vxpr-voyage-xperson-grid'){
    Yii::beginProfile('vxpr_vvoy_id.view.grid');
?>

<div class="table-header">  
    <i class="icon-male"></i>
    <?=Yii::t('VvoyModule.model', 'Vxpr Voyage Xperson')?>
    <?php    
        
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'ajaxButton', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vxprVoyageXPerson/ajaxCreate',
                'field' => 'vxpr_vvoy_id',
                'value' => $modelMain->primaryKey,
                'ajax' => 'vxpr-voyage-xperson-grid',
            ),
            'ajaxOptions' => array(
                    'success' => 'function(html) {$.fn.yiiGridView.update(\'vxpr-voyage-xperson-grid\');}'
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

    if (empty($modelMain->vxprVoyageXPeople)) {
        $model = new VxprVoyageXPerson;
        $model->vxpr_vvoy_id = $modelMain->primaryKey;
        $model->save();
        unset($model);
    } 
    
    $model = new VxprVoyageXPerson();
    $model->vxpr_vvoy_id = $modelMain->primaryKey;
    
    $person_type_driver = $this->module->driver_person_type;
    $drivers = PprsPerson::model()->filterGroup($person_type_driver)->findAll(array('limit' => 1000));
    
    // render grid view

    $this->widget('TbGridView',
        array(
            'id' => 'vxpr-voyage-xperson-grid',
            'dataProvider' => $model->search(),
            'template' => '{summary}{items}',
            'summaryText' => '&nbsp;', 
            'htmlOptions' => array(
                'class' => 'rel-grid-view'
            ),                 
            'columns' => array(
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vxpr_pprs_id',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('//vvoy/vxprVoyageXPerson/editableSaver'),
                        'source' => CHtml::listData($drivers, 'pprs_id', 'itemLabel'),                        
                        //'placement' => 'right',
                    )
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'vxpr_notes',
                    'editable' => array(
                        'type' => 'textarea',
                        'url' => $this->createUrl('//vvoy/vxprVoyageXPerson/editableSaver'),
                        //'placement' => 'right',
                    )
                ),

                array(
                    'class' => 'TbButtonColumn',
                    'buttons' => array(
                        'view' => array('visible' => 'FALSE'),
                        'update' => array('visible' => 'FALSE'),
                        'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.DeletevxprVoyageXPeople")'),
                    ),
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/vvoy/vxprVoyageXPerson/delete", array("vxpr_id" => $data->vxpr_id))',
                    'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),         
                ),
            )
        )
    );

    Yii::endProfile('VxprVoyageXPerson.view.grid');
}    