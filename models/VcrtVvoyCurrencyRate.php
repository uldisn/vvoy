<?php

// auto-loading
Yii::setPathOfAlias('VcrtVvoyCurrencyRate', dirname(__FILE__));
Yii::import('VcrtVvoyCurrencyRate.*');

class VcrtVvoyCurrencyRate extends BaseVcrtVvoyCurrencyRate
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
     * iekopē plāniojamos valūtas kursus no teālajiem kursiem
     * @param int $vvoy_id
     * @param date $vvoy_fcrn_plan_date
     * @param int $vvoy_fcrn_id
     * @return boolean
     */
    public function fillRates($vvoy_id,$vvoy_fcrn_plan_date,$vvoy_fcrn_id){
        
        if(empty($vvoy_id)){
            return false;
        }
        
        if(empty($vvoy_fcrn_plan_date)){
            return false;
        }        
        
        if(empty($vvoy_fcrn_id)){
            return false;
        }        
        

        //get actual rates
        $currencies = Yii::app()->currency->getCurrencyId2Code();
        
        //save
        foreach ($currencies as $fcrn_id => $fcrn_code) {
            $rate = Yii::app()->currency->getCurrencyRateExt($vvoy_fcrn_plan_date,$fcrn_id,6,$vvoy_fcrn_id);
            if($rate === false){
                continue;
            }
            $rate = round(1/$rate,6);
            $vcrt = new VcrtVvoyCurrencyRate();
            $vcrt->vcrt_vvoy_id = $vvoy_id;
            $vcrt->vcrt_base_fcrn_id = $vvoy_fcrn_id;
            $vcrt->vcrt_fcrn_id = $fcrn_id;
            $vcrt->vcrt_date = $vvoy_fcrn_plan_date;
            $vcrt->vcrt_rate = $rate;
            $vcrt->vcrt_rate_org = $rate;
            $vcrt->save();
        }

    }

    /**
     * dzēš visus planotos valūtas kursus
     * @param int $vvoy_id
     * @return boolean
     */
    public function deleteRates($vvoy_id){
        
        if(empty($vvoy_id)){
            return false;
        }
        
        $vvoy = VvoyVoyage::model()->findByPk($vvoy_id);
        if(empty($vvoy)){
            return false;
        }        

        $vcrt_list = $vvoy->vcrtVvoyCurrencyRates;        
        
        if($vcrt_list === false){
            return true;
        }
        
        foreach ($vcrt_list as $vcrt){
            $vcrt->delete();
        }

    }
    
    /**
     * Konvertē summu uz reisa bāzes valūtu pēc plānojamā kursa
     * @param int $vvoy_id reiss
     * @param int $fcrn_id valūta
     * @param dec $amt summa
     * @param int $round 
     * @return type
     */
    static public function convertToBase($vvoy_id,$fcrn_id,$amt,$round = 6){
        $criteria = new CDbCriteria;
        $criteria->compare('vcrt_vvoy_id', $vvoy_id);
        $criteria->compare('vcrt_fcrn_id', $fcrn_id);
        $vcrt = VcrtVvoyCurrencyRate::model()->find($criteria);
        return round($amt * $vcrt->vcrt_rate,$round);
    }
    
    protected function afterSave(){
        parent::afterSave();
        $this->vcrtVvoy->recalcItems();
        $this->vcrtVvoy->recalcTotals();
    }    
    
}
