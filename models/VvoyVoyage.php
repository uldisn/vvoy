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
                'freightPlanTotal'=>array(self::STAT,  'VvclVoyageClient', 'vvcl_vvoy_id', 'select' => 'SUM(vvcl_base_amt)'),                
                'expensesPlanTotal'=>array(self::STAT,  'VvepVoyageExpensesPlan', 'vvep_vvoy_id', 'select' => 'SUM(vvep_base_total)'),                
                'fuelPlanTotal'=>array(self::STAT,  'VvpoVoyagePoint', 'vvpo_vvoy_id', 'select' => 'SUM(vvpo_plan_base_amt)'),                
                'fuelExoTotal'=>array(self::STAT,  'VfueFuel', 'vfue_vvoy_id', 'select' => 'SUM(vfue_base_amt)'),                
                'fuelExoTotalQnt'=>array(self::STAT,  'VfueFuel', 'vfue_vvoy_id', 'select' => 'SUM(vfue_qnt)'),                
                'milagePlanTotal'=>array(self::STAT,  'VvpoVoyagePoint', 'vvpo_vvoy_id', 'select' => 'SUM(vvpo_plan_km)'),                
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
        
        $vvoy_fuel_tank_end_amt = $this->calcFuelTankEndAmt();
        if(!is_null($vvoy_fuel_tank_end_amt)){
            
            $this->vvoy_fuel_tank_end_amt = $vvoy_fuel_tank_end_amt;
            $attributes[] = 'vvoy_fuel_tank_end_amt';
            
            $this->vvoy_fuel = $this->vvoy_fuel_tank_start + $this->fuelExoTotalQnt - $this->vvoy_fuel_tank_end;
            $attributes[] = 'vvoy_fuel';
            
            $this->vvoy_fuel_amt = $this->vvoy_fuel_tank_start_amt + $this->fuelExoTotal - $this->vvoy_fuel_tank_end_amt;
            $attributes[] = 'vvoy_fuel_amt';
            
        }
        
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
    
    /**
     * weighted average price
     * @return null
     */
    public function calcFuelTankEndAmt(){
        
        /**
         * validate, is set all data
         */
        if(empty($this->vvoy_fuel_tank_start)){
            return false;
        }

        if(empty($this->vvoy_fuel_tank_end)){
            return false;
        }

        if(empty($this->vvoy_fuel_tank_start_amt)){
            return false;
        }

        if(empty($this->vfueFuels)){
            return false;
        }
        
        //calc
        $total_amt = $this->vvoy_fuel_tank_start_amt + $this->fuelExoTotal;
        $total_fuel = $this->vvoy_fuel_tank_start + $this->fuelExoTotalQnt - $this->vvoy_fuel_tank_end;
        $avarge_price = $total_amt/$total_fuel;
        
        return round($avarge_price*$this->vvoy_fuel_tank_end,2);
        
    }
    
    protected function beforeFind() {
        $criteria = new CDbCriteria;
        $criteria->compare('vvoy_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        $this->dbCriteria->mergeWith($criteria);
        parent::beforeFind();
    }    
}