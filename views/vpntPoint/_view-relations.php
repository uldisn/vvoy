
<!--
<h2>
    <?php echo Yii::t('VvoyModule.crud', 'Relations') ?></h2>
-->


<?php 
        echo '<h3>';
            echo Yii::t('VvoyModule.model','relation.VvpoVoyagePoints').' ';
            $this->widget(
                'bootstrap.widgets.TbButtonGroup',
                array(
                    'type' => '', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => 'mini',
                    'buttons' => array(
                        array(
                            'icon' => 'icon-list-alt',
                            'url' =>  array('//vvoy/vvpoVoyagePoint/admin','VvpoVoyagePoint' => array('vvpo_vpnt_id' => $model->{$model->tableSchema->primaryKey}))
                        ),
                        array(
                'icon' => 'icon-plus',
                'url' => array(
                    '//vvoy/vvpoVoyagePoint/create',
                    'VvpoVoyagePoint' => array('vvpo_vpnt_id' => $model->{$model->tableSchema->primaryKey})
                )
            ),
            
                    )
                )
            );
        echo '</h3>' ?>
<ul>

    <?php
    $records = $model->vvpoVoyagePoints(array('scopes' => ''));
    if (is_array($records)) {
        foreach ($records as $i => $relatedModel) {
            echo '<li>';
            echo CHtml::link(
                '<i class="icon icon-arrow-right"></i> ' . $relatedModel->itemLabel,
                array('/vvoy/vvpoVoyagePoint/view', 'vvpo_id' => $relatedModel->vvpo_id)
            );
            echo CHtml::link(
                ' <i class="icon icon-pencil"></i>',
                array('/vvoy/vvpoVoyagePoint/update', 'vvpo_id' => $relatedModel->vvpo_id)
            );
            echo '</li>';
        }
    }
    ?>
</ul>

