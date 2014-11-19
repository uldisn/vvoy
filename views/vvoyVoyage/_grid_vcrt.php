<?php
if (!$ajax || $ajax == 'vcrt-vvoy-currency-rate-grid') {
    Yii::beginProfile('vcrt_vvoy_id.view.grid');
    ?>

    <div class="table-header">
        <?= Yii::t('VvoyModule.model', 'Currency Rates') ?>

    </div>

    <?php

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
            array(
                'name' => 'vcrt_fcrn_id',
                'value' => '$data->vcrtFcrn->fcrn_code'
            ),
            array(
                'name' => 'vcrt_rate_org',
                'htmlOptions' => array(
                    'class' => 'numeric-column warning',
                    ),
            ),
            array(
                //decimal(12,6) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'vcrt_rate',
                'editable' => array(
                    'url' => $this->createUrl('//vvoy/vcrtVvoyCurrencyRate/editableSaver'),
                    //'placement' => 'right',
                    'htmlOptions' => array(
                        'class' => '$data["vcrt_rate"] != $data["vcrt_rate_org"] ? "red" : ""', //if rate changed - color red
                    ),
                'success' => 'function(response, newValue) {
                                $.fn.yiiGridView.update(\'vvep-voyage-expenses-plan-grid\');
                                $.fn.yiiGridView.update(\'vvpo-voyage-point-grid\');
                                $.fn.yiiGridView.update(\'vcrt-vvoy-currency-rate-grid\');
                                reload_total_grid();                                              
                              }',                    
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
        )
            )
    );
    ?>

    <?php
    Yii::endProfile('vcrt_vvoy_id.view.grid');
}    