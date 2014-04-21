<?php

/**
 * This is the model base class for the table "vpnt_point".
 *
 * Columns in table "vpnt_point" available as properties of the model:
 * @property integer $vpnt_id
 * @property integer $vpnt_ccnt_id
 * @property string $vpnt_name
 *
 * Relations of table "vpnt_point" available as properties of the model:
 * @property CcntCountry $vpntCcnt
 * @property VvpoVoyagePoint[] $vvpoVoyagePoints
 */
abstract class BaseVpntPoint extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vpnt_point';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vpnt_ccnt_id', 'required'),
                array('vpnt_name', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vpnt_ccnt_id', 'numerical', 'integerOnly' => true),
                array('vpnt_name', 'length', 'max' => 100),
                array('vpnt_id, vpnt_ccnt_id, vpnt_name', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vpnt_name;
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
                'vpntCcnt' => array(self::BELONGS_TO, 'CcntCountry', 'vpnt_ccnt_id'),
                'vvpoVoyagePoints' => array(self::HAS_MANY, 'VvpoVoyagePoint', 'vvpo_vpnt_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vpnt_id' => Yii::t('VvoyModule.model', 'Vpnt'),
            'vpnt_ccnt_id' => Yii::t('VvoyModule.model', 'Vpnt Ccnt'),
            'vpnt_name' => Yii::t('VvoyModule.model', 'Vpnt Name'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vpnt_id', $this->vpnt_id);
        $criteria->compare('t.vpnt_ccnt_id', $this->vpnt_ccnt_id);
        $criteria->compare('t.vpnt_name', $this->vpnt_name, true);


        return $criteria;

    }

}
