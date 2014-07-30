<?php

// auto-loading
Yii::setPathOfAlias('VfueFuel', dirname(__FILE__));
Yii::import('VfueFuel.*');

class VfueFuel extends BaseVfueFuel
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
                !empty($this->vfue_date) 
                && !empty($this->vfue_fcrn_id)
                && !empty($this->vfue_amt)
                && (
                        is_null($attributes)
                        || in_array('vfue_date',$attributes)
                        || in_array('vfue_fcrn_id',$attributes)
                        || in_array('vfue_amt',$attributes)
                    )
                ){
            $this->vfue_base_amt = Yii::app()->currency->convertFromTo($this->vfue_fcrn_id, $this->vfueVvoy->vvoy_fcrn_id, $this->vfue_amt,$this->vfue_date);
            $attributes[] = 'vfue_base_amt';
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

}
