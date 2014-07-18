<?php

/**
 * This is the model base class for the table "vfue_fuel".
 *
 * Columns in table "vfue_fuel" available as properties of the model:
 * @property string $vfue_id
 * @property string $vfue_vvoy_id
 * @property string $vfue_number
 * @property string $vfue_date
 * @property integer $vfue_fcrn_id
 * @property string $vfue_fuel_type
 * @property string $vfue_qnt
 * @property string $vfue_amt
 * @property integer $vfue_base_fcrn_id
 * @property string $vfue_base_amt
 * @property string $vfue_notes
 *
 * Relations of table "vfue_fuel" available as properties of the model:
 * @property FcrnCurrency $vfueFcrn
 * @property FcrnCurrency $vfueBaseFcrn
 * @property VvoyVoyage $vfueVvoy
 */
abstract class BaseVfueFuel extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vfue_fuel';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vfue_vvoy_id', 'required'),
                array('vfue_number, vfue_date, vfue_fcrn_id, vfue_fuel_type, vfue_qnt, vfue_amt, vfue_base_fcrn_id, vfue_base_amt, vfue_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vfue_fcrn_id, vfue_base_fcrn_id', 'numerical', 'integerOnly' => true),
                array('vfue_vvoy_id, vfue_fuel_type, vfue_qnt, vfue_amt, vfue_base_amt', 'length', 'max' => 10),
                array('vfue_number', 'length', 'max' => 100),
                array('vfue_date, vfue_notes', 'safe'),
                array('vfue_id, vfue_vvoy_id, vfue_number, vfue_date, vfue_fcrn_id, vfue_fuel_type, vfue_qnt, vfue_amt, vfue_base_fcrn_id, vfue_base_amt, vfue_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vfue_vvoy_id;
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
                'vfueFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vfue_fcrn_id'),
                'vfueBaseFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vfue_base_fcrn_id'),
                'vfueVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vfue_vvoy_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vfue_id' => Yii::t('VvoyModule.model', 'Vfue'),
            'vfue_vvoy_id' => Yii::t('VvoyModule.model', 'Vfue Vvoy'),
            'vfue_number' => Yii::t('VvoyModule.model', 'Vfue Number'),
            'vfue_date' => Yii::t('VvoyModule.model', 'Vfue Date'),
            'vfue_fcrn_id' => Yii::t('VvoyModule.model', 'Vfue Fcrn'),
            'vfue_fuel_type' => Yii::t('VvoyModule.model', 'Vfue Fuel Type'),
            'vfue_qnt' => Yii::t('VvoyModule.model', 'Vfue Qnt'),
            'vfue_amt' => Yii::t('VvoyModule.model', 'Vfue Amt'),
            'vfue_base_fcrn_id' => Yii::t('VvoyModule.model', 'Vfue Base Fcrn'),
            'vfue_base_amt' => Yii::t('VvoyModule.model', 'Vfue Base Amt'),
            'vfue_notes' => Yii::t('VvoyModule.model', 'Vfue Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vfue_id', $this->vfue_id, true);
        $criteria->compare('t.vfue_vvoy_id', $this->vfue_vvoy_id);
        $criteria->compare('t.vfue_number', $this->vfue_number, true);
        $criteria->compare('t.vfue_date', $this->vfue_date, true);
        $criteria->compare('t.vfue_fcrn_id', $this->vfue_fcrn_id);
        $criteria->compare('t.vfue_fuel_type', $this->vfue_fuel_type, true);
        $criteria->compare('t.vfue_qnt', $this->vfue_qnt, true);
        $criteria->compare('t.vfue_amt', $this->vfue_amt, true);
        $criteria->compare('t.vfue_base_fcrn_id', $this->vfue_base_fcrn_id);
        $criteria->compare('t.vfue_base_amt', $this->vfue_base_amt, true);
        $criteria->compare('t.vfue_notes', $this->vfue_notes, true);


        return $criteria;

    }

}
