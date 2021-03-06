<?php
$this->setPageTitle(
        Yii::t('VvoyModule.model', 'Voyage plan')
        . ': '
        . $model->getItemLabel()
);
$cancel_button = $this->widget("bootstrap.widgets.TbButton", array(
    "icon" => "chevron-left",
    "size" => "large",
    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
    "htmlOptions" => array(
        "class" => "search-button",
        "data-toggle" => "tooltip",
        "title" => Yii::t("VvoyModule.crud", "Cancel"),
    )
        ), TRUE);
?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <?php
            echo $cancel_button;
//            $this->widget("bootstrap.widgets.TbButton", array(
//                "label" => Yii::t("VvoyModule.crud", "Delete"),
//                "type" => "danger",
//                "icon" => "icon-trash icon-white",
//                "size" => "large",
//                "htmlOptions" => array(
//                    "submit" => array("delete", "vvoy_id" => $model->{$model->tableSchema->primaryKey}, "returnUrl" => (Yii::app()->request->getParam("returnUrl")) ? Yii::app()->request->getParam("returnUrl") : $this->createUrl("admin")),
//                    "confirm" => Yii::t("VvoyModule.crud", "Do you want to delete this item?")
//                ),
//                "visible" => (Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.*") || Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.Delete"))
//            ));
            
                 
            ?>                    
        </div>
    </div>
    <div class="btn-group">
        <h1>
            &nbsp;<i class="icon-road"></i>  
            <?php echo '' . Yii::t('VvoyModule.model', 'Voyage plan'); ?>
        </h1>
    </div>
    <div class="btn-group">
        <?php
            $this->widget("bootstrap.widgets.TbButton", array(
                "label" => Yii::t('VvoyModule.model', 'Voyage expenses'),
                "icon" => "chevron-right",
                'type' => 'info',
                "size" => "large",
                "url" => ["vvoyVoyageExp/view",'vvoy_id' => $model->vvoy_id],
                    ));        
        ?>
    </div>    
