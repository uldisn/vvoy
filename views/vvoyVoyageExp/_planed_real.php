<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');
    ?>
    <div class="table-header">
        <?= Yii::t('VvoyModule.model', 'Compare') ?>
    </div>    
    <?php
}
?>


<table class="items table" id="vvoy-voyage-compare-grid">
    <thead>
        <tr>
            <th></th>
            <th><?php echo Yii::t('VvoyModule.model', 'Planed') ?></th>
            <th><?php echo Yii::t('VvoyModule.model', 'Real') ?></th>
            <th><?php echo Yii::t('VvoyModule.model', 'Diff') ?></th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Milage') ?></th>
            <td class="numeric-column"><?php echo $model->milagePlanTotal ?></td>
            <td class="numeric-column"><?php echo $model->vvoy_mileage ?></td>
            <td class="numeric-column"><?php echo $model->vvoy_mileage - $model->milagePlanTotal ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Fuel') ?></th>
            <td class="numeric-column"><?php echo $model->fuelPlanTotalQnt ?></td>
            <td class="numeric-column"><?php echo $model->vvoy_fuel ?></td>
            <td class="numeric-column"><?php echo $model->vvoy_fuel - $model->fuelPlanTotalQnt ?></td>
        </tr>
    </tbody>


</table>