<?php

/**
 * This is the model base class for the table "vvcl_voyage_client".
 *
 * Columns in table "vvcl_voyage_client" available as properties of the model:
 * @property string $vvcl_id
 * @property string $vvcl_vvoy_id
 * @property string $vvcl_ccmp_id
 * @property integer $vvcl_vcnt_id
 * @property string $vvcl_notes
 * @property string $vvcl_plan_freight
 * @property string $vvcl_freight
 * @property integer $vvcl_plan_fcrn_id
 * @property integer $vvcl_fcrn_id
 * @property string $vvcl_plan_base_amt
 * @property string $vvcl_base_amt
 *
 * Relations of table "vvcl_voyage_client" available as properties of the model:
 * @property FcrnCurrency $vvclPlanFcrn
 * @property VvoyVoyage $vvclVvoy
 * @property CcmpCompany $vvclCcmp
 * @property VcntContract $vvclVcnt
 */
abstract class BaseVvclVoyageClient extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vvcl_voyage_client';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vvcl_vvoy_id', 'required'),
                array('vvcl_ccmp_id, vvcl_vcnt_id, vvcl_notes, vvcl_plan_freight, vvcl_freight, vvcl_plan_fcrn_id, vvcl_fcrn_id, vvcl_plan_base_amt, vvcl_base_amt', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vvcl_vcnt_id, vvcl_plan_fcrn_id, vvcl_fcrn_id', 'numerical', 'integerOnly' => true),
                array('vvcl_vvoy_id, vvcl_ccmp_id', 'length', 'max' => 10),
                array('vvcl_plan_freight, vvcl_freight, vvcl_plan_base_amt, vvcl_base_amt', 'length', 'max' => 8),
                array('vvcl_notes', 'safe'),
                array('vvcl_id, vvcl_vvoy_id, vvcl_ccmp_id, vvcl_vcnt_id, vvcl_notes, vvcl_plan_freight, vvcl_freight, vvcl_plan_fcrn_id, vvcl_fcrn_id, vvcl_plan_base_amt, vvcl_base_amt', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vvcl_vvoy_id;
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
                'vvclPlanFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vvcl_plan_fcrn_id'),
                'vvclVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vvcl_vvoy_id'),
                'vvclCcmp' => array(self::BELONGS_TO, 'CcmpCompany', 'vvcl_ccmp_id'),
                'vvclVcnt' => array(self::BELONGS_TO, 'VcntContract', 'vvcl_vcnt_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vvcl_id' => Yii::t('VvoyModule.model', 'Vvcl'),
            'vvcl_vvoy_id' => Yii::t('VvoyModule.model', 'Vvcl Vvoy'),
            'vvcl_ccmp_id' => Yii::t('VvoyModule.model', 'Vvcl Ccmp'),
            'vvcl_vcnt_id' => Yii::t('VvoyModule.model', 'Vvcl Vcnt'),
            'vvcl_notes' => Yii::t('VvoyModule.model', 'Vvcl Notes'),
            'vvcl_plan_freight' => Yii::t('VvoyModule.model', 'Vvcl Plan Freight'),
            'vvcl_freight' => Yii::t('VvoyModule.model', 'Vvcl Freight'),
            'vvcl_plan_fcrn_id' => Yii::t('VvoyModule.model', 'Vvcl Plan Fcrn'),
            'vvcl_fcrn_id' => Yii::t('VvoyModule.model', 'Vvcl Fcrn'),
            'vvcl_plan_base_amt' => Yii::t('VvoyModule.model', 'Vvcl Plan Base Amt'),
            'vvcl_base_amt' => Yii::t('VvoyModule.model', 'Vvcl Base Amt'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vvcl_id', $this->vvcl_id, true);
        $criteria->compare('t.vvcl_vvoy_id', $this->vvcl_vvoy_id);
        $criteria->compare('t.vvcl_ccmp_id', $this->vvcl_ccmp_id);
        $criteria->compare('t.vvcl_vcnt_id', $this->vvcl_vcnt_id);
        $criteria->compare('t.vvcl_notes', $this->vvcl_notes, true);
        $criteria->compare('t.vvcl_plan_freight', $this->vvcl_plan_freight, true);
        $criteria->compare('t.vvcl_freight', $this->vvcl_freight, true);
        $criteria->compare('t.vvcl_plan_fcrn_id', $this->vvcl_plan_fcrn_id);
        $criteria->compare('t.vvcl_fcrn_id', $this->vvcl_fcrn_id);
        $criteria->compare('t.vvcl_plan_base_amt', $this->vvcl_plan_base_amt, true);
        $criteria->compare('t.vvcl_base_amt', $this->vvcl_base_amt, true);


        return $criteria;

    }

}
