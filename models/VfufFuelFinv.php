<?php

// auto-loading
Yii::setPathOfAlias('VfufFuelFinv', dirname(__FILE__));
Yii::import('VfufFuelFinv.*');

class VfufFuelFinv extends BaseVfufFuelFinv
{

    private $vvoy = false;    
    
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
    
    public function getItemPositionLabel()
    {
            return (string) $this->vfuf_qnt . ' ' . Yii::t('VvoyModule.model', 'Liters');
    }

    public function getItemPeriodLabel()
    {
        $vvoy = $this->vfufVvoy;
        if(Empty($vvoy)) return '';
        return (string) $this->vfufVvoy->getItemLabel();
    }    
    
    public function getVvoy(){
        if(!$this->vvoy){
            $this->vvoy = $this->vexpVvoy;
        }
        
        return $this->vvoy;
    }    
    
    public function isPeriodEditable(){
        return false;
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
    
    public function afterSave() {
        
//        /**
//         * registre transaction in dimensions
//         */
//        
//        //get models
//        $fixr = $this->vfufFixr;
//        if(empty($fixr->fixr_period_fret_id)){
//            parent::afterSave();
//            return;
//        }
//        $vvoy = $this->vfufVvoy;
//        if(empty($vvoy)){
//            parent::afterSave();
//            return;            
//        }
//        
//        $vtrc = $vvoy->vvoyVtrc;
//        
//        //save dim data
//        $fdda = FddaDimData::findByFixrId($fixr->fixr_id);
//        $fdda->fdda_fret_id = $fixr->fixr_period_fret_id;
//        
//        //dim2 - truck
//        $fdda->setFdm2Id($vtrc->vtrc_id, $vtrc->vtrc_car_reg_nr);
//        
//        //dim3 - voyage
//        $fdda->setFdm3Id($vvoy->vvoy_id, $vvoy->vvoy_number);
//        $fdda->fdda_date_from = $vvoy->vvoy_start_date;
//        $fdda->fdda_date_to = $vvoy->vvoy_end_date;
//        $fdda->save();
        
        $vvoy = $this->getVvoy();
        if(empty($vvoy)){
            parent::afterSave();
            return;
        }          
        
        $vtrc = $vvoy->vvoyVtrc;
        
        //registre transaction in dimensions
        FddaDimData::registre($this->vtrs_fixr_id,$vtrc->vtrc_id, $vtrc->vtrc_car_reg_nr,$vvoy->vvoy_id, $vvoy->vvoy_number);
        
        
        parent::afterSave();
    }       
    
    /**
     * common name for FddaDimData
     * @return date
     */
    public function getFddaDateFrom(){
        $vvoy = $this->getVvoy();
        return $vvoy->vvoy_start_date;
    }

    /**
     * common name for FddaDimData
     * @return date
     */    
    public function getFddaDateTo(){
        $vvoy = $this->getVvoy();
        return $vvoy->vvoy_end_date;
    }         

}
