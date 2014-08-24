<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');


?>
<div class="table-header">
    <?= Yii::t('VvoyModule.model', 'Totals')  ?>
    <?//= $model->getAttributeLabel('vvoy_fcrn_id')   ?>
    <?= $model->vvoyFcrn->fcrn_code   ?>
</div>    
<?php    
}
?>


<table class="items table" id="vvoy-voyage-total-grid">
    <thead>
        <tr>
            <th></th>
            <th colspan="2"><?php echo Yii::t('VvoyModule.model', 'Planed') ?></th>
            <th colspan="2"><?php echo Yii::t('VvoyModule.model', 'Real') ?></th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Freight') ?></th>
            <td style="width: 5px">+</td>
            <td class="numeric-column"><?php echo $model->freightPlanTotal ?></td>
            <td style="width: 5px">+</td>
            <td class="numeric-column"><?php echo $model->freightTotal ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Expenses') ?></th>            
            <td>-</td>
            <td class="numeric-column"><?php echo $model->expensesPlanTotal ?></td>
            <td>-</td>
            <td class="numeric-column"><?php echo $model->vexpBaseAmtTotal ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Fuel') ?></th>
            <td>-</td>
            <td class="numeric-column"><?php echo $model->fuelPlanTotalAmt ?></td>            
            <td>-</td>
            <td class="numeric-column"><?php echo $model->vvoy_fuel_amt ?></td>            
        </tr>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Balance') ?></th>
            <td></td>
            <td class="numeric-column total-row"><?php echo $model->freightPlanTotal - $model->fuelPlanTotalAmt - $model->expensesPlanTotal ?></td>            
            <td></td>
            <td class="numeric-column total-row"><?php echo $model->freightTotal - $model->vvoy_fuel_amt - $model->vexpBaseAmtTotal ?></td>            
        </tr>
    </tbody>


</table>