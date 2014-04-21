<?php Yii::beginProfile('VvoyVoyage.view.toolbar'); ?>

<?php
    $showDeleteButton = (Yii::app()->request->getParam("vvoy_id"))?true:false;
    $showManageButton = true;
    $showCreateButton = true;
    $showUpdateButton = true;
    $showCancelButton = true;
    $showSaveButton   = true;
    $showViewButton   = true;

    switch($this->action->id){
        case "admin":
            $showCancelButton = false;
            $showSaveButton   = false;
            $showViewButton   = false;
            $showUpdateButton = false;
            break;
        case "update":
            $showCreateButton = false;
            $showUpdateButton = false;
            break;
        case "create":
            $showCreateButton = false;
            $showViewButton   = false;
            $showUpdateButton = false;
            break;
        case "view":
            $showViewButton   = false;
            $showSaveButton   = false;
            $showCreateButton = false;
            break;
    }
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <?php
                   $this->widget("bootstrap.widgets.TbButton", array(
                       #"label"=>Yii::t("VvoyModule.crud","Cancel"),
                       "icon"=>"chevron-left",
                       "size"=>"large",
                       "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
                       "visible"=>$showCancelButton && (Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.*") || Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.View")),
                       "htmlOptions"=>array(
                                       "class"=>"search-button",
                                       "data-toggle"=>"tooltip",
                                       "title"=>Yii::t("VvoyModule.crud","Cancel"),
                                   )
                    ));
                   $this->widget("bootstrap.widgets.TbButton", array(
                        "label"=>Yii::t("VvoyModule.crud","Create"),
                        "icon"=>"icon-plus",
                        "size"=>"large",
                        "type"=>"success",
                        "url"=>array("create"),
                        "visible"=>$showCreateButton && (Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.*") || Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.Create"))
                   ));
                    $this->widget("bootstrap.widgets.TbButton", array(
                        "label"=>Yii::t("VvoyModule.crud","Delete"),
                        "type"=>"danger",
                        "icon"=>"icon-trash icon-white",
                        "size"=>"large",
                        "htmlOptions"=> array(
                            "submit"=>array("delete","vvoy_id"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                            "confirm"=>Yii::t("VvoyModule.crud","Do you want to delete this item?")
                        ),
                        "visible"=> $showDeleteButton && (Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.*") || Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.Delete"))
                    ));
                    $this->widget("bootstrap.widgets.TbButton", array(
                        #"label"=>Yii::t("VvoyModule.crud","Update"),
                        "icon"=>"icon-edit icon-white",
                        "type"=>"primary",
                        "size"=>"large",
                        "url"=>array("update","vvoy_id"=>$model->{$model->tableSchema->primaryKey}),
                        "visible"=> $showUpdateButton &&  (Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.*") || Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.Update"))
                    ));
                    $this->widget("bootstrap.widgets.TbButton", array(
                        #"label"=>Yii::t("VvoyModule.crud","View"),
                        "icon"=>"icon-eye-open",
                        "size"=>"large",
                        "url"=>array("view","vvoy_id"=>$model->{$model->tableSchema->primaryKey}),
                        "visible"=>$showViewButton &&  (Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.*") || Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.View")),
                        "htmlOptions"=>array(
                                      "data-toggle"=>"tooltip",
                                      "title"=>Yii::t("VvoyModule.crud","View Mode"),
                        )
                    ));
                    $this->widget("bootstrap.widgets.TbButton", array(
                       "label"=>Yii::t("VvoyModule.crud","Save"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> array(
                            "onclick"=>"$('.crud-form form').submit();",
                       ),
                       "visible"=>$showSaveButton &&  (Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.*") || Yii::app()->user->checkAccess("Vvoy.VvoyVoyage.View"))
                    ));
             ?>        </div>
    </div>


</div>
<?php Yii::endProfile('VvoyVoyage.view.toolbar'); ?>