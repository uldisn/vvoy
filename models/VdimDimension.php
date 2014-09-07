<?php

// auto-loading
Yii::setPathOfAlias('VdimDimension', dirname(__FILE__));
Yii::import('VdimDimension.*');

class VdimDimension extends BaseVdimDimension
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
    public static function recalcVvoyData($vvoy_id,$fdst_id){
        
        //saskalda vilcēja izmaksas pa perodiem
        $sql = "
                SELECT 

                  fddp_fdm2_id fdm2_id,
                  fddp_fdpe_id,
                  fddp_amt,
                  fdm1_name,	  
                  fdm2_name,	
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
                  ,2) vp_amt
                FROM
                  fddp_dim_data_period 
                  INNER JOIN fdpe_dim_period 
                    ON fddp_fdpe_id = fdpe_id 
                  INNER JOIN vvoy_voyage 
                    ON 
                        fddp_fdst_ref_id = vvoy_vtrc_id
                        AND
                        (
                                fdpe_dt_from    <= vvoy_start_date AND vvoy_start_date < fdpe_dt_to 
                             OR fdpe_dt_from    <= vvoy_end_date   AND vvoy_end_date   < fdpe_dt_to
                             OR vvoy_start_date <  fdpe_dt_from    AND vvoy_end_date   > fdpe_dt_to
                        )
                  INNER JOIN fdm1_dimension1
                    ON  fddp_fdm1_id = fdm1_id
                INNER JOIN fdm2_dimension2
                    ON  fddp_fdm2_id = fdm2_id    

                WHERE fddp_fdst_id = {$fdst_id} 
                  AND vvoy_id = {$vvoy_id} 
                GROUP BY 
                  fddp_fdm2_id,
                  fddp_fdpe_id             
                ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        
        $is_records = !empty($data);
        
        //summee periodus pa dim2
        $total = array();
        foreach($data as $row){
            if(!isset($total[$row['fdm2_id']])){
                $total[$row['fdm2_id']] = 0;
            }
            $total[$row['fdm2_id']] += $row['vp_amt'];
        }


        
        //convet to voyage currency
        $vvoy = VvoyVoyage::model()->findByPk($vvoy_id);                
        foreach($total as $fdm2_id => $amt){
           
            $total[$fdm2_id] = Yii::app()->currency->convertFromTo(
                                                            Yii::app()->currency->base, 
                                                            $vvoy->vvoy_fcrn_id, 
                                                            $amt,
                                                            $vvoy->vvoy_start_date
                    );
        }   
        //update vdim data
        
        $sql = "select * from vdim_dimension where vdim_vvoy_id = {$vvoy_id}";
        $fdim_data = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($fdim_data as $k => $fdim_record ){
            if(isset($total[$fdim_record['vdim_fdm2_id']])){
                
                //update existing record
                $vdim = VdimDimension::model()->findByPk($fdim_record['vdim_id']);
                $vdim->vdim_base_amt = $total[$fdim_record['vdim_fdm2_id']];
                $vdim->save();
            }else{
                
                //delete no used record
                $vdim = VdimDimension::model()->findByPk($fdim_record['vdim_id']);
                $vdim->delete();
            }
            unset($total[$fdim_record['vdim_fdm2_id']]);            
            unset($fdim_data[$k]);            
        }    
        
        //add new records
        foreach($total as $fdm2_id => $amt){
            $vdim = new VdimDimension;
            $vdim->vdim_vvoy_id = $vvoy_id;
            $vdim->vdim_fdm2_id = $fdm2_id;
            $vdim->vdim_base_amt = $amt;
            $vdim->save();                
        }
        
        return $is_records;
                  
    }
    
    
    
    
}
