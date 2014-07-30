<?php
if (!$ajax || $ajax == 'vcrt-vvoy-currency-rate-grid') {
    Yii::beginProfile('vcrt_vvoy_id.view.grid');
    ?>

    <div class="table-header">
        <?= Yii::t('VvoyModule.model', 'Vcrt Vvoy Currency Rate') ?>
        <?php
//        $this->widget(
//                'bootstrap.widgets.TbButton', array(
//            'buttonType' => 'ajaxButton',
//            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//            'size' => 'mini',
//            'icon' => 'icon-plus',
//            'url' => array(
//                '//vvoy/vcrtVvoyCurrencyRate/ajaxCreate',
//                'field' => 'vcrt_vvoy_id',
//                'value' => $modelMain->primaryKey,
//                'ajax' => 'vcrt-vvoy-currency-rate-grid',
//            ),
//            'ajaxOptions' => array(
//                'success' => 'function(html) {$.fn.yiiGridView.update(\'vcrt-vvoy-currency-rate-grid\');}'
//            ),
//            'htmlOptions' => array(
//                'title' => Yii::t('VvoyModule.crud', 'Add new record'),
//                'data-toggle' => 'tooltip',
//            ),
//                )
//        );
        ?>
    </div>

    <?php
    if (empty($modelMain->vcrtVvoyCurrencyRates)) {
//        $model = new VcrtVvoyCurrencyRate;
//        $model->fillRates($modelMain->primaryKey);
//        unset($model);
    }
    $css_class = '';
    if (!empty($modelMain->vcrtVvoyCurrencyRates)) {    
        $css_class = 'rel-grid-view';
    }

    $model = new VcrtVvoyCurrencyRate();
    $model->vcrt_vvoy_id = $modelMain->primaryKey;

    // render grid view

    $this->widget('TbGridView', array(
        'id' => 'vcrt-vvoy-currency-rate-grid',
        'dataProvider' => $model->search(),
        'template' => '{summary}{items}',
        'summaryText' => '&nbsp;',
        'htmlOptions' => array(
            'class' => $css_class,
        ),
        'columns' => array(
//            array(
//                'class' => 'editable.EditableColumn',
//                'name' => 'vcrt_base_fcrn_id',
//                'editable' => array(
//                    'type' => 'select',
//                    'url' => $this->createUrl('//vvoy/vcrtVvoyCurrencyRate/editableSaver'),
//                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),
//                //'placement' => 'right',
//                )
//            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'vcrt_fcrn_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('//vvoy/vcrtVvoyCurrencyRate/editableSaver'),
                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),
                //'placement' => 'right',
                )
            ),
//            array(
//                'class' => 'editable.EditableColumn',
//                'name' => 'vcrt_date',
//                'editable' => array(
//                    'type' => 'date',
//                    'url' => $this->createUrl('//vvoy/vcrtVvoyCurrencyRate/editableSaver'),
//                //'placement' => 'right',
//                )
//            ),
            array(
                'name' => 'vcrt_rate_org',
                'htmlOptions' => array('class' => 'numeric-column warning'),
            ),
            array(
                //decimal(12,6) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'vcrt_rate',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vcrtVvoyCurrencyRate/editableSaver'),
                //'placement' => 'right',
                'htmlOptions' => array(
                    'class' => '$data["vcrt_rate"] != $data["vcrt_rate_org"] ? "red" : ""',  //if rate changed - color red
                    ),                    
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                    ),                    
                
            ),
            
//            array(
//                'class' => 'TbButtonColumn',
//                'buttons' => array(
//                    'view' => array('visible' => 'FALSE'),
//                    'update' => array('visible' => 'FALSE'),
//                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.DeletevcrtVvoyCurrencyRates")'),
//                ),
//                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/vvoy/vcrtVvoyCurrencyRate/delete", array("vcrt_id" => $data->vcrt_id))',
//                'deleteConfirmation' => Yii::t('VvoyModule.crud', 'Do you want to delete this item?'),
//                'deleteButtonOptions' => array('data-toggle' => 'tooltip'),
//            ),
        )
            )
    );
    ?>

    <?php
    Yii::endProfile('VcrtVvoyCurrencyRate.view.grid');
}    