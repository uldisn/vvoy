<?php

// auto-loading
Yii::setPathOfAlias('VexpExpenses', dirname(__FILE__));
Yii::import('VexpExpenses.*');

class VexpExpenses extends BaseVexpExpenses
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

    public function getItemLabel($postion = true)
    {
        return parent::getItemLabel();
    }

    public function getItemPositionLabel()
    {
            return (string) $this->vexpVepo->vepo_name;
    }

    public function getItemPeriodLabel()
    {
            return (string) $this->vexpVvoy->getItemLabel();
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

    public function save($runValidation = true, $attributes = NULL) 
    {

        $fixr = $this->vexpFixr;
        $vvoy = $this->vexpVvoy;
        //calc base amt
        if(
                !empty($fixr->fixr_fcrn_date) 
                && !empty($fixr->fixr_fcrn_id)
                && !empty($fixr->fixr_amt)
                && !empty($vvoy)
           ){
            $this->vexp_base_amt = Yii::app()->currency->convertFromTo(
                                                            $fixr->fixr_fcrn_id, 
                                                            $vvoy->vvoy_fcrn_id, 
                                                            $fixr->fixr_amt,
                                                            $fixr->fixr_fcrn_date
                    );
            //$attributes[] = 'vexp_base_amt';
        }
    
        return parent::save($runValidation, $attributes);        

    }        
    
    public function afterSave() {
        
        /**
         * registre transaction in dimensions
         */
        
        //get models
        $fixr = $this->vexpFixr;
        $vepo = $this->vexpVepo;
        $vvoy = $this->vexpVvoy;
        if(empty($vvoy)){
            parent::afterSave();
            return;
        }
        
        //save dim data
        $fdda = FddaDimData::findByFixrId($fixr->fixr_id);
        $fdda->fdda_fret_id = $fixr->fixr_period_fret_id;
        $fdda->setFdm2Id($vepo->vepo_id, $vepo->vepo_name);
        $fdda->setFdm3Id($vvoy->vvoy_id, $vvoy->vvoy_number);
        $fdda->fdda_date_from = $vvoy->vvoy_start_date;
        $fdda->fdda_date_to = $vvoy->vvoy_end_date;
        $fdda->save();
        
        parent::afterSave();
    }
        
    
    
}
