<?php

/**
 * This is the model base class for the table "vepo_expenses_positions".
 *
 * Columns in table "vepo_expenses_positions" available as properties of the model:
 * @property integer $vepo_id
 * @property string $vepo_name
 *
 * Relations of table "vepo_expenses_positions" available as properties of the model:
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
                array('vepo_name', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vepo_name', 'length', 'max' => 50),
                array('vepo_id, vepo_name', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vepo_name;
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
                'vvepVoyageExpensesPlans' => array(self::HAS_MANY, 'VvepVoyageExpensesPlan', 'vvep_vepo_id'),
                'vvexVoyageExpenses' => array(self::HAS_MANY, 'VvexVoyageExpenses', 'vvex_vepo_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vepo_id' => Yii::t('VvoyModule.model', 'Vepo'),
            'vepo_name' => Yii::t('VvoyModule.model', 'Vepo Name'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vepo_id', $this->vepo_id);
        $criteria->compare('t.vepo_name', $this->vepo_name, true);


        return $criteria;

    }

}
