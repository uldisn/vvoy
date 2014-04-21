<div class="wide form">

    <?php
    $form = $this->beginWidget('TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    
    <div class="row">
        <?php echo $form->label($model, 'vpnt_id'); ?>
        <?php ; ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vpnt_ccnt_id'); ?>
        <?php echo $form->textField($model, 'vpnt_ccnt_id'); ?>
    </div>


    
    <div class="row">
        <?php echo $form->label($model, 'vpnt_name'); ?>
        <?php echo $form->textField($model, 'vpnt_name', array('size' => 60, 'maxlength' => 100)); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('VvoyModule.crud', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
