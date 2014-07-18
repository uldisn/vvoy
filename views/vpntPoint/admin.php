<?php
$this->setPageTitle(
    Yii::t('VvoyModule.model', 'Vpnt Points')
    . ' - '
    . Yii::t('VvoyModule.crud', 'Manage')
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update(
            'vpnt-point-grid',
            {data: $(this).serialize()}
        );
        return false;
    });
    ");
?>

    <h1>
        <?php 
        $this->widget("bootstrap.widgets.TbButton", array(
             "label"=>Yii::t("VvoyModule.crud","Create"),
             "icon"=>"icon-plus",
             "size"=>"large",
             "type"=>"success",
             "url"=>array("create"),
             "visible"=>(Yii::app()->user->checkAccess("Vvoy.VpntPoint.*") || Yii::app()->user->checkAccess("Vvoy.VpntPoint.Create"))
        ));        
        ?>
        &nbsp<i class="icon-map-marker"></i>  
        <?php echo Yii::t('VvoyModule.model', 'Vpnt Points'); ?>
    </h1>
<div class="row">
    <div class="span7">

<?php Yii::beginProfile('VpntPoint.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'vpnt-point-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'responsiveTable' => true,
        'template' => '{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
            array(
                //'class' => 'editable.EditableColumn',
                'name' => 'vpnt_ccnt_id',
                'value' => '$data->vpntCcnt->ccnt_name'
                //'editable' => array(
                //    'type' => 'select',
                //    'url' => $this->createUrl('/vvoy/vpntPoint/editableSaver'),
                //    'source' => CHtml::listData(CcntCountry::model()->findAll(array('limit' => 1000)), 'ccnt_id', 'itemLabel'),                        
                //    //'placement' => 'right',
                //)
            ),
            array(
                //varchar(100)
                //'class' => 'editable.EditableColumn',
                'name' => 'vpnt_name',
                //'editable' => array(
                //    'url' => $this->createUrl('/vvoy/vpntPoint/editableSaver'),
                //    //'placement' => 'right',
                //)
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'false'),
                    'update' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VpntPoint.Update")'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("Vvoy.VpntPoint.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("vpnt_id" => $data->vpnt_id))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update", array("vpnt_id" => $data->vpnt_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("vpnt_id" => $data->vpnt_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'updateButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('VpntPoint.view.grid'); ?>
    </div>
</div>