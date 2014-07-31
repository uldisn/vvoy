<?php 
    /**
     * @todo jāpārliek uz widget
     */
    $ajax_url = $this->createUrl('vvoyDataJson',array(
        'vvoy_id' => $model->vvoy_id,
        //'ajax' => 'vvoy-voyage-total-grid',
        ));
    Yii::app()->clientScript->registerScript('reload_total_grid', ' 
            function reload_total_and_start_end_grid(){
                $.ajax({
                    type: \'GET\',
                    url: \''.$ajax_url.'\', 
                    success: function(data) {
                        if(data){
                            if (data.vvoy_fuel) {
                                $("#start_end_vvoy_fuel").html(data.vvoy_fuel);
                            }
                            if (response.vvoy_fuel_amt) {
                                $("#start_end_vvoy_fuel_amt").html(data.vvoy_fuel_amt);
                            }                               
                            if (response.vvoy_fuel_tank_end_amt) {
                                $("#start_end_vvoy_fuel_tank_end_amt").html(data.vvoy_fuel_tank_end_amt);
                            }   
                        }
                        reload_total_grid();
                        
                    }
                });
            }    
            '); 
?>
<div id="grid_start_end">
    <table class="items table">
        <thead>
            <tr>
                <th></th>
                <th><?php echo Yii::t("VvoyModule.crud", "Start"); ?></th>
                <th><?php echo Yii::t("VvoyModule.crud", "In Way"); ?></th>
                <th><?php echo Yii::t("VvoyModule.crud", "Finish"); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th><?php echo Yii::t("VvoyModule.crud", "Fuel Tank"); ?></th>
                <td class="numeric-column">
                    <?php
                    $this->widget('EditableField', array(
                        'type' => 'text',
                        'model' => $model,
                        'attribute' => 'vvoy_fuel_tank_start',
                        'url' => $this->createUrl('/vvoy/vvoyVoyageExp/editableSaver'),
                        'placement' => 'right',
                        'params' => array(
                            'get_field' => array(
                                'vvoy_fuel',
                                'vvoy_fuel_amt',
                                'vvoy_fuel_tank_end_amt',                                
                                ),
                        ),
                        'success' => '   
                            function(response, newValue) {
                                reload_total_and_start_end_grid();
                            }    
                            
                          ',
                    ));
                    ?>
                </td>
                <td class="numeric-column" id="start_end_vvoy_fuel"><?php echo $model->vvoy_fuel; ?></td>
                <td class="numeric-column"><?php
                    $this->widget('EditableField', array(
                        'type' => 'text',
                        'model' => $model,
                        'attribute' => 'vvoy_fuel_tank_end',
                        'url' => $this->createUrl('/vvoy/vvoyVoyageExp/editableSaver'),
                        'placement' => 'right',
                            
                        'params' => array(
                            'get_field' => array(
                                'vvoy_fuel',
                                'vvoy_fuel_amt',
                                'vvoy_fuel_tank_end_amt',                                
                                ),

                        ),
                        'success' => '   
                            function(response, newValue) {
                                reload_total_and_start_end_grid();
                            }    
                          ',
                        )
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php echo Yii::t("VvoyModule.crud", "Odo"); ?></th>
                <td class="numeric-column"><?php
                    $this->widget('EditableField', array(
                        'type' => 'text',
                        'model' => $model,
                        'attribute' => 'vvoy_odo_start',
                        'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                        'placement' => 'right',
                            )
                    );
                    ?>
                </td>
                <td class="numeric-column"><?php
                    $this->widget('EditableField', array(
                        'type' => 'text',
                        'model' => $model,
                        'attribute' => 'vvoy_mileage',
                        'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                        'placement' => 'right',
                            )
                    );
                    ?>
                </td>
                <td class="numeric-column"><?php
                    $this->widget('EditableField', array(
                        'type' => 'text',
                        'model' => $model,
                        'attribute' => 'vvoy_odo_end',
                        'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                        'placement' => 'right',
                            )
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php echo Yii::t("VvoyModule.crud", "Fuel Tank Amt"); ?></th>
                <td class="numeric-column"><?php
                    $this->widget('EditableField', array(
                            'type' => 'text',
                            'model' => $model,
                            'attribute' => 'vvoy_fuel_tank_start_amt',
                            'url' => $this->createUrl('/vvoy/vvoyVoyageExp/editableSaver'),
                            'placement' => 'right',
                            'params' => array(
                                'get_field' => array(
                                    'vvoy_fuel_amt',
                                    'vvoy_fuel_tank_end_amt',
                                    ),
                            ),
                            'success' => '   
                                function(response, newValue) {
                                    reload_total_and_start_end_grid();
                                }    
                              ',
                        )
                    );
                    ?>
                </td>                        
                <td class="numeric-column" id="start_end_vvoy_fuel_amt"><?php echo $model->vvoy_fuel_amt; ?></td>
                <td class="numeric-column" id="start_end_vvoy_fuel_tank_end_amt"><?php echo $model->vvoy_fuel_tank_end_amt; ?></td>
            </tr>
        </tbody>

    </table>
</div>