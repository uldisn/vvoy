<div class="wide form">

    <?php
    $form = $this->beginWidget('TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    
    <div class="row">
        <?php echo $form->label($model, 'vvoy_id'); ?>
        <?php ; ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model, 'vvoy_number'); ?>
        <?php echo $form->textField($model, 'vvoy_number', array('size' => 20, 'maxlength' => 20)); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vvoy_vtrc_id'); ?>
        <?php echo $form->textField($model, 'vvoy_vtrc_id'); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vvoy_vtrl_id'); ?>
        <?php echo $form->textField($model, 'vvoy_vtrl_id'); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vvoy_status'); ?>
        <?php echo CHtml::activeDropDownList($model, 'vvoy_status', $model->getEnumFieldLabels('vvoy_status')); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vvoy_fcrn_id'); ?>
        <?php echo $form->textField($model, 'vvoy_fcrn_id'); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vvoy_start_date'); ?>
        <?php echo $form->textField($model, 'vvoy_start_date'); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vvoy_end_date'); ?>
        <?php echo $form->textField($model, 'vvoy_end_date'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('VvoyModule.crud', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
