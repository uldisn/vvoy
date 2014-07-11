<?php
if(!$ajax){
    Yii::app()->clientScript->registerCss('rel_grid',' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');     
}
?>

<div class="table-header">
    <?=Yii::t('VvoyModule.model', 'Totals')?>
</div>
<?php

Yii::beginProfile('VvoyVoyage.view.grid');
$this->widget('TbGridView', array(
    'id' => 'vvoy-voyage-total-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    #'responsiveTable' => true,
    'template' => '{summary}{items}',
    'summaryText' => '&nbsp;',
    'htmlOptions' => array(
        'class' => 'rel-grid-view'
    ),    
    'columns' => array(
        array(
            'name' => 'vvoy_fcrn_id',
            'value' => '$data->vvoyFcrn->fcrn_code',
        ),
        array(
            'header' => Yii::t('VvoyModule.model', 'Freight'),
            'value' => '$data->freightTotal',
            'htmlOptions' => array('class' => 'numeric-column'),
        ),
        array(
            'header' => Yii::t('VvoyModule.model', 'Expenses'),
            'value' => '$data->expensesTotal',
            'htmlOptions' => array('class' => 'numeric-column'),
        ),
        array(
            'header' => Yii::t('VvoyModule.model', 'Fuel'),
            'value' => '$data->fuelTotal',
            'htmlOptions' => array('class' => 'numeric-column'),
        ),
        array(
            'header' => Yii::t('VvoyModule.model', 'Diff.'),
            'value' => '$data->freightTotal - $data->fuelTotal - $data->expensesTotal',
            'htmlOptions' => array('class' => 'numeric-column'),
        ),
    )
        )
);

Yii::endProfile('VvoyVoyage.view.grid');
