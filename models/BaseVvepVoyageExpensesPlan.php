<?php

/**
 * This is the model base class for the table "vvep_voyage_expenses_plan".
 *
 * Columns in table "vvep_voyage_expenses_plan" available as properties of the model:
 * @property string $vvep_id
 * @property string $vvep_vvoy_id
 * @property integer $vvep_vepo_id
 * @property string $vvep_count_id
 * @property string $vvep_count
 * @property string $vvep_price
 * @property integer $vvep_fcrn_id
 * @property string $vvep_total
 * @property integer $vvep_base_fcrn_id
 * @property string $vvep_base_total
 * @property string $vvep_notes
 *
 * Relations of table "vvep_voyage_expenses_plan" available as properties of the model:
 * @property VvoyVoyage $vvepVvoy
 * @property FcrnCurrency $vvepFcrn
 * @property FcrnCurrency $vvepBaseFcrn
 * @property VepoExpensesPositions $vvepVepo
 * @property VvexVoyageExpenses[] $vvexVoyageExpenses
 */
abstract class BaseVvepVoyageExpensesPlan extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vvep_voyage_expenses_plan';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vvep_vvoy_id', 'required'),
                array('vvep_vepo_id, vvep_count_id, vvep_count, vvep_price, vvep_fcrn_id, vvep_total, vvep_base_fcrn_id, vvep_base_total, vvep_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vvep_vepo_id, vvep_fcrn_id, vvep_base_fcrn_id', 'numerical', 'integerOnly' => true),
                array('vvep_vvoy_id, vvep_count, vvep_price, vvep_total, vvep_base_total', 'length', 'max' => 10),
                array('vvep_count_id', 'length', 'max' => 3),
                array('vvep_notes', 'safe'),
                array('vvep_id, vvep_vvoy_id, vvep_vepo_id, vvep_count_id, vvep_count, vvep_price, vvep_fcrn_id, vvep_total, vvep_base_fcrn_id, vvep_base_total, vvep_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vvep_vvoy_id;
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
                'vvepVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vvep_vvoy_id'),
                'vvepFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vvep_fcrn_id'),
                'vvepBaseFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vvep_base_fcrn_id'),
                'vvepVepo' => array(self::BELONGS_TO, 'VepoExpensesPositions', 'vvep_vepo_id'),
                'vvexVoyageExpenses' => array(self::HAS_MANY, 'VvexVoyageExpenses', 'vvex_vepp_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vvep_id' => Yii::t('VvoyModule.model', 'Vvep'),
            'vvep_vvoy_id' => Yii::t('VvoyModule.model', 'Vvep Vvoy'),
            'vvep_vepo_id' => Yii::t('VvoyModule.model', 'Vvep Vepo'),
            'vvep_count_id' => Yii::t('VvoyModule.model', 'Vvep Count'),
            'vvep_count' => Yii::t('VvoyModule.model', 'Vvep Count'),
            'vvep_price' => Yii::t('VvoyModule.model', 'Vvep Price'),
            'vvep_fcrn_id' => Yii::t('VvoyModule.model', 'Vvep Fcrn'),
            'vvep_total' => Yii::t('VvoyModule.model', 'Vvep Total'),
            'vvep_base_fcrn_id' => Yii::t('VvoyModule.model', 'Vvep Base Fcrn'),
            'vvep_base_total' => Yii::t('VvoyModule.model', 'Vvep Base Total'),
            'vvep_notes' => Yii::t('VvoyModule.model', 'Vvep Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vvep_id', $this->vvep_id, true);
        $criteria->compare('t.vvep_vvoy_id', $this->vvep_vvoy_id);
        $criteria->compare('t.vvep_vepo_id', $this->vvep_vepo_id);
        $criteria->compare('t.vvep_count_id', $this->vvep_count_id, true);
        $criteria->compare('t.vvep_count', $this->vvep_count, true);
        $criteria->compare('t.vvep_price', $this->vvep_price, true);
        $criteria->compare('t.vvep_fcrn_id', $this->vvep_fcrn_id);
        $criteria->compare('t.vvep_total', $this->vvep_total, true);
        $criteria->compare('t.vvep_base_fcrn_id', $this->vvep_base_fcrn_id);
        $criteria->compare('t.vvep_base_total', $this->vvep_base_total, true);
        $criteria->compare('t.vvep_notes', $this->vvep_notes, true);


        return $criteria;

    }

}
