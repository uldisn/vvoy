<?php

// auto-loading
Yii::setPathOfAlias('VvclVoyageClient', dirname(__FILE__));
Yii::import('VvclVoyageClient.*');

class VvclVoyageClient extends BaseVvclVoyageClient
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

    public function save($runValidation = true, $attributes = NULL)
    {
         
        //calc base amt
        if(
                !empty($this->vvcl_fcrn_id)
                && !empty($this->vvcl_freight)
                && (
                        is_null($attributes)    
                    || in_array('vvcl_freight', $attributes)
                    || in_array('vvcl_fcrn_id', $attributes)
                   )
        ){
            //$this->vvcl_base_amt = Yii::app()->currency->convertFromTo($this->vvcl_fcrn_id, $this->vvclVvoy->vvoy_fcrn_id, $this->vvcl_freight,$this->vvclVvoy->vvoy_fcrn_plan_date);
            $this->vvcl_base_amt = VcrtVvoyCurrencyRate::convertToBase($this->vvcl_vvoy_id, $this->vvcl_fcrn_id, $this->vvcl_freight);
            $attributes[] = 'vvcl_base_amt';
        }
    
        return parent::save($runValidation, $attributes);
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
    
    protected function afterSave(){
        parent::afterSave();
        $this->vvclVvoy->recalcTotals();
    }

}
