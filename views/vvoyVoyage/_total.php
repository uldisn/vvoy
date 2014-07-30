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