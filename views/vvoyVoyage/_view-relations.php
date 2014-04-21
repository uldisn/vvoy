
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
                            'url' =>  array('//vvoy/vvclVoyageClient/admin','VvclVoyageClient' => array('vvcl_vvoy_id' => $model->{$model->tableSchema->primaryKey}))
                        ),
                        array(
                'icon' => 'icon-plus',
                'url' => array(
                    '//vvoy/vvclVoyageClient/create',
                    'VvclVoyageClient' => array('vvcl_vvoy_id' => $model->{$model->tableSchema->primaryKey})
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


<?php 
        echo '<h3>';
            echo Yii::t('VvoyModule.model','relation.VvepVoyageExpensesPlans').' ';
            $this->widget(
                'bootstrap.widgets.TbButtonGroup',
                array(
                    'type' => '', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => 'mini',
                    'buttons' => array(
                        array(
                            'icon' => 'icon-list-alt',
                            'url' =>  array('//vvoy/vvepVoyageExpensesPlan/admin','VvepVoyageExpensesPlan' => array('vvep_vvoy_id' => $model->{$model->tableSchema->primaryKey}))
                        ),
                        array(
                'icon' => 'icon-plus',
                'url' => array(
                    '//vvoy/vvepVoyageExpensesPlan/create',
                    'VvepVoyageExpensesPlan' => array('vvep_vvoy_id' => $model->{$model->tableSchema->primaryKey})
                )
            ),
            
                    )
                )
            );
        echo '</h3>' ?>
<ul>

    <?php
    $records = $model->vvepVoyageExpensesPlans(array('scopes' => ''));
    if (is_array($records)) {
        foreach ($records as $i => $relatedModel) {
            echo '<li>';
            echo CHtml::link(
                '<i class="icon icon-arrow-right"></i> ' . $relatedModel->itemLabel,
                array('/vvoy/vvepVoyageExpensesPlan/view', 'vvep_id' => $relatedModel->vvep_id)
            );
            echo CHtml::link(
                ' <i class="icon icon-pencil"></i>',
                array('/vvoy/vvepVoyageExpensesPlan/update', 'vvep_id' => $relatedModel->vvep_id)
            );
            echo '</li>';
        }
    }
    ?>
</ul>


<?php 
        echo '<h3>';
            echo Yii::t('VvoyModule.model','relation.VvexVoyageExpenses').' ';
            $this->widget(
                'bootstrap.widgets.TbButtonGroup',
                array(
                    'type' => '', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => 'mini',
                    'buttons' => array(
                        array(
                            'icon' => 'icon-list-alt',
                            'url' =>  array('//vvoy/vvexVoyageExpenses/admin','VvexVoyageExpenses' => array('vvex_vvoy_id' => $model->{$model->tableSchema->primaryKey}))
                        ),
                        array(
                'icon' => 'icon-plus',
                'url' => array(
                    '//vvoy/vvexVoyageExpenses/create',
                    'VvexVoyageExpenses' => array('vvex_vvoy_id' => $model->{$model->tableSchema->primaryKey})
                )
            ),
            
                    )
                )
            );
        echo '</h3>' ?>
<ul>

    <?php
    $records = $model->vvexVoyageExpenses(array('scopes' => ''));
    if (is_array($records)) {
        foreach ($records as $i => $relatedModel) {
            echo '<li>';
            echo CHtml::link(
                '<i class="icon icon-arrow-right"></i> ' . $relatedModel->itemLabel,
                array('/vvoy/vvexVoyageExpenses/view', 'vvex_id' => $relatedModel->vvex_id)
            );
            echo CHtml::link(
                ' <i class="icon icon-pencil"></i>',
                array('/vvoy/vvexVoyageExpenses/update', 'vvex_id' => $relatedModel->vvex_id)
            );
            echo '</li>';
        }
    }
    ?>
</ul>


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
                            'url' =>  array('//vvoy/vvpoVoyagePoint/admin','VvpoVoyagePoint' => array('vvpo_vvoy_id' => $model->{$model->tableSchema->primaryKey}))
                        ),
                        array(
                'icon' => 'icon-plus',
                'url' => array(
                    '//vvoy/vvpoVoyagePoint/create',
                    'VvpoVoyagePoint' => array('vvpo_vvoy_id' => $model->{$model->tableSchema->primaryKey})
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


<?php 
        echo '<h3>';
            echo Yii::t('VvoyModule.model','relation.VxprVoyageXPeople').' ';
            $this->widget(
                'bootstrap.widgets.TbButtonGroup',
                array(
                    'type' => '', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => 'mini',
                    'buttons' => array(
                        array(
                            'icon' => 'icon-list-alt',
                            'url' =>  array('//vvoy/vxprVoyageXPerson/admin','VxprVoyageXPerson' => array('vxpr_vvoy_id' => $model->{$model->tableSchema->primaryKey}))
                        ),
                        array(
                'icon' => 'icon-plus',
                'url' => array(
                    '//vvoy/vxprVoyageXPerson/create',
                    'VxprVoyageXPerson' => array('vxpr_vvoy_id' => $model->{$model->tableSchema->primaryKey})
                )
            ),
            
                    )
                )
            );
        echo '</h3>' ?>
<ul>

    <?php
    $records = $model->vxprVoyageXPeople(array('scopes' => ''));
    if (is_array($records)) {
        foreach ($records as $i => $relatedModel) {
            echo '<li>';
            echo CHtml::link(
                '<i class="icon icon-arrow-right"></i> ' . $relatedModel->itemLabel,
                array('/vvoy/vxprVoyageXPerson/view', 'vxpr_id' => $relatedModel->vxpr_id)
            );
            echo CHtml::link(
                ' <i class="icon icon-pencil"></i>',
                array('/vvoy/vxprVoyageXPerson/update', 'vxpr_id' => $relatedModel->vxpr_id)
            );
            echo '</li>';
        }
    }
    ?>
</ul>

