<?php

/**
 * This is the model base class for the table "vcrt_vvoy_currency_rate".
 *
 * Columns in table "vcrt_vvoy_currency_rate" available as properties of the model:
 * @property string $vcrt_id
 * @property string $vcrt_vvoy_id
 * @property integer $vcrt_base_fcrn_id
 * @property integer $vcrt_fcrn_id
 * @property string $vcrt_date
 * @property string $vcrt_rate
 * @property string $vcrt_rate_org
 *
 * Relations of table "vcrt_vvoy_currency_rate" available as properties of the model:
 * @property FcrnCurrency $vcrtBaseFcrn
 * @property FcrnCurrency $vcrtFcrn
 * @property VvoyVoyage $vcrtVvoy
 */
abstract class BaseVcrtVvoyCurrencyRate extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vcrt_vvoy_currency_rate';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vcrt_vvoy_id, vcrt_base_fcrn_id, vcrt_fcrn_id, vcrt_date, vcrt_rate, vcrt_rate_org', 'required'),
                array('vcrt_base_fcrn_id, vcrt_fcrn_id', 'numerical', 'integerOnly' => true),
                array('vcrt_vvoy_id', 'length', 'max' => 10),
                array('vcrt_rate, vcrt_rate_org', 'length', 'max' => 12),
                array('vcrt_id, vcrt_vvoy_id, vcrt_base_fcrn_id, vcrt_fcrn_id, vcrt_date, vcrt_rate, vcrt_rate_org', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vcrt_vvoy_id;
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
                'vcrtBaseFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vcrt_base_fcrn_id'),
                'vcrtFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vcrt_fcrn_id'),
                'vcrtVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vcrt_vvoy_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vcrt_id' => Yii::t('VvoyModule.model', 'Vcrt'),
            'vcrt_vvoy_id' => Yii::t('VvoyModule.model', 'Vcrt Vvoy'),
            'vcrt_base_fcrn_id' => Yii::t('VvoyModule.model', 'Vcrt Base Fcrn'),
            'vcrt_fcrn_id' => Yii::t('VvoyModule.model', 'Vcrt Fcrn'),
            'vcrt_date' => Yii::t('VvoyModule.model', 'Vcrt Date'),
            'vcrt_rate' => Yii::t('VvoyModule.model', 'Vcrt Rate'),
            'vcrt_rate_org' => Yii::t('VvoyModule.model', 'Vcrt Rate Org'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vcrt_id', $this->vcrt_id, true);
        $criteria->compare('t.vcrt_vvoy_id', $this->vcrt_vvoy_id);
        $criteria->compare('t.vcrt_base_fcrn_id', $this->vcrt_base_fcrn_id);
        $criteria->compare('t.vcrt_fcrn_id', $this->vcrt_fcrn_id);
        $criteria->compare('t.vcrt_date', $this->vcrt_date, true);
        $criteria->compare('t.vcrt_rate', $this->vcrt_rate, true);
        $criteria->compare('t.vcrt_rate_org', $this->vcrt_rate_org, true);


        return $criteria;

    }

}
