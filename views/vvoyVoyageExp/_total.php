<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');
    ?>
    <div class="table-header">
    <?= Yii::t('VvoyModule.model', 'Totals') ?>
        <?= $model->vvoyFcrn->fcrn_code ?>
    </div>    
        <?php
    }

    $plan_total = 0;
    $real_total = 0;

    $pr = array(
        'freight' => array(
            'label' => Yii::t('VvoyModule.model', 'Freight'),
            'sign' => '+',
            'planed' => $model->freightPlanTotal,
            'real' => $model->freightTotal,
        ),
        'fixed_exp' => array(
            'label' => Yii::t('VvoyModule.model', 'Fixed Expenses'),
            'sign' => '-',
            'planed' => $model->vdimBaseAmtTotal,
            'real' => $model->vdimBaseAmtTotal,
        ),
        'exp' => array(
            'label' => Yii::t('VvoyModule.model', 'Expenses'),
            'sign' => '-',
            'planed' => $model->expensesPlanTotal,
            'real' => $model->vexpBaseAmtTotal,
        ),
        'fuel' => array(
            'label' => Yii::t('VvoyModule.model', 'Fuel'),
            'sign' => '-',
            'planed' => $model->fuelPlanTotalAmt,
            'real' => $model->vvoy_fuel_amt,
        ),
    );
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
<?php
$total_planed = $total_real = 0;
foreach ($pr as $row) {
    $total_planed += $row['planed'];
    $total_real += $row['real'];
    ?>
            <tr>
                <th><?php echo $row['label'] ?></th>
                <td style="width: 5px"><?php echo $row['sign'] ?></td>
                <td class="numeric-column"><?php echo $row['planed'] ?></td>
                <td style="width: 5px"><?php echo $row['sign'] ?></td>
                <td class="numeric-column"><?php echo $row['real'] ?></td>
            </tr>

    <?php
}
?>        
        <tr>
            <th><?php echo Yii::t('VvoyModule.model', 'Balance') ?></th>
            <td></td>
            <td class="numeric-column total-row"><?php echo $total_planed ?></td>            
            <td></td>
            <td class="numeric-column total-row"><?php echo $total_real ?></td>            
        </tr>
    </tbody>

</table>