<?php

// auto-loading
Yii::setPathOfAlias('VvoyVoyage', dirname(__FILE__));
Yii::import('VvoyVoyage.*');

class VvoyVoyage extends BaseVvoyVoyage
{
    
    private $oldAttrs = array();

        // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        $this->vvoy_fcrn_id = Yii::app()->sysCompany->getAttribute('base_fcrn_id');
        return parent::init();
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'freightPlanTotal'=>array(self::STAT,  'VvclVoyageClient', 'vvcl_vvoy_id', 'select' => 'SUM(vvcl_plan_base_amt)'),                
                'freightTotal'=>array(self::STAT,  'VvclVoyageClient', 'vvcl_vvoy_id', 'select' => 'SUM(vvcl_base_amt)'),                
                'expensesPlanTotal'=>array(self::STAT,  'VvepVoyageExpensesPlan', 'vvep_vvoy_id', 'select' => 'SUM(vvep_base_total)'),                
                'fuelPlanTotalAmt'=>array(self::STAT,  'VvpoVoyagePoint', 'vvpo_vvoy_id', 'select' => 'SUM(vvpo_plan_base_amt)'),                
                'fuelPlanTotalQnt'=>array(self::STAT,  'VvpoVoyagePoint', 'vvpo_vvoy_id', 'select' => 'SUM(round(vvpo_plan_amt/vvpo_plan_fuel_price,2))'),                
                'fuelExoTotal'=>array(self::STAT,  'VfueFuel', 'vfue_vvoy_id', 'select' => 'SUM(vfue_base_amt)'),                
                'fuelExoTotalQnt'=>array(self::STAT,  'VfueFuel', 'vfue_vvoy_id', 'select' => 'SUM(vfue_qnt)'),                
                'milagePlanTotal'=>array(self::STAT,  'VvpoVoyagePoint', 'vvpo_vvoy_id', 'select' => 'SUM(vvpo_plan_km)'),                
                'vexpBaseAmtTotal'=>array(self::STAT,  'VexpExpenses', 'vexp_vvoy_id', 'select' => 'SUM(vexp_base_amt)'),                
                'vdimBaseAmtTotal'=>array(self::STAT,  'VdimDimension', 'vdim_vvoy_id', 'select' => 'SUM(vdim_base_amt)'),                
                'vpdmBaseAmtTotal'=>array(self::STAT,  'VpdmPlaningDimension', 'vpdm_vvoy_id', 'select' => 'SUM(vpdm_base_amt)'),                
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

