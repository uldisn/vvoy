<?php
    $this->setPageTitle(
        Yii::t('VvoyModule.model', 'Vcnt Contract')
        . ' - '
        . Yii::t('VvoyModule.crud', 'View')
        . ': '   
        . $model->getItemLabel()            
);    
$this->breadcrumbs[Yii::t('VvoyModule.model','Vcnt Contracts')] = array('admin');
$this->breadcrumbs[$model->{$model->tableSchema->primaryKey}] = array('view','id' => $model->{$model->tableSchema->primaryKey});
$this->breadcrumbs[] = Yii::t('VvoyModule.crud', 'View');
?>

<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
    <h1>
        <?php echo Yii::t('VvoyModule.model','Vcnt Contract')?>
        <small>
            <?php echo $model->itemLabel ?>

        </small>

        </h1>



<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>

<div class="row">
    <div class="span7">
        <h2>
            <?php echo Yii::t('VvoyModule.crud','Data')?>            <small>
                #<?php echo $model->vcnt_id ?>            </small>
        </h2>

        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                array(
                        'name' => 'vcnt_id',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vcnt_id',
                                'url' => $this->createUrl('/vvoy/vcntContract/editableSaver'),
                            ),
                            true
                        )
                    ),
        array(
            'name' => 'vcnt_sys_ccmp_id',
            'value' => ($model->vcntSysCcmp !== null)?CHtml::link(
                            '<i class="icon icon-circle-arrow-left"></i> '.$model->vcntSysCcmp->itemLabel,
                            array('/vvoy/ccmpCompany/view','ccmp_id' => $model->vcntSysCcmp->ccmp_id),
                            array('class' => '')).' '.CHtml::link(
                            '<i class="icon icon-pencil"></i> ',
                            array('/vvoy/ccmpCompany/update','ccmp_id' => $model->vcntSysCcmp->ccmp_id),
                            array('class' => '')):'n/a',
            'type' => 'html',
        ),
        array(
            'name' => 'vcnt_client_ccmp_id',
            'value' => ($model->vcntClientCcmp !== null)?CHtml::link(
                            '<i class="icon icon-circle-arrow-left"></i> '.$model->vcntClientCcmp->itemLabel,
                            array('/vvoy/ccmpCompany/view','ccmp_id' => $model->vcntClientCcmp->ccmp_id),
                            array('class' => '')).' '.CHtml::link(
                            '<i class="icon icon-pencil"></i> ',
                            array('/vvoy/ccmpCompany/update','ccmp_id' => $model->vcntClientCcmp->ccmp_id),
                            array('class' => '')):'n/a',
            'type' => 'html',
        ),
array(
                        'name' => 'vcnt_date_from',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vcnt_date_from',
                                'url' => $this->createUrl('/vvoy/vcntContract/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'vcnt_date_to',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vcnt_date_to',
                                'url' => $this->createUrl('/vvoy/vcntContract/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'vcnt_status',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vcnt_status',
                                'url' => $this->createUrl('/vvoy/vcntContract/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'vcnt_notes',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'EditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'vcnt_notes',
                                'url' => $this->createUrl('/vvoy/vcntContract/editableSaver'),
                            ),
                            true
                        )
                    ),
           ),
        )); ?>
    </div>


    <div class="span5">
        <div class="well">
            <?php $this->renderPartial('_view-relations',array('model' => $model)); ?>        </div>
        <div class="well">
            <?php $this->renderPartial('_view-relations_grids',array('modelMain' => $model)); ?>        </div>
    </div>
</div>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>