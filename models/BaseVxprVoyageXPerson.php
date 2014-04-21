<?php

/**
 * This is the model base class for the table "vxpr_voyage_x_person".
 *
 * Columns in table "vxpr_voyage_x_person" available as properties of the model:
 * @property string $vxpr_id
 * @property integer $vxpr_pprs_id
 * @property string $vxpr_vvoy_id
 * @property string $vxpr_notes
 *
 * Relations of table "vxpr_voyage_x_person" available as properties of the model:
 * @property PprsPerson $vxprPprs
 * @property VvoyVoyage $vxprVvoy
 */
abstract class BaseVxprVoyageXPerson extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vxpr_voyage_x_person';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vxpr_pprs_id, vxpr_vvoy_id, vxpr_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vxpr_pprs_id', 'numerical', 'integerOnly' => true),
                array('vxpr_vvoy_id', 'length', 'max' => 10),
                array('vxpr_notes', 'safe'),
                array('vxpr_id, vxpr_pprs_id, vxpr_vvoy_id, vxpr_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vxpr_vvoy_id;
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
                'vxprPprs' => array(self::BELONGS_TO, 'PprsPerson', 'vxpr_pprs_id'),
                'vxprVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vxpr_vvoy_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vxpr_id' => Yii::t('VvoyModule.model', 'Vxpr'),
            'vxpr_pprs_id' => Yii::t('VvoyModule.model', 'Vxpr Pprs'),
            'vxpr_vvoy_id' => Yii::t('VvoyModule.model', 'Vxpr Vvoy'),
            'vxpr_notes' => Yii::t('VvoyModule.model', 'Vxpr Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vxpr_id', $this->vxpr_id, true);
        $criteria->compare('t.vxpr_pprs_id', $this->vxpr_pprs_id);
        $criteria->compare('t.vxpr_vvoy_id', $this->vxpr_vvoy_id);
        $criteria->compare('t.vxpr_notes', $this->vxpr_notes, true);


        return $criteria;

    }

}
