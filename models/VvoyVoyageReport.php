<?php
/**
 * voyage reprting module
 */

// auto-loading
Yii::setPathOfAlias('VvoyVoyage', dirname(__FILE__));
Yii::import('VvoyVoyage.*');

class VvoyVoyageReport extends BaseVvoyVoyage {

    // create data for widget vendor.uldisn.ace.widgets.TimeTable
    static function timeline($year, $week) {
        //default values
        if (!$year) {
            $year = date('Y');
        }

        if (!$week) {
            $week = date('W') - 1;
        }

        $data =[];

        $sql = "SET @d := STR_TO_DATE(concat(:year,:week,' Monday'), '%X%V %W');";
        Yii::app()
                ->db
                ->createCommand($sql)
                ->bindParam(':year', $year, PDO::PARAM_INT)
                ->bindParam(':week', $week, PDO::PARAM_INT)
                ->execute();
        //start date
        $sql = "SET @date_from := ADDDATE(@d , INTERVAL 2-DAYOFWEEK(@d) DAY);";
        Yii::app()->db->createCommand($sql)->execute();

        //end date
        $sql = "SET @date_to := ADDDATE(@date_from , 12);";
        Yii::app()->db->createCommand($sql)->execute();

        $sql = "
                SELECT 
                  vvoy_id,
                  date(vvoy_plan_start_date) start_date,
                  date(vvoy_plan_end_date) end_date,
                  concat(vtrc_car_reg_nr,'/',vtrl_reg_nr) label,
                  CASE vvoy_status 
                    WHEN '" . self::VVOY_STATUS_PROJECT . "' THEN 'icon-question'
                    WHEN '" . self::VVOY_STATUS_ACCEPTED . "' THEN 'icon-check'                        
                    WHEN '" . self::VVOY_STATUS_CANCELED . "' THEN 'icon-times' 
                    WHEN '" . self::VVOY_STATUS_IN_WAY . "' THEN 'icon-road'                        
                    WHEN '" . self::VVOY_STATUS_CLOSED . "' THEN 'icon-lock'                        
                    WHEN '" . self::VVOY_STATUS_FINISHED . "' THEN 'icon-unlock'                        
                  END icon,
                  CASE vvoy_status 
                    WHEN '" . self::VVOY_STATUS_PROJECT . "' THEN 'warning'
                    WHEN '" . self::VVOY_STATUS_ACCEPTED . "' THEN 'success'                        
                    WHEN '" . self::VVOY_STATUS_CANCELED . "' THEN 'light' 
                    WHEN '" . self::VVOY_STATUS_IN_WAY . "' THEN 'danger'                        
                    WHEN '" . self::VVOY_STATUS_CLOSED . "' THEN 'grey'                        
                    WHEN '" . self::VVOY_STATUS_FINISHED . "' THEN 'yellow'                        
                  END color
                FROM
                  vvoy_voyage 
                  INNER JOIN vtrc_truck 
                    ON vvoy_vtrc_id = vtrc_id 
                  LEFT OUTER JOIN vtrl_trailer 
                    ON vvoy_vtrl_id = vtrl_id 
                WHERE 
                    vvoy_sys_ccmp_id = " . Yii::app()->sysCompany->getActiveCompany() . "  
                    AND 
                    (
                       vvoy_plan_start_date >= @date_from AND vvoy_plan_start_date <= @date_to
                    OR vvoy_plan_end_date   >= @date_from AND vvoy_plan_end_date   <= @date_to
                    OR vvoy_plan_start_date <= @date_from AND vvoy_plan_end_date   >= @date_to                    
                    )
                ORDER BY vtrc_car_reg_nr,
                  vvoy_plan_start_date 
            ";

        $data['body_data'] = Yii::app()
                ->db
                ->createCommand($sql)
                ->queryAll();

        //create urls
        foreach ($data['body_data'] as $k => $row) {
            $data['body_data'][$k]['url'] = Yii::app()->createUrl(
                    'vvoy/vvoyVoyage/view', 
                    array('vvoy_id' => $row['vvoy_id'])
                    );
        }

        $sql = "SELECT 
                    @date_from date_from,
                    @date_to date_to,
                    year(adddate(@date_from,interval -1 week)) prev_period_year,
                    week(adddate(@date_from,interval -1 week)) prev_period_week,
                    year(adddate(@date_from,interval 1 week)) next_period_year,
                    week(adddate(@date_from,interval 1 week)) next_period_week
                    ;";
        $data['header_data'] = Yii::app()->db->createCommand($sql)->queryRow();
        
        return $data;
    }

}
