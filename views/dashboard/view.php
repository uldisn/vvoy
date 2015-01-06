<?php
$this->setPageTitle(Yii::t('VvoyModule.model', 'Voyage Dasboard'));
?>

<div class="page-header position-relative">
    <h1>
        <?php echo Yii::t('VvoyModule.model', 'Voyage Dasboard') ?>
    </h1>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php
        $this->widget('vendor.uldisn.ace.widgets.TimeTable', array(
            'body_data' => $body_data,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'header_urls' => $urls,
            'header_labels' => [
                'title' => Yii::t("VvoyModule.crud", "Voyages {from} - {to}",[
                    '{from}' => $date_from,
                    '{to}' => $date_to,
                    ]),
                'period_today' => Yii::t("VvoyModule.crud", "Today"),
            ],
                )
        );
        ?>
    </div>
</div>

