<?php

// auto-loading
Yii::setPathOfAlias('VcntContract', dirname(__FILE__));
Yii::import('VcntContract.*');

class VcntContract extends BaseVcntContract
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
        return (string) $this->vcntClientCcmp->ccmp_name 
                . ' ' . $this->vcnt_number
                . ' ' . $this->vcnt_date_from
                . ' ' . $this->vcnt_date_to;
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
            $criteria->compare('t.vcnt_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        }  
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }

    public function save($runValidation = true, $attributes = NULL) 
    {
        //set system company id
        if ($this->isNewRecord && Yii::app()->sysCompany->getActiveCompany()){
            $this->vcnt_sys_ccmp_id = Yii::app()->sysCompany->getActiveCompany();
        }              

        return parent::save($runValidation,$attributes);

    }
    
    public function findAll($condition='',$params=array())
    {
        $criteria=$this->getCommandBuilder()->createCriteria($condition,$params);
        
        //criteria for trucks of SysCompanies
        if(Yii::app()->sysCompany->getActiveCompany()){
            $criteria->compare('t.vcnt_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        }          
        return $this->query($criteria,true);
    }        
    
    public function findByPk($pk,$condition='',$params=array())
    {
        
        $model = parent::findByPk($pk,$condition='',$params=array());

		if (Yii::app()->sysCompany->getActiveCompany()){
            if( Yii::app()->sysCompany->getActiveCompany() != $model->vcnt_sys_ccmp_id){
                throw new CHttpException(404, Yii::t('TrucksModule.crud_static', 'Requested closed data.'));
            }    
        }           
        
        return $model;
    }     
    
    
}
