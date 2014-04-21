<div class="wide form">

    <?php
    $form = $this->beginWidget('TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    
    <div class="row">
        <?php echo $form->label($model, 'vcnt_id'); ?>
        <?php ; ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vcnt_sys_ccmp_id'); ?>
        <?php echo $form->textField($model, 'vcnt_sys_ccmp_id', array('size' => 10, 'maxlength' => 10)); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vcnt_client_ccmp_id'); ?>
        <?php echo $form->textField($model, 'vcnt_client_ccmp_id', array('size' => 10, 'maxlength' => 10)); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vcnt_date_from'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
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
                    ; ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vcnt_date_to'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
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
                    ; ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vcnt_status'); ?>
        <?php echo CHtml::activeDropDownList($model, 'vcnt_status', $model->getEnumFieldLabels('vcnt_status')); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vcnt_notes'); ?>
        <?php echo $form->textArea($model, 'vcnt_notes', array('rows' => 6, 'cols' => 50)); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('VvoyModule.crud', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
