<?php

/**
 * This is the model base class for the table "vexp_expenses".
 *
 * Columns in table "vexp_expenses" available as properties of the model:
 * @property string $vexp_id
 * @property integer $vexp_vepo_id
 * @property string $vexp_vvoy_id
 * @property string $vexp_fixr_id
 * @property string $vexp_notes
 *
 * Relations of table "vexp_expenses" available as properties of the model:
 * @property FixrFiitXRef $vexpFixr
 * @property VepoExpensesPositions $vexpVepo
 * @property VvoyVoyage $vexpVvoy
 */
abstract class BaseVexpExpenses extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vexp_expenses';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vexp_fixr_id', 'required'),
                array('vexp_vepo_id, vexp_vvoy_id, vexp_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vexp_vepo_id', 'numerical', 'integerOnly' => true),
                array('vexp_vvoy_id, vexp_fixr_id', 'length', 'max' => 10),
                array('vexp_notes', 'safe'),
                array('vexp_id, vexp_vepo_id, vexp_vvoy_id, vexp_fixr_id, vexp_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vexp_vvoy_id;
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
                'vexpFixr' => array(self::BELONGS_TO, 'FixrFiitXRef', 'vexp_fixr_id'),
                'vexpVepo' => array(self::BELONGS_TO, 'VepoExpensesPositions', 'vexp_vepo_id'),
                'vexpVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vexp_vvoy_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vexp_id' => Yii::t('VvoyModule.model', 'Vexp'),
            'vexp_vepo_id' => Yii::t('VvoyModule.model', 'Vexp Vepo'),
            'vexp_vvoy_id' => Yii::t('VvoyModule.model', 'Vexp Vvoy'),
            'vexp_fixr_id' => Yii::t('VvoyModule.model', 'Vexp Fixr'),
            'vexp_notes' => Yii::t('VvoyModule.model', 'Vexp Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vexp_id', $this->vexp_id, true);
        $criteria->compare('t.vexp_vepo_id', $this->vexp_vepo_id);
        $criteria->compare('t.vexp_vvoy_id', $this->vexp_vvoy_id);
        $criteria->compare('t.vexp_fixr_id', $this->vexp_fixr_id);
        $criteria->compare('t.vexp_notes', $this->vexp_notes, true);


        return $criteria;

    }

}
