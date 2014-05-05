
<?php Yii::beginProfile('vvcl_vvoy_id.view.grid'); ?>
<h3>
    <?php 
    echo Yii::t('VvoyModule.model', 'Vvcl Voyage Client') . ' '; 
        
    if (empty($modelMain->vvclVoyageClients)) {
        // if no records, reload page
        $button_type = 'Button';
        $no_ajax = 1;
        $ajaxOptions = array();
    } else {
        // ajax button
        $button_type = 'ajaxButton';
        $no_ajax = 0;
        $ajaxOptions = array(
                'success' => 'function(html) {$.fn.yiiGridView.update(\'vvcl-voyage-client-grid\');}'
            );        
    }
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => $button_type, 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vvclVoyageClient/ajaxCreate',
                'field' => 'vvcl_vvoy_id',
                'value' => $modelMain->primaryKey,
                'no_ajax' => $no_ajax,
            ),
            'ajaxOptions' => $ajaxOptions,
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Add new record'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    ?>
</h3> 
 
<?php 
$model = new VvclVoyageClient();
$model->vvcl_vvoy_id = $modelMain->primaryKey;

// render grid view

$this->widget('TbGridView',
    array(
        'id' => 'vvcl-voyage-client-grid',
        'dataProvider' => $model->search(),
        'template' => '{items}',
        'htmlOptions' => array('class'=>'grid-view-no-details'),
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
                //decimal(8,2)
                'class' => 'editable.EditableColumn',
                'name' => 'vvcl_freight',
                'editable' => array(
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
                    //'placement' => 'right',
                )
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

Yii::beginProfile('vvep_vvoy_id.view.grid'); 
?>
<h3>
    <?php 
    echo Yii::t('VvoyModule.model', 'Vvep Voyage Expenses Plan') . ' '; 
        
    if (empty($modelMain->vvepVoyageExpensesPlans)) {
        // if no records, reload page
        $button_type = 'Button';
        $no_ajax = 1;
        $ajaxOptions = array();
    } else {
        // ajax button
        $button_type = 'ajaxButton';
        $no_ajax = 0;
        $ajaxOptions = array(
                'success' => 'function(html) {$.fn.yiiGridView.update(\'vvep-voyage-expenses-plan-grid\');}'
            );        
    }
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => $button_type, 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vvepVoyageExpensesPlan/ajaxCreate',
                'field' => 'vvep_vvoy_id',
                'value' => $modelMain->primaryKey,
                'no_ajax' => $no_ajax,
            ),
            'ajaxOptions' => $ajaxOptions,
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Add new record'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    echo '&nbsp;';
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'Button', 
            'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-refresh',
            'htmlOptions' => array(
                'onclick' => '$.fn.yiiGridView.update("vvep-voyage-expenses-plan-grid");',
                'title' => Yii::t('VvoyModule.model', 'Recalc'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    
    ?>
</h3> 
 
<?php 
$model = new VvepVoyageExpensesPlan();
$model->vvep_vvoy_id = $modelMain->primaryKey;

// render grid view

$this->widget('TbGridView',
    array(
        'id' => 'vvep-voyage-expenses-plan-grid',
        'dataProvider' => $model->search(),
        'template' => '{items}',
        'htmlOptions' => array('class'=>'grid-view-no-details'),
        'columns' => array(
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vvep_vepo_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                    'source' => CHtml::listData(VepoExpensesPositions::model()->findAll(array('limit' => 1000)), 'vepo_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(10,3) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'vvep_count',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                )
            ),
            array(
                //decimal(10,2) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'vvep_price',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vvep_fcrn_id',
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
                'name' => 'vvep_total',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vvepVoyageExpensesPlan/editableSaver'),
                    //'placement' => 'right',
                )
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
            ),
        )
    )
);

Yii::endProfile('VvepVoyageExpensesPlan.view.grid');
Yii::beginProfile('vvpo_vvoy_id.view.grid'); 
?>
<h3>
    <?php 
    echo Yii::t('VvoyModule.model', 'Vvpo Voyage Point') . ' '; 
        
    if (empty($modelMain->vvpoVoyagePoints)) {
        // if no records, reload page
        $button_type = 'Button';
        $no_ajax = 1;
        $ajaxOptions = array();
    } else {
        // ajax button
        $button_type = 'ajaxButton';
        $no_ajax = 0;
        $ajaxOptions = array(
                'success' => 'function(html) {$.fn.yiiGridView.update(\'vvpo-voyage-point-grid\');}'
            );        
    }
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => $button_type, 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vvpoVoyagePoint/ajaxCreate',
                'field' => 'vvpo_vvoy_id',
                'value' => $modelMain->primaryKey,
                'no_ajax' => $no_ajax,
            ),
            'ajaxOptions' => $ajaxOptions,
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Add new record'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    ?>
</h3> 
 
<?php 
$model = new VvpoVoyagePoint();
$model->vvpo_vvoy_id = $modelMain->primaryKey;

// render grid view

$this->widget('TbGridView',
    array(
        'id' => 'vvpo-voyage-point-grid',
        'dataProvider' => $model->search(),
        'template' => '{items}',
        'htmlOptions' => array('class'=>'grid-view-no-details'),
        'columns' => array(
            array(
                //tinyint(3) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'vvpo_sqn',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                    //'placement' => 'right',
                )
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
                'class' => 'TbEditableColumn',
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
                'class' => 'TbEditableColumn',
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
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(2,2)
                'class' => 'editable.EditableColumn',
                'name' => 'vvpo_plan_fuel_coefficient',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(10,2)
                'class' => 'editable.EditableColumn',
                'name' => 'vvpo_plan_fuel_price',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                    //'placement' => 'right',
                )
            ),
           array(
                'class' => 'editable.EditableColumn',
                'name' => 'vvpo_plan_fcrn_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vvpo_notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('//vvoy/vvpoVoyagePoint/editableSaver'),
                    //'placement' => 'right',
                )
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
            ),
        )
    )
);