</div>
<div class="row">
    <div class="span4">
        <?php
        $this->widget(
                'TbAceDetailView', array(
            'id' => 'vvoy_voyage_view',        
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'vvoy_number',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField', 
                            array(
                                'model' => $model,
                                'attribute' => 'vvoy_number',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                            ), true
                        )
                ),
                array(
                    'name' => 'vvoy_vtrc_id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField', 
                            array(
                                'model' => $model,
                                'type' => 'select',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                                'source' => CHtml::listData(VtrcTruck::model()->findAll(array('limit' => 1000)), 'vtrc_id', 'itemLabel'),                        
                                'attribute' => 'vvoy_vtrc_id',

                            ), true
                        ),
                    'value_id' => $model->vvoy_vtrc_id,
                    'external_link' => array('/trucks/vtrcTruck/view','vtrc_id'=>$model->vvoy_vtrc_id),
                    'external_title' => Yii::t("VvoyModule.model",'Show Truck Data'),
                ),
                array(
                    'name' => 'vvoy_vtrl_id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField', 
                            array(
                                'model' => $model,
                                'type' => 'select',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                                'source' => CHtml::listData(VtrlTrailer::model()->findAll(array('limit' => 1000)), 'vtrl_id', 'itemLabel'),                        
                                'attribute' => 'vvoy_vtrl_id',

                            ), true
                        ),
                    'value_id' => $model->vvoy_vtrl_id,
                    'external_link' => array('/trucks/vtrlTrailer/view','vtrl_id'=>$model->vvoy_vtrl_id),
                    'external_title' => Yii::t("VvoyModule.model",'Show Traler Data'),                    
                    
                ),
                array(
                    'name' => 'vvoy_status',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', array(
                                'model' => $model,
                                'type' => 'select',
                                'attribute' => 'vvoy_status',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                                'source' => $model->getEnumFieldLabels('vvoy_status'),
                            ), true
                    )
                ),
                array(
                    'name' => 'vvoy_fcrn_id',
                    //'value' => $model->vvoyFcrn->itemLabel,
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', array(
                                'model' => $model,
                                'type' => 'select',
                                'attribute' => 'vvoy_fcrn_id',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                                'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),    
                                'success' => 'function(response, newValue) {
                                                $.fn.yiiGridView.update(\'vvep-voyage-expenses-plan-grid\');
                                                $.fn.yiiGridView.update(\'vvpo-voyage-point-grid\');
                                                $.fn.yiiGridView.update(\'vcrt-vvoy-currency-rate-grid\');
                                                reload_total_grid();                                              
                                              }',
                            ), true
                    )                    
                ),
                array(
                        'name' => 'vvoy_fcrn_plan_date',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'type' => 'date',
                                'model' => $model,
                                'attribute' => 'vvoy_fcrn_plan_date',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                                'success' => 'function(response, newValue) {
                                                $.fn.yiiGridView.update(\'vvep-voyage-expenses-plan-grid\');
                                                $.fn.yiiGridView.update(\'vvpo-voyage-point-grid\');
                                                $.fn.yiiGridView.update(\'vcrt-vvoy-currency-rate-grid\');
                                                reload_total_grid();
                                              }',                                
                                
                            ),
                            true
                        )
                    ),                
                array(
                    'name' => 'vvoy_plan_start_date',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', 
                            array(
                                'type' => 'datetime',
                                'model' => $model,
                                'attribute' => 'vvoy_plan_start_date',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                                //'format' => 'yyyy-mm-dd hh:ii:ss', //database datetime format
                                //'viewformat' => 'yyyy-mm-dd hh:ii', //format for display                                
                                //'datetime' => array('minuteStep'=>15)
                            ), 
                            true
                    )
                ),
                array(
                    'name' => 'vvoy_plan_end_date',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', array(
                                'type' => 'datetime',                                
                                'model' => $model,
                                'attribute' => 'vvoy_plan_end_date',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                            ), true
                    )
                ),
                array(
                    'name' => 'vvoy_notes',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', array(
                        'model' => $model,
                        'attribute' => 'vvoy_notes',
                        'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                            ), true
                    )
                ),
                
            ),
        ));
        
         $this->renderPartial('_grid_vcrt', 
                    array(
                        'modelMain' => $model,
                        'ajax' => false,
                        )
                    ); 

        $total_ajax_url = $this->createUrl('', array(
            'vvoy_id' => $model->vvoy_id,
            'ajax' => 'vvoy-voyage-total-grid',
        ));

        $planed_real_ajax_url = $this->createUrl('', array(
            'vvoy_id' => $model->vvoy_id,
            'ajax' => 'vvoy-voyage-compare-grid',
        ));
        Yii::app()->clientScript->registerScript('reload_total_grid', ' 
            function reload_total_grid(){
                var table = $("#vvoy-voyage-total-grid");
                $.ajax({
                    type: \'GET\',
                    url: \'' . $total_ajax_url . '\', 
                    success: function(html) {
                        $(table).html(html);
                    }
                });

            }    
            ');
         
         
         $this->renderPartial('/vvoyVoyageExp/_total', 
                    array(
                        'model' => $model,
                        'ajax' => false,
                        )
                    ); 
         ?>                
    </div>


    <div class="span8">
        <?php $this->renderPartial('_view-relations_grids', 
                    array(
                        'modelMain' => $model,
                        'ajax' => false,
                        )
                    ); ?>        
        <?php $this->widget('d2FilesWidget',array('module'=>$this->module->id, 'model'=>$model)); ?>
    </div>
</div>

<?php
$cancel_button = $this->widget("bootstrap.widgets.TbButton", array(
    "icon" => "chevron-left",
    "size" => "large",
    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
    "visible" => (Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.*") || Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.View")),
    "htmlOptions" => array(
        "class" => "search-button",
        "data-toggle" => "tooltip",
        "title" => Yii::t("VvoyModule.crud", "Cancel"),
    )
        ), TRUE);

echo $cancel_button;