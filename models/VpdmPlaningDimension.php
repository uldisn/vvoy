<?php

// auto-loading
Yii::setPathOfAlias('VpdmPlaningDimension', dirname(__FILE__));
Yii::import('VpdmPlaningDimension.*');

class VpdmPlaningDimension extends BaseVpdmPlaningDimension
{

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        return parent::init();
    }

    public function getItemLabel()
    {
        return parent::getItemLabel();
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            array()
        );
    }

    public function rules()
    {
        return array_merge(
            parent::rules()
        /* , array(
          array('column1, column2', 'rule1'),
          array('column3', 'rule2'),
          ) */
        );
    }

    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }

    /**
     * ierēķina reisā vilcēja patstāvīgas izmaksas 
     * @param int $vvoy_id - voyage
     * @param int $fdst_id - dimension type
     * @return boolean is_records
     */
    public static function recalcVvoyData($vvoy_id){
        
        //saskalda  izmaksas pa perodiem
        $sql = "
                SELECT 
                  fddp_fdm2_id fdm2_id,
                  fddp_fdm3_id fdm3_id,
                  fddp_fdpe_id,
                  fddp_amt,

                  ROUND(
                      TIMESTAMPDIFF(
                        SECOND, 
                        GREATEST(fdpe_dt_from,vvoy_start_date) , 
                        LEAST(fdpe_dt_to,vvoy_end_date)
                      )
                      /
                      TIMESTAMPDIFF(SECOND, fdpe_dt_from, fdpe_dt_to)
                      *
                      SUM(CASE fddp_cd WHEN 'C' THEN fddp_amt/100 ELSE 0 END)
                  ,2) vp_amt,
                  fdst_dim_level level
                FROM
                  fddp_dim_data_period 
                  INNER JOIN fdst_dim_split_type
                    ON fddp_fdst_id = fdst_id                  
                  INNER JOIN fdpe_dim_period 
                    ON fddp_fdpe_id = fdpe_id 
                  INNER JOIN vvoy_voyage 
                    ON 
                        fddp_fdst_ref_id = vvoy_vtrc_id
                        AND
                        (
                                fdpe_dt_from    <= vvoy_plan_start_date AND vvoy_plan_start_date < fdpe_dt_to 
                             OR fdpe_dt_from    <= vvoy_plan_end_date   AND vvoy_plan_end_date   < fdpe_dt_to
                             OR vvoy_plan_start_date <  fdpe_dt_from    AND vvoy_plan_end_date   > fdpe_dt_to
                        )
                WHERE 
                  fdst_type = 'VVOY' 
                  
                  AND vvoy_id = {$vvoy_id} 
                GROUP BY 
                  fddp_fdm2_id,
                  fddp_fdm3_id,
                  fddp_fdpe_id             
                ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        
        $is_records = !empty($data);
        
        //summee periodus pa dim2 un dim3 atkarība no level
        $total = array();
        foreach($data as $row){
            if($row['level'] == 2){
                $key = $row['fdm2_id'];
            }else{
                $key = $row['fdm2_id'] . '_' . $row['fdm3_id'];
            }
            if(!isset($total[$key])){
                $total[$key] = 0;
            }
            $total[$key] += $row['vp_amt'];
        }
        
        //convet to voyage currency
        $vvoy = VvoyVoyage::model()->findByPk($vvoy_id);                
        foreach($total as $key => $amt){
            $sys_ccmp_base_fcrn = Yii::app()->currency->getSysCcmpBaseCurrency($vvoy->vvoy_start_date);
            $total[$key] = Yii::app()->currency->convertFromTo(
                                                            $sys_ccmp_base_fcrn, 
                                                            $vvoy->vvoy_fcrn_id, 
                                                            $amt,
                                                            $vvoy->vvoy_start_date
                    );
        }           
        
        //update vdim data
        
        $sql = "select * from vpdm_planing_dimension where vpdm_vvoy_id = {$vvoy_id}";
        $fdim_data = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($fdim_data as $k => $fdim_record ){

            if(empty($fdim_record['vpdm_fdm3_id'])){
                $key = $fdim_record['vpdm_fdm2_id'];
            }else{
                $key = $fdim_record['vpdm_fdm2_id'] . '_' . $fdim_record['vpdm_fdm3_id'];
            }            
            
            
            if(isset($total[$key])){
                
                //update existing record
                $vpdm = VpdmPlaningDimension::model()->findByPk($fdim_record['vpdm_id']);
                $vpdm->vpdm_base_amt = $total[$key];
                $vpdm->save();
            }else{
                
                //delete no used record
                $vpdm = VpdmPlaningDimension::model()->findByPk($fdim_record['vpdm_id']);
                $vpdm->delete();
            }
            unset($total[$key]);            
            unset($fdim_data[$k]);            
        }    
        
        //add new records
        foreach($total as $key => $amt){
            $a = explode('_',$key);
            if(count($a) == 2){
                list($fdm2_id,$fdm3_id) = $a;
            }else{
                $fdm2_id = $key;
                $fdm3_id = null;
            }            
            $vpdm = new VpdmPlaningDimension;
            $vpdm->vpdm_vvoy_id = $vvoy_id;
            $vpdm->vpdm_fdm2_id = $fdm2_id;
            $vpdm->vpdm_fdm3_id = $fdm3_id;
            $vpdm->vpdm_base_amt = $amt;
            $vpdm->save();                
        }
        
        return $is_records;
                  
    }
    
    
}
