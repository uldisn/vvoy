
<!--
<h2>
    <?php echo Yii::t('VvoyModule.crud', 'Relations') ?></h2>
-->


<?php 
        echo '<h3>';
            echo Yii::t('VvoyModule.model','relation.VvclVoyageClients').' ';
            $this->widget(
                'bootstrap.widgets.TbButtonGroup',
                array(
                    'type' => '', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => 'mini',
                    'buttons' => array(
                        array(
                            'icon' => 'icon-list-alt',
                            'url' =>  array('//vvoy/vvclVoyageClient/admin','VvclVoyageClient' => array('vvcl_vcnt_id' => $model->{$model->tableSchema->primaryKey}))
                        ),
                        array(
                'icon' => 'icon-plus',
                'url' => array(
                    '//vvoy/vvclVoyageClient/create',
                    'VvclVoyageClient' => array('vvcl_vcnt_id' => $model->{$model->tableSchema->primaryKey})
                )
            ),
            
                    )
                )
            );
        echo '</h3>' ?>
<ul>

    <?php
    $records = $model->vvclVoyageClients(array('scopes' => ''));
    if (is_array($records)) {
        foreach ($records as $i => $relatedModel) {
            echo '<li>';
            echo CHtml::link(
                '<i class="icon icon-arrow-right"></i> ' . $relatedModel->itemLabel,
                array('/vvoy/vvclVoyageClient/view', 'vvcl_id' => $relatedModel->vvcl_id)
            );
            echo CHtml::link(
                ' <i class="icon icon-pencil"></i>',
                array('/vvoy/vvclVoyageClient/update', 'vvcl_id' => $relatedModel->vvcl_id)
            );
            echo '</li>';
        }
    }
    ?>
</ul>

