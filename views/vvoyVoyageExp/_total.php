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
            <th colspan="2"><?php echo Yii::t('VvoyModule.model', 'Planed') ?></th>
            <th colspan="2"><?php echo Yii::t('VvoyModule.model', 'Real') ?></th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Milage') ?></th>
            <td style="width: 5px">+</td>
            <td class="numeric-column"><?php echo $model->milagePlanTotal ?></td>
            <td style="width: 5px">+</td>
            <td class="numeric-column"><?php echo $model->vvoy_mileage ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Freight') ?></th>
            <td style="width: 5px">+</td>
            <td class="numeric-column"><?php echo $model->freightPlanTotal ?></td>
            <td style="width: 5px">+</td>
            <td class="numeric-column"><?php echo $model->freightPlanTotal ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Expenses') ?></th>            
            <td>-</td>
            <td class="numeric-column"><?php echo $model->expensesPlanTotal ?></td>
            <td>-</td>
            <td class="numeric-column">???</td>
        </tr>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Fuel') ?></th>
            <td>-</td>
            <td class="numeric-column"><?php echo $model->fuelPlanTotal ?></td>            
            <td>-</td>
            <td class="numeric-column"><?php echo $model->vvoy_fuel_amt ?></td>            
        </tr>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Diff.') ?></th>
            <td></td>
            <td class="numeric-column"><?php echo $model->freightPlanTotal - $model->fuelPlanTotal - $model->expensesPlanTotal ?></td>            
            <td></td>
            <td class="numeric-column">??</td>            
        </tr>
    </tbody>


</table>