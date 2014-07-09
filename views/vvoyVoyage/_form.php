<div class="crud-form">

    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#vvoy-voyage-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'vvoy-voyage-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span5">
            <div class="form-horizontal">

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_id')) != 'tooltip.vvoy_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'vvoy_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vvoy_number') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_number')) != 'tooltip.vvoy_number')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'vvoy_number', array('size' => 20, 'maxlength' => 20));
                            echo $form->error($model,'vvoy_number')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vvoy_vtrc_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_vtrc_id')) != 'tooltip.vvoy_vtrc_id')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                array(
                    'model' => $model,
                    'relation' => 'vvoyVtrc',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => array(
                        'checkAll' => 'all'
                    ),
                )
                );
                            echo $form->error($model,'vvoy_vtrc_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vvoy_vtrl_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_vtrl_id')) != 'tooltip.vvoy_vtrl_id')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                array(
                    'model' => $model,
                    'relation' => 'vvoyVtrl',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => array(
                        'checkAll' => 'all'
                    ),
                )
                );
                            echo $form->error($model,'vvoy_vtrl_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vvoy_status') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_status')) != 'tooltip.vvoy_status')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'vvoy_status', $model->getEnumFieldLabels('vvoy_status'));
                            echo $form->error($model,'vvoy_status')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vvoy_fcrn_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_fcrn_id')) != 'tooltip.vvoy_fcrn_id')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                array(
                    'model' => $model,
                    'relation' => 'vvoyFcrn',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => array(
                        'checkAll' => 'all'
                    ),
                )
                );
                            echo $form->error($model,'vvoy_fcrn_id')
                            ?>                            </span>
                        </div>
                    </div>
                
<div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vvoy_fcrn_plan_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_fcrn_plan_date')) != 'tooltip.vvoy_fcrn_plan_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'vvoy_fcrn_plan_date',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
                                 'htmlOptions' => array('size' => 10),
                                 'options' => array(
                                     'showButtonPanel' => true,
                                     'changeYear' => true,
                                     'changeYear' => true,
                                     'dateFormat' => 'yy-mm-dd',
                                     ),
                                 )
                             );
                    ;
                            echo $form->error($model,'vvoy_fcrn_plan_date')
                            ?>                            </span>
                        </div>
                    </div>                
                    <?php  ?>
                                    
                    <?php  if(false){?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vvoy_start_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_start_date')) != 'tooltip.vvoy_start_date')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'vvoy_start_date');
                            echo $form->error($model,'vvoy_start_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vvoy_end_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vvoy_end_date')) != 'tooltip.vvoy_end_date')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'vvoy_end_date');
                            echo $form->error($model,'vvoy_end_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  }?>
                
            </div>
        </div>
        <!-- main inputs -->

        <!-- sub inputs -->
    </div>

    <p class="alert">
        
        <?php 
            echo Yii::t('VvoyModule.crud','Fields with <span class="required">*</span> are required.');
                
            /**
             * @todo: We need the buttons inside the form, when a user hits <enter>
             */                
            echo ' '.CHtml::submitButton(Yii::t('VvoyModule.crud', 'Save'), array(
                'class' => 'btn btn-primary',
                'style'=>'visibility: hidden;'                
            ));
                
        ?>
    </p>


    <?php $this->endWidget() ?>
</div> <!-- form -->
