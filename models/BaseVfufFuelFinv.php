<?php

/**
 * This is the model base class for the table "vfuf_fuel_finv".
 *
 * Columns in table "vfuf_fuel_finv" available as properties of the model:
 * @property string $vfuf_id
 * @property string $vfuf_vvoy_id
 * @property string $vfuf_fixr_id
 * @property string $vfuf_qnt
 * @property string $vfuf_date
 * @property string $vfuf_base_amt
 * @property string $vfuf_notes
 *
 * Relations of table "vfuf_fuel_finv" available as properties of the model:
 * @property FixrFiitXRef $vfufFixr
 * @property VvoyVoyage $vfufVvoy
 */
abstract class BaseVfufFuelFinv extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vfuf_fuel_finv';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vfuf_fixr_id, vfuf_qnt', 'required'),
                array('vfuf_vvoy_id, vfuf_date, vfuf_base_amt, vfuf_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vfuf_vvoy_id, vfuf_fixr_id, vfuf_qnt, vfuf_base_amt', 'length', 'max' => 10),
                array('vfuf_date, vfuf_notes', 'safe'),
                array('vfuf_id, vfuf_vvoy_id, vfuf_fixr_id, vfuf_qnt, vfuf_date, vfuf_base_amt, vfuf_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vfuf_vvoy_id;
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
                'vfufFixr' => array(self::BELONGS_TO, 'FixrFiitXRef', 'vfuf_fixr_id'),
                'vfufVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vfuf_vvoy_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vfuf_id' => Yii::t('VvoyModule.model', 'Vfuf'),
            'vfuf_vvoy_id' => Yii::t('VvoyModule.model', 'Vfuf Vvoy'),
            'vfuf_fixr_id' => Yii::t('VvoyModule.model', 'Vfuf Fixr'),
            'vfuf_qnt' => Yii::t('VvoyModule.model', 'Vfuf Qnt'),
            'vfuf_date' => Yii::t('VvoyModule.model', 'Vfuf Date'),
            'vfuf_base_amt' => Yii::t('VvoyModule.model', 'Vfuf Base Amt'),
            'vfuf_notes' => Yii::t('VvoyModule.model', 'Vfuf Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vfuf_id', $this->vfuf_id, true);
        $criteria->compare('t.vfuf_vvoy_id', $this->vfuf_vvoy_id);
        $criteria->compare('t.vfuf_fixr_id', $this->vfuf_fixr_id);
        $criteria->compare('t.vfuf_qnt', $this->vfuf_qnt, true);
        $criteria->compare('t.vfuf_date', $this->vfuf_date, true);
        $criteria->compare('t.vfuf_base_amt', $this->vfuf_base_amt, true);
        $criteria->compare('t.vfuf_notes', $this->vfuf_notes, true);


        return $criteria;

    }

}
