<?php

// auto-loading
Yii::setPathOfAlias('VvoyVoyage', dirname(__FILE__));
Yii::import('VvoyVoyage.*');

class VvoyVoyage extends BaseVvoyVoyage
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

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'freightTotal'=>array(self::STAT,  'vvclVoyageClient', 'vvcl_vvoy_id', 'select' => 'SUM(vvcl_base_amt)'),                
                'expensesTotal'=>array(self::STAT,  'VvepVoyageExpensesPlan', 'vvep_vvoy_id', 'select' => 'SUM(vvep_base_total)'),                
                'fuelTotal'=>array(self::STAT,  'VvpoVoyagePoint', 'vvpo_vvoy_id', 'select' => 'SUM(vvpo_plan_base_amt)'),                
                //'fuelTotal'=>array(self::STAT,  'VvpoVoyagePoint', 'vvpo_vvoy_id', 'select' => 'SUM(vvep_base_total)'),                
                
//                'vvclVoyageClients' => array(self::HAS_MANY, 'VvclVoyageClient', 'vvcl_vvoy_id'),
//                'vvepVoyageExpensesPlans' => array(self::HAS_MANY, 'VvepVoyageExpensesPlan', 'vvep_vvoy_id'),
//                'vvexVoyageExpenses' => array(self::HAS_MANY, 'VvexVoyageExpenses', 'vvex_vvoy_id'),
//                'vvoyVtrl' => array(self::BELONGS_TO, 'VtrlTrailer', 'vvoy_vtrl_id'),
//                'vvoyFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vvoy_fcrn_id'),
//                'vvoyVtrc' => array(self::BELONGS_TO, 'VtrcTruck', 'vvoy_vtrc_id'),
//                'vvpoVoyagePoints' => array(self::HAS_MANY, 'VvpoVoyagePoint', 'vvpo_vvoy_id'),
//                'vxprVoyageXPeople' => array(self::HAS_MANY, 'VxprVoyageXPerson', 'vxpr_vvoy_id'),
            )
        );
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
    
    public function save($runValidation = true, $attributes = NULL) 
    {
        //set system company id
        if ($this->isNewRecord && Yii::app()->sysCompany->getActiveCompany()){
            $this->vvoy_sys_ccmp_id = Yii::app()->sysCompany->getActiveCompany();
        }              
        
        //is new
        $bIsNewRecord = $this->isNewRecord;
        
        //save
        $r = parent::save($runValidation,$attributes);
        
        if(!$r){
            return $r;
        }
        
        
        if(!$bIsNewRecord){
            return true;
        }
        
        // For new record add default records to voyage related tables        
        //add one empty client
        $vvcl = new VvclVoyageClient;
        $vvcl->vvcl_vvoy_id = $this->vvoy_id;
        $vvcl->vvcl_fcrn_id = $this->vvoy_fcrn_id;
        $vvcl->save();
            

        //add defeult expanse positions
        $default_vepo = VepoExpensesPositions::model()->findAll('vepo_default = 1');
        foreach ($default_vepo as $vepo) {
            $vvep = new VvepVoyageExpensesPlan;
            $vvep->vvep_vvoy_id = $this->vvoy_id;
            $vvep->vvep_vepo_id = $vepo->vepo_id;
            $vvep->vvep_fcrn_id = $this->vvoy_fcrn_id;
            $vvep->save();
        }
        
        //add first point
        $vvpo = new VvpoVoyagePoint;
        $vvpo->vvpo_vvoy_id = $this->vvoy_id;
        $vvpo->vvpo_sqn = 1;
        $vvpo->vvpo_plan_fcrn_id = $this->vvoy_fcrn_id;
        $vvpo->save();

        //add second point
        $vvpo = new VvpoVoyagePoint;
        $vvpo->vvpo_vvoy_id = $this->vvoy_id;
        $vvpo->vvpo_sqn = 2;
        $vvpo->vvpo_plan_fcrn_id = $this->vvoy_fcrn_id;
        $vvpo->save();

        //add driver empty
        $vxpr = new VxprVoyageXPerson;
        $vxpr->vxpr_vvoy_id = $this->vvoy_id;
        $vxpr->save();

        return true;

    }    
    
    public function findAll($condition='',$params=array())
    {
        $criteria=$this->getCommandBuilder()->createCriteria($condition,$params);
        
        //criteria for trucks of SysCompanies
        if(Yii::app()->sysCompany->getActiveCompany()){
            $criteria->compare('t.vvoy_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        }          
        return $this->query($criteria,true);
    }       

    public function findByPk($pk,$condition='',$params=array())
    {
        
        $model = parent::findByPk($pk,$condition='',$params=array());

		if (Yii::app()->sysCompany->getActiveCompany()){
            if( Yii::app()->sysCompany->getActiveCompany() != $model->vvoy_sys_ccmp_id){
                throw new CHttpException(404, Yii::t('TrucksModule.crud_static', 'Requested closed data.'));
            }    
        }           
        
        return $model;
    }        
    
}
