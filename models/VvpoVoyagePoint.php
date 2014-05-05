<?php

// auto-loading
Yii::setPathOfAlias('VvpoVoyagePoint', dirname(__FILE__));
Yii::import('VvpoVoyagePoint.*');

class VvpoVoyagePoint extends BaseVvpoVoyagePoint
{

    public $next_sqn;
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
        
        if(Yii::app()->sysCompany->getActiveCompany()){
            $criteria->join .= ' INNER JOIN vvoy_voyage v on vvoy_id = vvpo_vvoy_id ';
            $criteria->compare('v.vvoy_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        }  
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }
    
    public function save($runValidation = true, $attributes = NULL) 
    {
     
        //if not set vvpo_sqn, calculate it
        if($this->isNewRecord && empty($this->vvpo_sqn)){
            $criteria=new CDbCriteria;
            $criteria->select='max(vvpo_sqn) + 1 AS next_sqn';
            $row = $this->model()->find($criteria);
            if(empty($row)){
                $this->vvpo_sqn = 1;
            }else{
                $this->vvpo_sqn = $row['next_sqn'];
            }
            if(!empty($attributes)){
                $attributes[] = 'vvpo_sqn';
            }
        }
        
        return parent::save($runValidation,$attributes);

    }    

}
