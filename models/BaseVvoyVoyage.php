<?php

/**
 * This is the model base class for the table "vvoy_voyage".
 *
 * Columns in table "vvoy_voyage" available as properties of the model:
 * @property string $vvoy_id
 * @property string $vvoy_ccmp_id
 * @property string $vvoy_number
 * @property integer $vvoy_vtrc_id
 * @property integer $vvoy_vtrl_id
 * @property string $vvoy_status
 * @property integer $vvoy_fcrn_id
 * @property string $vvoy_start_date
 * @property string $vvoy_end_date
 * @property string $vvoy_sys_ccmp_id
 * @property string $vvoy_notes
 *
 * Relations of table "vvoy_voyage" available as properties of the model:
 * @property VvclVoyageClient[] $vvclVoyageClients
 * @property VvepVoyageExpensesPlan[] $vvepVoyageExpensesPlans
 * @property VvexVoyageExpenses[] $vvexVoyageExpenses
 * @property CcmpCompany $vvoyCcmp
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
    const VVOY_STATUS_NEW = 'new';
    const VVOY_STATUS_WAY = 'way';
    const VVOY_STATUS_FINISH = 'finish';
    const VVOY_STATUS_CLOSED = 'closed';

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
                array('vvoy_ccmp_id, vvoy_vtrc_id, vvoy_fcrn_id', 'required'),
                array('vvoy_number, vvoy_vtrl_id, vvoy_status, vvoy_start_date, vvoy_end_date, vvoy_sys_ccmp_id, vvoy_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vvoy_vtrc_id, vvoy_vtrl_id, vvoy_fcrn_id', 'numerical', 'integerOnly' => true),
                array('vvoy_ccmp_id, vvoy_sys_ccmp_id', 'length', 'max' => 10),
                array('vvoy_number', 'length', 'max' => 20),
                array('vvoy_status', 'length', 'max' => 6),
                array('vvoy_start_date, vvoy_end_date, vvoy_notes', 'safe'),
                array('vvoy_id, vvoy_ccmp_id, vvoy_number, vvoy_vtrc_id, vvoy_vtrl_id, vvoy_status, vvoy_fcrn_id, vvoy_start_date, vvoy_end_date, vvoy_sys_ccmp_id, vvoy_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vvoy_ccmp_id;
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
                'vvclVoyageClients' => array(self::HAS_MANY, 'VvclVoyageClient', 'vvcl_vvoy_id'),
                'vvepVoyageExpensesPlans' => array(self::HAS_MANY, 'VvepVoyageExpensesPlan', 'vvep_vvoy_id'),
                'vvexVoyageExpenses' => array(self::HAS_MANY, 'VvexVoyageExpenses', 'vvex_vvoy_id'),
                'vvoyCcmp' => array(self::BELONGS_TO, 'CcmpCompany', 'vvoy_ccmp_id'),
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
            'vvoy_ccmp_id' => Yii::t('VvoyModule.model', 'Vvoy Ccmp'),
            'vvoy_number' => Yii::t('VvoyModule.model', 'Vvoy Number'),
            'vvoy_vtrc_id' => Yii::t('VvoyModule.model', 'Vvoy Vtrc'),
            'vvoy_vtrl_id' => Yii::t('VvoyModule.model', 'Vvoy Vtrl'),
            'vvoy_status' => Yii::t('VvoyModule.model', 'Vvoy Status'),
            'vvoy_fcrn_id' => Yii::t('VvoyModule.model', 'Vvoy Fcrn'),
            'vvoy_start_date' => Yii::t('VvoyModule.model', 'Vvoy Start Date'),
            'vvoy_end_date' => Yii::t('VvoyModule.model', 'Vvoy End Date'),
            'vvoy_sys_ccmp_id' => Yii::t('VvoyModule.model', 'Vvoy Sys Ccmp'),
            'vvoy_notes' => Yii::t('VvoyModule.model', 'Vvoy Notes'),
        );
    }

    public function enumLabels()
    {
        return array(
           'vvoy_status' => array(
               self::VVOY_STATUS_NEW => Yii::t('VvoyModule.model', 'VVOY_STATUS_NEW'),
               self::VVOY_STATUS_WAY => Yii::t('VvoyModule.model', 'VVOY_STATUS_WAY'),
               self::VVOY_STATUS_FINISH => Yii::t('VvoyModule.model', 'VVOY_STATUS_FINISH'),
               self::VVOY_STATUS_CLOSED => Yii::t('VvoyModule.model', 'VVOY_STATUS_CLOSED'),
           ),
            );
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


    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vvoy_id', $this->vvoy_id, true);
        $criteria->compare('t.vvoy_ccmp_id', $this->vvoy_ccmp_id);
        $criteria->compare('t.vvoy_number', $this->vvoy_number, true);
        $criteria->compare('t.vvoy_vtrc_id', $this->vvoy_vtrc_id);
        $criteria->compare('t.vvoy_vtrl_id', $this->vvoy_vtrl_id);
        $criteria->compare('t.vvoy_status', $this->vvoy_status, true);
        $criteria->compare('t.vvoy_fcrn_id', $this->vvoy_fcrn_id);
        $criteria->compare('t.vvoy_start_date', $this->vvoy_start_date, true);
        $criteria->compare('t.vvoy_end_date', $this->vvoy_end_date, true);
        $criteria->compare('t.vvoy_sys_ccmp_id', $this->vvoy_sys_ccmp_id, true);
        $criteria->compare('t.vvoy_notes', $this->vvoy_notes, true);


        return $criteria;

    }

}
