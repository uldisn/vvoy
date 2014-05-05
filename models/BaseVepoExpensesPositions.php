<?php

/**
 * This is the model base class for the table "vepo_expenses_positions".
 *
 * Columns in table "vepo_expenses_positions" available as properties of the model:
 * @property integer $vepo_id
 * @property string $vepo_sys_ccmp_id
 * @property string $vepo_name
 * @property integer $vepo_default
 *
 * Relations of table "vepo_expenses_positions" available as properties of the model:
 * @property CcmpCompany $vepoSysCcmp
 * @property VvepVoyageExpensesPlan[] $vvepVoyageExpensesPlans
 * @property VvexVoyageExpenses[] $vvexVoyageExpenses
 */
abstract class BaseVepoExpensesPositions extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vepo_expenses_positions';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vepo_sys_ccmp_id', 'required'),
                array('vepo_name, vepo_default', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vepo_default', 'numerical', 'integerOnly' => true),
                array('vepo_sys_ccmp_id', 'length', 'max' => 10),
                array('vepo_name', 'length', 'max' => 50),
                array('vepo_id, vepo_sys_ccmp_id, vepo_name, vepo_default', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vepo_sys_ccmp_id;
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
                'vepoSysCcmp' => array(self::BELONGS_TO, 'CcmpCompany', 'vepo_sys_ccmp_id'),
                'vvepVoyageExpensesPlans' => array(self::HAS_MANY, 'VvepVoyageExpensesPlan', 'vvep_vepo_id'),
                'vvexVoyageExpenses' => array(self::HAS_MANY, 'VvexVoyageExpenses', 'vvex_vepo_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vepo_id' => Yii::t('VvoyModule.model', 'Vepo'),
            'vepo_sys_ccmp_id' => Yii::t('VvoyModule.model', 'Vepo Sys Ccmp'),
            'vepo_name' => Yii::t('VvoyModule.model', 'Vepo Name'),
            'vepo_default' => Yii::t('VvoyModule.model', 'Vepo Default'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vepo_id', $this->vepo_id);
        $criteria->compare('t.vepo_sys_ccmp_id', $this->vepo_sys_ccmp_id);
        $criteria->compare('t.vepo_name', $this->vepo_name, true);
        $criteria->compare('t.vepo_default', $this->vepo_default);


        return $criteria;

    }

}
