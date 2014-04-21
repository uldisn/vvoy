<?php

/**
 * This is the model base class for the table "vvex_voyage_expenses".
 *
 * Columns in table "vvex_voyage_expenses" available as properties of the model:
 * @property string $vvex_id
 * @property string $vvex_vvoy_id
 * @property string $vvex_vepp_id
 * @property integer $vvex_vepo_id
 * @property integer $vvex_cunt_id
 * @property string $vvex_count
 * @property string $vvex_price
 * @property integer $vvex_fcrn_id
 * @property string $vvex_total
 * @property integer $vvex_base_fcrn_id
 * @property string $vvex_base_total
 * @property string $vvex_notes
 *
 * Relations of table "vvex_voyage_expenses" available as properties of the model:
 * @property VepoExpensesPositions $vvexVepo
 * @property VvoyVoyage $vvexVvoy
 * @property VvepVoyageExpensesPlan $vvexVepp
 * @property FcrnCurrency $vvexFcrn
 * @property FcrnCurrency $vvexBaseFcrn
 */
abstract class BaseVvexVoyageExpenses extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vvex_voyage_expenses';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vvex_vvoy_id, vvex_cunt_id, vvex_count, vvex_price, vvex_fcrn_id, vvex_base_fcrn_id', 'required'),
                array('vvex_vepp_id, vvex_vepo_id, vvex_total, vvex_base_total, vvex_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vvex_vepo_id, vvex_cunt_id, vvex_fcrn_id, vvex_base_fcrn_id', 'numerical', 'integerOnly' => true),
                array('vvex_vvoy_id, vvex_count, vvex_price, vvex_total, vvex_base_total', 'length', 'max' => 10),
                array('vvex_vepp_id', 'length', 'max' => 5),
                array('vvex_notes', 'safe'),
                array('vvex_id, vvex_vvoy_id, vvex_vepp_id, vvex_vepo_id, vvex_cunt_id, vvex_count, vvex_price, vvex_fcrn_id, vvex_total, vvex_base_fcrn_id, vvex_base_total, vvex_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vvex_vvoy_id;
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
                'vvexVepo' => array(self::BELONGS_TO, 'VepoExpensesPositions', 'vvex_vepo_id'),
                'vvexVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vvex_vvoy_id'),
                'vvexVepp' => array(self::BELONGS_TO, 'VvepVoyageExpensesPlan', 'vvex_vepp_id'),
                'vvexFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vvex_fcrn_id'),
                'vvexBaseFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'vvex_base_fcrn_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vvex_id' => Yii::t('VvoyModule.model', 'Vvex'),
            'vvex_vvoy_id' => Yii::t('VvoyModule.model', 'Vvex Vvoy'),
            'vvex_vepp_id' => Yii::t('VvoyModule.model', 'Vvex Vepp'),
            'vvex_vepo_id' => Yii::t('VvoyModule.model', 'Vvex Vepo'),
            'vvex_cunt_id' => Yii::t('VvoyModule.model', 'Vvex Cunt'),
            'vvex_count' => Yii::t('VvoyModule.model', 'Vvex Count'),
            'vvex_price' => Yii::t('VvoyModule.model', 'Vvex Price'),
            'vvex_fcrn_id' => Yii::t('VvoyModule.model', 'Vvex Fcrn'),
            'vvex_total' => Yii::t('VvoyModule.model', 'Vvex Total'),
            'vvex_base_fcrn_id' => Yii::t('VvoyModule.model', 'Vvex Base Fcrn'),
            'vvex_base_total' => Yii::t('VvoyModule.model', 'Vvex Base Total'),
            'vvex_notes' => Yii::t('VvoyModule.model', 'Vvex Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vvex_id', $this->vvex_id, true);
        $criteria->compare('t.vvex_vvoy_id', $this->vvex_vvoy_id);
        $criteria->compare('t.vvex_vepp_id', $this->vvex_vepp_id);
        $criteria->compare('t.vvex_vepo_id', $this->vvex_vepo_id);
        $criteria->compare('t.vvex_cunt_id', $this->vvex_cunt_id);
        $criteria->compare('t.vvex_count', $this->vvex_count, true);
        $criteria->compare('t.vvex_price', $this->vvex_price, true);
        $criteria->compare('t.vvex_fcrn_id', $this->vvex_fcrn_id);
        $criteria->compare('t.vvex_total', $this->vvex_total, true);
        $criteria->compare('t.vvex_base_fcrn_id', $this->vvex_base_fcrn_id);
        $criteria->compare('t.vvex_base_total', $this->vvex_base_total, true);
        $criteria->compare('t.vvex_notes', $this->vvex_notes, true);


        return $criteria;

    }

}