    public function rules() {
        return array_merge(
                array(
                    array('vvoy_mileage,vvoy_odo_start,vvoy_odo_end', 'validateVodo'), 
                ), 
            parent::rules(),
                array(
                    array('vvoy_fcrn_plan_date', 'validateFcrnPlanDate'),                    
                )
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
    
    public function beforeSave() {
        if (!$this->isNewRecord && !VvoyVoyage::model()->findByPk($this->primaryKey)) {
            return false;
        }

        if (!$this->isNewRecord) {
           
            if ($this->isReadyVodo()) {
                if ($id = $this->processVodo()) {
                    $this->vvoy_vodo_id = $id;
                }
            }
        }

        return parent::beforeSave();
    }

    public function save($runValidation = true, $attributes = NULL) 
    {
        //set system company id
        if ($this->isNewRecord && Yii::app()->sysCompany->getActiveCompany()){
            $this->vvoy_sys_ccmp_id = Yii::app()->sysCompany->getActiveCompany();
        }              

        if (!$this->isNewRecord){
            $oldAttrs = $this->getOldAttributes();
            
            //if changed plane start dates, update start date
            if($oldAttrs['vvoy_plan_start_date'] != $this->vvoy_plan_start_date){
                $this->vvoy_start_date = $this->vvoy_plan_start_date;
                if(!empty($attributes)){
                    $attributes[] = 'vvoy_start_date';
                }
            }
            
            //if changed plane end dates, update end date
            if($oldAttrs['vvoy_plan_end_date'] != $this->vvoy_plan_end_date){
                $this->vvoy_end_date = $this->vvoy_plan_end_date;
                if(!empty($attributes)){
                    $attributes[] = 'vvoy_end_date';
                }                
            }            
        }
        
        return parent::save($runValidation,$attributes);

    }    

    protected function afterSave()
    {

         $oldAttrs = $this->getOldAttributes();
        //plan currency rates
        if(!empty($this->vvoy_fcrn_id) 
                && !empty($this->vvoy_fcrn_plan_date)           
                && ($this->isNewRecord
                    || $oldAttrs['vvoy_fcrn_id'] != $this->vvoy_fcrn_id 
                    || $oldAttrs['vvoy_fcrn_plan_date'] != $this->vvoy_fcrn_plan_date
                )
         ){
            $vcrt = new VcrtVvoyCurrencyRate;
            $vcrt->deleteRates($this->vvoy_id);
            $vcrt->fillRates($this->vvoy_id,$this->vvoy_fcrn_plan_date,$this->vvoy_fcrn_id);
        }            
        
        if(!$this->isNewRecord){
            
            if(!$this->isReadyVodo()){        
                if(!$this->processVodo()){
                    parent::afterSave();
                    return;
                }        
            }            
            
            $this->recalcItems();
            $this->recalcTotals();
            parent::afterSave();
            return;
        }
        
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
        
        parent::afterSave();
    }    
    
    public function recalcItems(){
        
        foreach($this->vfueFuels as $cm){
            $cm->save();
        }

        foreach($this->vvclVoyageClients as $cm){
            $cm->save();
        }
        
        foreach($this->vvpoVoyagePoints as $cm){
            $cm->save();
        }

        foreach($this->vexpExpenses as $cm){
            $cm->save();
        }

        VdimDimension::recalcVvoyData($this->vvoy_id);
        
    }
    
    /**
     * weighted average price
     * @return null
     */
    public function recalcTotals(){
        
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
        
        $this->vvoy_fuel_tank_end_amt = round($avarge_price*$this->vvoy_fuel_tank_end,2);
        $this->vvoy_fuel = $this->vvoy_fuel_tank_start + $this->fuelExoTotalQnt - $this->vvoy_fuel_tank_end;
        $this->vvoy_fuel_amt = $this->vvoy_fuel_tank_start_amt + $this->fuelExoTotal - $this->vvoy_fuel_tank_end_amt;        
        
        $attributes = array(
                'vvoy_fuel_tank_end_amt',
                'vvoy_fuel',
                'vvoy_fuel_amt',
            );
            try {
                if ($r = parent::save(true, $attributes)) {
                    return $r;
                }
            } catch (Exception $e) {
                $e = $e->getMessage();
                var_dump($e);
                exit;
            }
        return; 
        
    }
    
    public function isReadyVodo(){
        $oldAttrs = $this->getOldAttributes();
        if($oldAttrs['vvoy_odo_start'] == $this->vvoy_odo_start
                && $oldAttrs['vvoy_odo_end'] == $this->vvoy_odo_end
                && $oldAttrs['vvoy_mileage'] == $this->vvoy_mileage
                && $oldAttrs['vvoy_vtrc_id'] == $this->vvoy_vtrc_id
                && $oldAttrs['vvoy_start_date'] == $this->vvoy_start_date
                && $oldAttrs['vvoy_end_date'] == $this->vvoy_end_date
                ) 
        {
            //no changes
            return false;
        }

        if(empty($this->vvoy_odo_start)
                || empty($this->vvoy_odo_end)
                || empty($this->vvoy_mileage)
                || empty($this->vvoy_vtrc_id)
                || empty($this->vvoy_start_date)
                || empty($this->vvoy_end_date)
                ) 
        {
            //no complete info
            return false;
        }
        
        return true;
        
    }
    
    public function validateVodo($attribute){
        if($this->isNewRecord){
            return;
        }        
        if(!$this->isReadyVodo()){
            return;
        }        
        
        if(!$this->processVodo(true,$attribute)){
             $this->addError($attribute, Yii::t('VvoyModule.crud', 'Invalid odometer readings.'));
        }
        
    }

    public function validateFcrnPlanDate($attribute){
        
        if(empty($this->vvoy_fcrn_plan_date)){
            return;
        }        
        
        if(empty($this->vvoy_fcrn_id)){
            return;
        }        
        
        //get actual rates
        if(!Yii::app()->currency->isRateForDate($this->vvoy_fcrn_plan_date)){
             $this->addError($attribute, Yii::t('VvoyModule.crud', 'For date do not exist rate.'));
        }
        
    }
    
    public function processVodo($only_validate = false,$attribute = false){
        
        if(empty($this->vvoy_vodo_id)){
            $vodo = new VodoOdometer();
        }else{
            $vodo = $this->vvoyVodo;
        }
        $vodo->vodo_vtrc_id = $this->vvoy_vtrc_id;
        $vodo->vodo_start_odo = $this->vvoy_odo_start;
        $vodo->vodo_end_odo = $this->vvoy_abs_odo_end;
        $vodo->vodo_start_datetime = $this->vvoy_start_date;
        $vodo->vodo_end_datetime = $this->vvoy_end_date;
        $vodo->vodo_run = $this->vvoy_mileage;
        $vodo->setVodoType();
        
        //validate
        if ($only_validate) {
            if (!$vodo->validate()) {
                foreach ($vodo->errors as $atribute => $error) {
                    foreach($error as $err){
                        $this->addError($attribute, $err);
                    }
                }
                return false;
            }
            return true;
        }

        //save
        if(!$vodo->save()){
            foreach($vodo->errors as $atribute => $error){
                $this->addError($this->tableSchema->primaryKey, $error);
            }
            return false;
        }
        return $vodo->vodo_id;
    }
    
    protected function beforeFind() {
        $criteria = new CDbCriteria;
        $criteria->compare('vvoy_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        $this->dbCriteria->mergeWith($criteria);
        parent::beforeFind();
    }    
    
    protected function afterFind()
    {
        // Save old values
        $this->setOldAttributes($this->getAttributes());

        return parent::afterFind();
    }

    public function getOldAttributes()
    {
        return $this->oldAttrs;
    }

    public function setOldAttributes($attrs)
    {
        $this->oldAttrs = $attrs;
    }    
}