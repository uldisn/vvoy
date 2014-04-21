<?php
    $this->setPageTitle(
        Yii::t('VvoyModule.model', 'Vpnt Point')
        . ' - '
        . Yii::t('VvoyModule.crud', 'View')
        . ': '   
        . $model->getItemLabel()            
);    
?>

    <h1>
        <?php echo Yii::t('VvoyModule.model','Vpnt Point')?>
    </h1>



<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>

<div class="row">
    <div class="span7">
        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                array(
                        'name' => 'vpnt_id',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vpnt_id',
                                'url' => $this->createUrl('/vvoy/vpntPoint/editableSaver'),
                            ),
                            true
                        )
                    ),
        array(
            'name' => 'vpnt_ccnt_id',
            'value' => ($model->vpntCcnt !== null)?CHtml::link(
                            '<i class="icon icon-circle-arrow-left"></i> '.$model->vpntCcnt->itemLabel,
                            array('/vvoy/ccntCountry/view','ccnt_id' => $model->vpntCcnt->ccnt_id),
                            array('class' => '')).' '.CHtml::link(
                            '<i class="icon icon-pencil"></i> ',
                            array('/vvoy/ccntCountry/update','ccnt_id' => $model->vpntCcnt->ccnt_id),
                            array('class' => '')):'n/a',
            'type' => 'html',
        ),
array(
                        'name' => 'vpnt_name',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vpnt_name',
                                'url' => $this->createUrl('/vvoy/vpntPoint/editableSaver'),
                            ),
                            true
                        )
                    ),
           ),
        )); ?>
    </div>
</div>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>