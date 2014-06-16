<?php
$this->setPageTitle(Yii::t('VvoyModule.model', 'Vvoy Dasboard'));
?>

<h1>
    <?php echo Yii::t('VvoyModule.model', 'Vvoy Dasboard') ?>
</h1>




<div class="row">
    <div class="span12">
        <table border="1">
            <thead>
                <tr>
                    <th><?= Yii::t('VvoyModule.model', 'Car') ?></th>
                    <th><?= Yii::t('VvoyModule.model', 'Finished') ?></th>
                    <th><?= Yii::t('VvoyModule.model', 'In Way') ?></th>
                    <th><?= Yii::t('VvoyModule.model', 'Planed') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $vtrc_car_reg_nr = '';
                $status = VvoyVoyage::VVOY_STATUS_NEW;
                
                $columns = array();
                foreach ($vvoy as $v) {

                    //jauna rinda
                    if ($v->vvoyVtrc->vtrc_car_reg_nr != $vtrc_car_reg_nr) {
                        $vtrc_car_reg_nr = $v->vvoyVtrc->vtrc_car_reg_nr;
                        $table[$vtrc_car_reg_nr] = array(
                            VvoyVoyage::VVOY_STATUS_FINISH=> array(),
                            VvoyVoyage::VVOY_STATUS_WAY => array(),
                            VvoyVoyage::VVOY_STATUS_NEW => array(),
                        );
                    }

                    //pa kolonaa saliek ierakstus
                    $table[$vtrc_car_reg_nr][$v->vvoy_status][] = $v;
                }
                
                foreach ($table as $vtrc_car_reg_nr => $columns) {
                    foreach($columns as $k1 => $v1){
                        $cell = array();
                        if(empty($columns[$k1])){
                            $columns[$k1] = '';
                        }else{
                            foreach($columns[$k1] as $k2 => $v2){
                                $cell[] = $v2->vvoy_number . ' '
                                        . substr($v2->vvoy_start_date,5,8)
                                        . ' - '
                                        .  substr($v2->vvoy_end_date,5,8);
                            }
                            $columns[$k1] = implode('<br/>',$cell);
                        }
                    }
                    echo '<tr>
                            <td>' . $vtrc_car_reg_nr . '</td>
                            <td>' .implode('</td><td>',$columns).'</td>
                          </tr>';

                }
                ?>
            </tbody>

        </table>

    </div>

</div>

