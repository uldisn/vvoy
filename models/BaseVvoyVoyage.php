<?php

/**
 * This is the model base class for the table "vvoy_voyage".
 *
 * Columns in table "vvoy_voyage" available as properties of the model:
 * @property string $vvoy_id
 * @property string $vvoy_number
 * @property integer $vvoy_vtrc_id
 * @property integer $vvoy_vtrl_id
 * @property string $vvoy_status
 * @property integer $vvoy_fcrn_id
 * @property string $vvoy_fcrn_plan_date
 * @property string $vvoy_plan_start_date
 * @property string $vvoy_plan_end_date
 * @property string $vvoy_start_date
 * @property string $vvoy_end_date
 * @property string $vvoy_sys_ccmp_id
 * @property string $vvoy_notes
 * @property integer $vvoy_fuel_tank_start
 * @property integer $vvoy_fuel_tank_end
 * @property string $vvoy_fuel_tank_start_amt
 * @property string $vvoy_fuel_tank_end_amt
 * @property integer $vvoy_fuel
 * @property string $vvoy_fuel_amt
 * @property integer $vvoy_odo_start
 * @property integer $vvoy_odo_end
 * @property integer $vvoy_abs_odo_start
 * @property integer $vvoy_abs_odo_end
 * @property integer $vvoy_mileage
 * @property string $vvoy_vodo_id
 *
 * Relations of table "vvoy_voyage" available as properties of the model:
 * @property VcrtVvoyCurrencyRate[] $vcrtVvoyCurrencyRates
 * @property VdimDimension[] $vdimDimensions
 * @property VexpExpenses[] $vexpExpenses
 * @property VfueFuel[] $vfueFuels
 * @property VfufFuelFinv[] $vfufFuelFinvs
 * @property VpdmPlaningDimension[] $vpdmPlaningDimensions
 * @property VvclVoyageClient[] $vvclVoyageClients
 * @property VvepVoyageExpensesPlan[] $vvepVoyageExpensesPlans
 * @property VvexVoyageExpenses[] $vvexVoyageExpenses
 * @property VodoOdometer $vvoyVodo
 * @property VtrlTrailer $vvoyVtrl
 * @property FcrnCurrency $vvoyFcrn
 * @property VtrcTruck $vvoyVtrc
 * @property VvpoVoyagePoint[] $vvpoVoyagePoints
 * @property VxprVoyageXPerson[] $vxprVoyageXPeople
 */
