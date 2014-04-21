<?php

/**
 * This is the model base class for the table "vvpo_voyage_point".
 *
 * Columns in table "vvpo_voyage_point" available as properties of the model:
 * @property string $vvpo_id
 * @property string $vvpo_vvoy_id
 * @property integer $vvpo_vpnt_id
 * @property integer $vvpo_sqn
 * @property string $vvpo_plan_start_date
 * @property string $vvpo_plan_end_date
 * @property integer $vvpo_plan_km
 * @property string $vvpo_plan_fuel_coefficient
 * @property string $vvpo_plan_fuel_price
 * @property integer $vvpo_plan_fcrn_id
 * @property string $vvpo_notes
 * @property string $vvpo_start_odo
 * @property string $vvpo_end_odo
 * @property string $vvpo_real_start_date
 * @property string $vvpo_real_end_date
 *
 * Relations of table "vvpo_voyage_point" available as properties of the model:
 * @property FcrnCurrency $vvpoPlanFcrn
 * @property VvoyVoyage $vvpoVvoy
 * @property VpntPoint $vvpoVpnt
 */
abstract class BaseVvpoVoyagePoint extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vvpo_voyage_point';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vvpo_vvoy_id', 'required'),
                array('vvpo_vpnt_id, vvpo_sqn, vvpo_plan_start_date, vvpo_plan_end_date, vvpo_plan_km, vvpo_plan_fuel_coefficient, vvpo_plan_fuel_price, vvpo_plan_fcrn_id, vvpo_notes, vvpo_start_odo, vvpo_end_odo, vvpo_real_start_date, vvpo_real_end_date', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vvpo_vpnt_id, vvpo_sqn, vvpo_plan_km, vvpo_plan_fcrn_id', 'numerical', 'integerOnly' => true),
                array('vvpo_vvoy_id, vvpo_plan_fuel_price, vvpo_start_odo, vvpo_end_odo', 'length', 'max' => 10),
                array('vvpo_plan_fuel_coefficient', 'length', 'max' => 2),
                array('vvpo_plan_start_date, vvpo_plan_end_date, vvpo_notes, vvpo_real_start_date, vvpo_real_end_date', 'safe'),
                array('vvpo_id, vvpo_vvoy_id, vvpo_vpnt_id, vvpo_sqn, vvpo_plan_start_date, vvpo_plan_end_date, vvpo_plan_km, vvpo_plan_fuel_coefficient, vvpo_plan_fuel_price, vvpo_plan_fcrn_id, vvpo_notes, vvpo_start_odo, vvpo_end_odo, vvpo_real_start_date, vvpo_real_end_date', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vvpo_vvoy_id;
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
                'vvpoPlanFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vvpo_plan_fcrn_id'),
                'vvpoVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vvpo_vvoy_id'),
                'vvpoVpnt' => array(self::BELONGS_TO, 'VpntPoint', 'vvpo_vpnt_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vvpo_id' => Yii::t('VvoyModule.model', 'Vvpo'),
            'vvpo_vvoy_id' => Yii::t('VvoyModule.model', 'Vvpo Vvoy'),
            'vvpo_vpnt_id' => Yii::t('VvoyModule.model', 'Vvpo Vpnt'),
            'vvpo_sqn' => Yii::t('VvoyModule.model', 'Vvpo Sqn'),
            'vvpo_plan_start_date' => Yii::t('VvoyModule.model', 'Vvpo Plan Start Date'),
            'vvpo_plan_end_date' => Yii::t('VvoyModule.model', 'Vvpo Plan End Date'),
            'vvpo_plan_km' => Yii::t('VvoyModule.model', 'Vvpo Plan Km'),
            'vvpo_plan_fuel_coefficient' => Yii::t('VvoyModule.model', 'Vvpo Plan Fuel Coefficient'),
            'vvpo_plan_fuel_price' => Yii::t('VvoyModule.model', 'Vvpo Plan Fuel Price'),
            'vvpo_plan_fcrn_id' => Yii::t('VvoyModule.model', 'Vvpo Plan Fcrn'),
            'vvpo_notes' => Yii::t('VvoyModule.model', 'Vvpo Notes'),
            'vvpo_start_odo' => Yii::t('VvoyModule.model', 'Vvpo Start Odo'),
            'vvpo_end_odo' => Yii::t('VvoyModule.model', 'Vvpo End Odo'),
            'vvpo_real_start_date' => Yii::t('VvoyModule.model', 'Vvpo Real Start Date'),
            'vvpo_real_end_date' => Yii::t('VvoyModule.model', 'Vvpo Real End Date'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vvpo_id', $this->vvpo_id, true);
        $criteria->compare('t.vvpo_vvoy_id', $this->vvpo_vvoy_id);
        $criteria->compare('t.vvpo_vpnt_id', $this->vvpo_vpnt_id);
        $criteria->compare('t.vvpo_sqn', $this->vvpo_sqn);
        $criteria->compare('t.vvpo_plan_start_date', $this->vvpo_plan_start_date, true);
        $criteria->compare('t.vvpo_plan_end_date', $this->vvpo_plan_end_date, true);
        $criteria->compare('t.vvpo_plan_km', $this->vvpo_plan_km);
        $criteria->compare('t.vvpo_plan_fuel_coefficient', $this->vvpo_plan_fuel_coefficient, true);
        $criteria->compare('t.vvpo_plan_fuel_price', $this->vvpo_plan_fuel_price, true);
        $criteria->compare('t.vvpo_plan_fcrn_id', $this->vvpo_plan_fcrn_id);
        $criteria->compare('t.vvpo_notes', $this->vvpo_notes, true);
        $criteria->compare('t.vvpo_start_odo', $this->vvpo_start_odo, true);
        $criteria->compare('t.vvpo_end_odo', $this->vvpo_end_odo, true);
        $criteria->compare('t.vvpo_real_start_date', $this->vvpo_real_start_date, true);
        $criteria->compare('t.vvpo_real_end_date', $this->vvpo_real_end_date, true);


        return $criteria;

    }

}