Yii::endProfile('VvpoVoyagePoint.view.grid');

Yii::beginProfile('vxpr_vvoy_id.view.grid'); 

?>
<h3>
    <?php 
    echo Yii::t('VvoyModule.model', 'Vxpr Voyage Xperson') . ' '; 
        
    if (empty($modelMain->vxprVoyageXPeople)) {
        // if no records, reload page
        $button_type = 'Button';
        $no_ajax = 1;
        $ajaxOptions = array();
    } else {
        // ajax button
        $button_type = 'ajaxButton';
        $no_ajax = 0;
        $ajaxOptions = array(
                'success' => 'function(html) {$.fn.yiiGridView.update(\'vxpr-voyage-xperson-grid\');}'
            );        
    }
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => $button_type, 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => array(
                '//vvoy/vxprVoyageXPerson/ajaxCreate',
                'field' => 'vxpr_vvoy_id',
                'value' => $modelMain->primaryKey,
                'no_ajax' => $no_ajax,
            ),
            'ajaxOptions' => $ajaxOptions,
            'htmlOptions' => array(
                'title' => Yii::t('VvoyModule.crud', 'Add new record'),
                'data-toggle' => 'tooltip',
            ),                 
        )
    );        
    ?>
</h3> 
 
<?php 
$model = new VxprVoyageXPerson();
$model->vxpr_vvoy_id = $modelMain->primaryKey;

// render grid view

$this->widget('TbGridView',
    array(
        'id' => 'vxpr-voyage-xperson-grid',
        'dataProvider' => $model->search(),
        'template' => '{items}',
        'htmlOptions' => array('class'=>'grid-view-no-details'),
        'columns' => array(
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vxpr_pprs_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('//vvoy/vxprVoyageXPerson/editableSaver'),
                    'source' => CHtml::listData(PprsPerson::model()->filterGroup(1)->findAll(array('limit' => 1000)), 'pprs_id', 'itemLabel'),                        
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