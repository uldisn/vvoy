<?php
$this->setPageTitle(
    Yii::t('VvoyModule.model', 'Vpnt Point')
    . ' - '
    . Yii::t('VvoyModule.crud', 'Create')
);
$cancel_button = $this->widget("bootstrap.widgets.TbButton", array(
    "icon" => "chevron-left",
    "size" => "large",
    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
    "visible" => (Yii::app()->user->checkAccess("Vvoy.VpntPoint.*") || Yii::app()->user->checkAccess("Vvoy.VpntPoint.View")),
    "htmlOptions" => array(
        "class" => "search-button",
        "data-toggle" => "tooltip",
        "title" => Yii::t("VvoyModule.crud", "Cancel"),
    )
        ), TRUE);
?>
    <h1>
        <?php echo $cancel_button; ?>        
        &nbsp<i class="icon-map-marker"></i>  
        <?php echo Yii::t('VvoyModule.model', 'Vpnt Point Create'); ?>
    </h1>

<?php $this->renderPartial('_form', array('model' => $model, 'buttons' => 'create')); ?>
<?php echo $cancel_button; ?>
<?php 
$this->widget("bootstrap.widgets.TbButton", array(
    "label" => Yii::t("VvoyModule.crud", "Save"),
    "icon" => "icon-thumbs-up icon-white",
    "size" => "large",
    "type" => "primary",
    "htmlOptions" => array(
        "onclick" => "$('.crud-form form').submit();",
    ),
    "visible" => (Yii::app()->user->checkAccess("Vvoy.VpntPoint.*") || Yii::app()->user->checkAccess("Vvoy.VpntPoint.View"))
));
?>