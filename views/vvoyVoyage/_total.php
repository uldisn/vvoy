<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');
    /**
     * @todo jāpārliek uz widget
     */
    $ajax_url = $this->createUrl('',array(
        'vvoy_id' => $model->vvoy_id,
        'ajax' => 'vvoy-voyage-total-grid',
        ));
    Yii::app()->clientScript->registerScript('reload_total_grid', ' 
            function reload_total_grid(){
                var table = $("#vvoy-voyage-total-grid");
                $.ajax({
                    type: \'GET\',
                    url: \''.$ajax_url.'\', 
                    success: function(html) {
                        //$(table).fadeOut(800, function(){
                        //    table.html(html).fadeIn().delay(2000);
                        //
                        //});
                        $(table).html(html);
                        
                    }
                });
            }    
            ');
?>
<div class="table-header">
    <?= Yii::t('VvoyModule.model', 'Totals')  ?>
    <?= $model->getAttributeLabel('vvoy_fcrn_id')   ?>
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
            <th><?php echo Yii::t('VvoyModule.model', 'Balance') ?></th>
            <td></td>
            <td class="numeric-column total-row"><?php echo $model->freightPlanTotal - $model->fuelPlanTotal - $model->expensesPlanTotal ?></td>            
            <td></td>
            <td class="numeric-column total-row">??</td>            
        </tr>
    </tbody>


</table>