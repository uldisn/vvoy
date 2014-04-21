<?php
    $this->setPageTitle(
        Yii::t('VvoyModule.model', 'Vvoy Voyage')
        . ' - '
        . Yii::t('VvoyModule.crud', 'View')
        . ': '   
        . $model->getItemLabel()            
);    
?>


    <h1>
        <?php echo Yii::t('VvoyModule.model','Vvoy Voyage')?>
    </h1>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>

<div class="row">
    <div class="span5">
        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(
            array(
                'name' => 'vvoy_ccmp_id',
                'value' => ($model->vvoyCcmp !== null)?CHtml::link(
                            '<i class="icon icon-circle-arrow-left"></i> '.$model->vvoyCcmp->itemLabel,
                            array('/d2company/ccmpCompany/update','ccmp_id' => $model->vvoyCcmp->ccmp_id),
                            array('class' => '')):'n/a',
                'type' => 'html',
            ),
            array(
                        'name' => 'vvoy_number',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vvoy_number',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                            ),
                            true
                        )
                    ),
        array(
            'name' => 'vvoy_vtrc_id',
            'value' => $model->vvoyVtrc->itemLabel,
            'type' => 'html',
        ),
        array(
            'name' => 'vvoy_vtrl_id',
            'value' => $model->vvoyVtrl->itemLabel,
            'type' => 'html',
        ),
        array(
                        'name' => 'vvoy_status',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vvoy_status',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                            ),
                            true
                        )
                    ),
        array(
            'name' => 'vvoy_fcrn_id',
            'value' => $model->vvoyFcrn->itemLabel,
            'type' => 'html',
        ),
array(
                        'name' => 'vvoy_start_date',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vvoy_start_date',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'vvoy_end_date',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vvoy_end_date',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                            ),
                            true
                        )
                    ),
            array(
                        'name' => 'vvoy_notes',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vvoy_notes',
                                'url' => $this->createUrl('/vvoy/vvoyVoyage/editableSaver'),
                            ),
                            true
                        )
                    ),
                    
           ),
     
        )); ?>
    </div>


    <div class="span7">
        <div class="well">
            <?php $this->renderPartial('_view-relations_grids',array('modelMain' => $model)); ?>        </div>
    </div>
</div>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>