<div class="crud-form">

    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#vepo-expenses-positions-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'vepo-expenses-positions-form',
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
                                   
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vepo_id')) != 'tooltip.vepo_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'vepo_id')
                            ?>                            </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vepo_name') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vepo_name')) != 'tooltip.vepo_name')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'vepo_name', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'vepo_name')
                            ?>                            </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vepo_default') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vepo_default')) != 'tooltip.vepo_default')?$t:'' ?>'>
                                <?php
                            echo $form->checkBox($model, 'vepo_default');
                            echo $form->error($model,'vepo_default')
                            ?>                            </span>
                        </div>
                    </div>                
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
