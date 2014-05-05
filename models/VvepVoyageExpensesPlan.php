<?php

// auto-loading
Yii::setPathOfAlias('VvepVoyageExpensesPlan', dirname(__FILE__));
Yii::import('VvepVoyageExpensesPlan.*');

class VvepVoyageExpensesPlan extends BaseVvepVoyageExpensesPlan
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
        
//        if(Yii::app()->sysCompany->getActiveCompany()){
//            $criteria->join .= ' INNER JOIN vvoy_voyage vs on vs.vvoy_id = vvep_vvoy_id ';
//            $criteria->compare('vs.vvoy_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
//        }  
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }
    
    public function save($runValidation = true, $attributes = NULL) 
    {

        //on change price or count recalc total
        if($attributes && (in_array('vvep_count',$attributes) || in_array('vvep_price',$attributes))){
            $this->vvep_total = round($this->vvep_count * $this->vvep_price,2);
            $attributes[] = 'vvep_total';
        }

        return parent::save($runValidation,$attributes);

    }
    
    public function findAll($condition='',$params=array())
    {
        $criteria=$this->getCommandBuilder()->createCriteria($condition,$params);
        
        //criteria for trucks of SysCompanies
        if(Yii::app()->sysCompany->getActiveCompany()){
            $criteria->join .= ' INNER JOIN vvoy_voyage vs on vs.vvoy_id = t.vvep_vvoy_id ';
            $criteria->compare('vs.vvoy_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());            
        }          
        return $this->query($criteria,true);
    }        
    
    public function findByPk($pk,$condition='',$params=array())
    {
        
        $model = parent::findByPk($pk,$condition='',$params=array());

		if (Yii::app()->sysCompany->getActiveCompany()){
            if( Yii::app()->sysCompany->getActiveCompany() != $model->vvepVvoy->vvoy_sys_ccmp_id){
                throw new CHttpException(404, Yii::t('TrucksModule.crud_static', 'Requested closed data.'));
            }    
        }           
        
        return $model;
    }     
    

}
