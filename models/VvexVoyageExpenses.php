<?php

// auto-loading
Yii::setPathOfAlias('VvexVoyageExpenses', dirname(__FILE__));
Yii::import('VvexVoyageExpenses.*');

class VvexVoyageExpenses extends BaseVvexVoyageExpenses
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
        
        if(Yii::app()->sysCompany->getActiveCompany()){
            $criteria->join .= ' INNER JOIN vvoy_voyage v on vvoy_id = vvex_vvoy_id ';
            $criteria->compare('v.vvoy_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        }  
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }
    
    public function save($runValidation = true, $attributes = NULL) 
    {

        //on change price or count recalc total
        if(in_array('vvex_count',$attributes) || in_array('vvex_price',$attributes)){
            $this->vvex_total = round($this->vvex_count * $this->vvex_price,2);
            $attributes[] = 'vvex_total';
        }

        return parent::save($runValidation,$attributes);

    }
    
    public function findAll($condition='',$params=array())
    {
        $criteria=$this->getCommandBuilder()->createCriteria($condition,$params);
        
        //criteria for trucks of SysCompanies
        if(Yii::app()->sysCompany->getActiveCompany()){
            $criteria->join .= ' INNER JOIN vvoy_voyage vs on vvoy_id = vvex_vvoy_id ';
            $criteria->compare('vs.vvoy_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());            
        }          
        return $this->query($criteria,true);
    }        
    
    public function findByPk($pk,$condition='',$params=array())
    {
        
        $model = parent::findByPk($pk,$condition='',$params=array());

		if (Yii::app()->sysCompany->getActiveCompany()){
            if( Yii::app()->sysCompany->getActiveCompany() != $model->vvexVvoy->vvoy_sys_ccmp_id){
                throw new CHttpException(404, Yii::t('TrucksModule.crud_static', 'Requested closed data.'));
            }    
        }           
        
        return $model;
    }     
    

}