abstract class BaseVvoyVoyage extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const VVOY_STATUS_PROJECT = 'project';
    const VVOY_STATUS_ACCEPTED = 'accepted';
    const VVOY_STATUS_IN_WAY = 'in way';
    const VVOY_STATUS_FINISHED = 'finished';
    const VVOY_STATUS_CLOSED = 'closed';
    const VVOY_STATUS_CANCELED = 'canceled';
    
    var $enum_labels = false;  

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vvoy_voyage';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vvoy_vtrc_id, vvoy_fcrn_id', 'required'),
                array('vvoy_number, vvoy_vtrl_id, vvoy_status, vvoy_fcrn_plan_date, vvoy_plan_start_date, vvoy_plan_end_date, vvoy_start_date, vvoy_end_date, vvoy_sys_ccmp_id, vvoy_notes, vvoy_fuel_tank_start, vvoy_fuel_tank_end, vvoy_fuel_tank_start_amt, vvoy_fuel_tank_end_amt, vvoy_fuel, vvoy_fuel_amt, vvoy_odo_start, vvoy_odo_end, vvoy_abs_odo_start, vvoy_abs_odo_end, vvoy_mileage, vvoy_vodo_id', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vvoy_vtrc_id, vvoy_vtrl_id, vvoy_fcrn_id, vvoy_fuel_tank_start, vvoy_fuel_tank_end, vvoy_fuel, vvoy_odo_start, vvoy_odo_end, vvoy_abs_odo_start, vvoy_abs_odo_end, vvoy_mileage', 'numerical', 'integerOnly' => true),
                array('vvoy_number', 'length', 'max' => 20),
                array('vvoy_sys_ccmp_id, vvoy_fuel_tank_start_amt, vvoy_fuel_tank_end_amt, vvoy_fuel_amt, vvoy_vodo_id', 'length', 'max' => 10),
                array('vvoy_fcrn_plan_date, vvoy_plan_start_date, vvoy_plan_end_date, vvoy_start_date, vvoy_end_date, vvoy_notes', 'safe'),
                array('vvoy_status', 'in', 'range' => array(self::VVOY_STATUS_PROJECT, self::VVOY_STATUS_ACCEPTED, self::VVOY_STATUS_IN_WAY, self::VVOY_STATUS_FINISHED, self::VVOY_STATUS_CLOSED, self::VVOY_STATUS_CANCELED)),
                array('vvoy_id, vvoy_number, vvoy_vtrc_id, vvoy_vtrl_id, vvoy_status, vvoy_fcrn_id, vvoy_fcrn_plan_date, vvoy_plan_start_date, vvoy_plan_end_date, vvoy_start_date, vvoy_end_date, vvoy_sys_ccmp_id, vvoy_notes, vvoy_fuel_tank_start, vvoy_fuel_tank_end, vvoy_fuel_tank_start_amt, vvoy_fuel_tank_end_amt, vvoy_fuel, vvoy_fuel_amt, vvoy_odo_start, vvoy_odo_end, vvoy_abs_odo_start, vvoy_abs_odo_end, vvoy_mileage, vvoy_vodo_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vvoy_number;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'vcrtVvoyCurrencyRates' => array(self::HAS_MANY, 'VcrtVvoyCurrencyRate', 'vcrt_vvoy_id'),
                'vdimDimensions' => array(self::HAS_MANY, 'VdimDimension', 'vdim_vvoy_id'),
                'vexpExpenses' => array(self::HAS_MANY, 'VexpExpenses', 'vexp_vvoy_id'),
                'vfueFuels' => array(self::HAS_MANY, 'VfueFuel', 'vfue_vvoy_id'),
                'vfufFuelFinvs' => array(self::HAS_MANY, 'VfufFuelFinv', 'vfuf_vvoy_id'),
                'vpdmPlaningDimensions' => array(self::HAS_MANY, 'VpdmPlaningDimension', 'vpdm_vvoy_id'),
                'vvclVoyageClients' => array(self::HAS_MANY, 'VvclVoyageClient', 'vvcl_vvoy_id'),
                'vvepVoyageExpensesPlans' => array(self::HAS_MANY, 'VvepVoyageExpensesPlan', 'vvep_vvoy_id'),
                'vvexVoyageExpenses' => array(self::HAS_MANY, 'VvexVoyageExpenses', 'vvex_vvoy_id'),
                'vvoyVodo' => array(self::BELONGS_TO, 'VodoOdometer', 'vvoy_vodo_id'),
                'vvoyVtrl' => array(self::BELONGS_TO, 'VtrlTrailer', 'vvoy_vtrl_id'),
                'vvoyFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vvoy_fcrn_id'),
                'vvoyVtrc' => array(self::BELONGS_TO, 'VtrcTruck', 'vvoy_vtrc_id'),
                'vvpoVoyagePoints' => array(self::HAS_MANY, 'VvpoVoyagePoint', 'vvpo_vvoy_id'),
                'vxprVoyageXPeople' => array(self::HAS_MANY, 'VxprVoyageXPerson', 'vxpr_vvoy_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vvoy_id' => Yii::t('VvoyModule.model', 'Vvoy'),
            'vvoy_number' => Yii::t('VvoyModule.model', 'Vvoy Number'),
            'vvoy_vtrc_id' => Yii::t('VvoyModule.model', 'Vvoy Vtrc'),
            'vvoy_vtrl_id' => Yii::t('VvoyModule.model', 'Vvoy Vtrl'),
            'vvoy_status' => Yii::t('VvoyModule.model', 'Vvoy Status'),
            'vvoy_fcrn_id' => Yii::t('VvoyModule.model', 'Vvoy Fcrn'),
            'vvoy_fcrn_plan_date' => Yii::t('VvoyModule.model', 'Vvoy Fcrn Plan Date'),
            'vvoy_plan_start_date' => Yii::t('VvoyModule.model', 'Vvoy Plan Start Date'),
            'vvoy_plan_end_date' => Yii::t('VvoyModule.model', 'Vvoy Plan End Date'),
            'vvoy_start_date' => Yii::t('VvoyModule.model', 'Vvoy Start Date'),
            'vvoy_end_date' => Yii::t('VvoyModule.model', 'Vvoy End Date'),
            'vvoy_sys_ccmp_id' => Yii::t('VvoyModule.model', 'Vvoy Sys Ccmp'),
            'vvoy_notes' => Yii::t('VvoyModule.model', 'Vvoy Notes'),
            'vvoy_fuel_tank_start' => Yii::t('VvoyModule.model', 'Vvoy Fuel Tank Start'),
            'vvoy_fuel_tank_end' => Yii::t('VvoyModule.model', 'Vvoy Fuel Tank End'),
            'vvoy_fuel_tank_start_amt' => Yii::t('VvoyModule.model', 'Vvoy Fuel Tank Start Amt'),
            'vvoy_fuel_tank_end_amt' => Yii::t('VvoyModule.model', 'Vvoy Fuel Tank End Amt'),
            'vvoy_fuel' => Yii::t('VvoyModule.model', 'Vvoy Fuel'),
            'vvoy_fuel_amt' => Yii::t('VvoyModule.model', 'Vvoy Fuel Amt'),
            'vvoy_odo_start' => Yii::t('VvoyModule.model', 'Vvoy Odo Start'),
            'vvoy_odo_end' => Yii::t('VvoyModule.model', 'Vvoy Odo End'),
            'vvoy_abs_odo_start' => Yii::t('VvoyModule.model', 'Vvoy Abs Odo Start'),
            'vvoy_abs_odo_end' => Yii::t('VvoyModule.model', 'Vvoy Abs Odo End'),
            'vvoy_mileage' => Yii::t('VvoyModule.model', 'Vvoy Mileage'),
            'vvoy_vodo_id' => Yii::t('VvoyModule.model', 'Vvoy Vodo'),
        );
    }

    public function enumLabels()
    {
        if($this->enum_labels){
            return $this->enum_labels;
        }    
        $this->enum_labels =  array(
           'vvoy_status' => array(
               self::VVOY_STATUS_PROJECT => Yii::t('VvoyModule.model', 'VVOY_STATUS_PROJECT'),
               self::VVOY_STATUS_ACCEPTED => Yii::t('VvoyModule.model', 'VVOY_STATUS_ACCEPTED'),
               self::VVOY_STATUS_IN_WAY => Yii::t('VvoyModule.model', 'VVOY_STATUS_IN_WAY'),
               self::VVOY_STATUS_FINISHED => Yii::t('VvoyModule.model', 'VVOY_STATUS_FINISHED'),
               self::VVOY_STATUS_CLOSED => Yii::t('VvoyModule.model', 'VVOY_STATUS_CLOSED'),
               self::VVOY_STATUS_CANCELED => Yii::t('VvoyModule.model', 'VVOY_STATUS_CANCELED'),
           ),
            );
        return $this->enum_labels;
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }

    public function getEnumColumnLabel($column){
        return $this->getEnumLabel($column,$this->$column);
    }
    

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vvoy_id', $this->vvoy_id, true);
        $criteria->compare('t.vvoy_number', $this->vvoy_number, true);
        $criteria->compare('t.vvoy_vtrc_id', $this->vvoy_vtrc_id);
        $criteria->compare('t.vvoy_vtrl_id', $this->vvoy_vtrl_id);
        $criteria->compare('t.vvoy_status', $this->vvoy_status);
        $criteria->compare('t.vvoy_fcrn_id', $this->vvoy_fcrn_id);
        $criteria->compare('t.vvoy_fcrn_plan_date', $this->vvoy_fcrn_plan_date, true);
        $criteria->compare('t.vvoy_plan_start_date', $this->vvoy_plan_start_date, true);
        $criteria->compare('t.vvoy_plan_end_date', $this->vvoy_plan_end_date, true);
        $criteria->compare('t.vvoy_start_date', $this->vvoy_start_date, true);
        $criteria->compare('t.vvoy_end_date', $this->vvoy_end_date, true);
        $criteria->compare('t.vvoy_sys_ccmp_id', $this->vvoy_sys_ccmp_id, true);
        $criteria->compare('t.vvoy_notes', $this->vvoy_notes, true);
        $criteria->compare('t.vvoy_fuel_tank_start', $this->vvoy_fuel_tank_start);
        $criteria->compare('t.vvoy_fuel_tank_end', $this->vvoy_fuel_tank_end);
        $criteria->compare('t.vvoy_fuel_tank_start_amt', $this->vvoy_fuel_tank_start_amt, true);
        $criteria->compare('t.vvoy_fuel_tank_end_amt', $this->vvoy_fuel_tank_end_amt, true);
        $criteria->compare('t.vvoy_fuel', $this->vvoy_fuel);
        $criteria->compare('t.vvoy_fuel_amt', $this->vvoy_fuel_amt, true);
        $criteria->compare('t.vvoy_odo_start', $this->vvoy_odo_start);
        $criteria->compare('t.vvoy_odo_end', $this->vvoy_odo_end);
        $criteria->compare('t.vvoy_abs_odo_start', $this->vvoy_abs_odo_start);
        $criteria->compare('t.vvoy_abs_odo_end', $this->vvoy_abs_odo_end);
        $criteria->compare('t.vvoy_mileage', $this->vvoy_mileage);
        $criteria->compare('t.vvoy_vodo_id', $this->vvoy_vodo_id);


        return $criteria;

    }

}
