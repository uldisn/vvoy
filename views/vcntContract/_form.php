<div class="crud-form">

    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#vcnt-contract-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'vcnt-contract-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span7">
            <div class="form-horizontal">
                <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vcnt_id')) != 'tooltip.vcnt_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'vcnt_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vcnt_client_ccmp_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vcnt_client_ccmp_id')) != 'tooltip.vcnt_client_ccmp_id')?$t:'' ?>'>
                                <?php
                            $widget_criteria = new CDbCriteria();
                            if(Yii::app()->sysCompany->getActiveCompany()){
                                $widget_criteria->compare('t.ccmp_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
                            }
                                
                            $this->widget(
                                '\GtcRelation',
                                array(
                                    'model' => $model,
                                    'relation' => 'vcntClientCcmp',
                                    'criteria' => $widget_criteria,
                                    'fields' => 'itemLabel',
                                    'allowEmpty' => true,
                                    'style' => 'dropdownlist',
                                    'htmlOptions' => array(
                                        'checkAll' => 'all'
                                    ),
                                )
                            );
                            echo $form->error($model,'vcnt_client_ccmp_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vcnt_date_from') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vcnt_date_from')) != 'tooltip.vcnt_date_from')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'vcnt_date_from',
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
                            echo $form->error($model,'vcnt_date_from')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vcnt_date_to') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vcnt_date_to')) != 'tooltip.vcnt_date_to')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'vcnt_date_to',
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
                            echo $form->error($model,'vcnt_date_to')
                            ?>                            </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vcnt_number') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vcnt_number')) != 'tooltip.vcnt_number')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'vcnt_number', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'vcnt_number')
                            ?>                            </span>
                        </div>
                    </div>                
                
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vcnt_status') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vcnt_status')) != 'tooltip.vcnt_status')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'vcnt_status', $model->getEnumFieldLabels('vcnt_status'));
                            echo $form->error($model,'vcnt_status')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vcnt_notes') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vcnt_notes')) != 'tooltip.vcnt_notes')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'vcnt_notes', array('rows' => 6, 'cols' => 50));
                            echo $form->error($model,'vcnt_notes')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
            </div>
        </div>
        <!-- main inputs -->

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
