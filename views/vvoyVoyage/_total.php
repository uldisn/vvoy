<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');
}
?>


<div class="table-header">
    <?= Yii::t('VvoyModule.model', 'Totals')  ?>
    <?= $model->getAttributeLabel('vvoy_fcrn_id')   ?>
    <?= $model->vvoyFcrn->fcrn_code   ?>
</div>
<table class="items table">
    <thead>
        <tr>
            <th></th>
            <th><?php echo Yii::t('VvoyModule.model', 'Freight') ?></th>
            <th><?php echo Yii::t('VvoyModule.model', 'Expenses') ?></th>
            <th><?php echo Yii::t('VvoyModule.model', 'Fuel') ?></th>
            <th><?php echo Yii::t('VvoyModule.model', 'Diff.') ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Planed Expenses') ?></th>
            <td class="numeric-column"><?php echo $model->freightPlanTotal ?></td>
            <td class="numeric-column"><?php echo $model->expensesPlanTotal ?></td>
            <td class="numeric-column"><?php echo $model->fuelPlanTotal ?></td>
            <td class="numeric-column"><?php echo $model->freightPlanTotal - $model->fuelPlanTotal - $model->expensesPlanTotal ?></td>
        </tr>
    </tbody>


</table>
<?php

$this->beginWidget('vendor.uldisn.ace.widgets.CJuiAceDialog',array(
    'id'=>'mydialog',
    'title' => 'Empty the recycle bin?',
    'title_icon' => 'icon-warning-sign red',
    'options'=>array(
        'resizable' => false,
        'modal' => true,
        'buttons'=> array(
            array(
                'html' => "<i class='icon-trash bigger-110'></i>&nbsp; Delete all items",
                'class' => "btn btn-danger btn-mini",
                'click' => 'function() {$( this ).dialog( "close" );}'
            ),    
            array(
                'html' => "<i class='icon-remove bigger-110'></i>&nbsp; Cancel",
                'class' => "btn btn-mini",
                'click' => 'function() {$( this ).dialog( "close" );}'
            ),    
        ),
        'autoOpen'=>false,
    ),
));

//    echo 'dialog content here';
?>

										<div class="alert alert-info bigger-110">
											These items will be permanently deleted and cannot be recovered.
										</div>

										<div class="space-6"></div>

										<p class="bigger-110 bolder center grey">
											<i class="icon-hand-right blue bigger-120"></i>
											Are you sure?
										</p>

    
<?php

$this->endWidget('vendor.uldisn.ace.widgets.CJuiAceDialog');

// the link that may open the dialog
echo CHtml::link('open dialog', '#', array(
   'onclick'=>'$("#mydialog").dialog("open"); return false;',
));
