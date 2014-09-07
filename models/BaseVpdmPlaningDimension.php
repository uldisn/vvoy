<?php

/**
 * This is the model base class for the table "vpdm_planing_dimension".
 *
 * Columns in table "vpdm_planing_dimension" available as properties of the model:
 * @property string $vpdm_id
 * @property string $vpdm_vvoy_id
 * @property string $vpdm_fdm2_id
 * @property string $vpdm_base_amt
 *
 * Relations of table "vpdm_planing_dimension" available as properties of the model:
 * @property VvoyVoyage $vpdmVvoy
 * @property Fdm2Dimension2 $vpdmFdm2
 */
abstract class BaseVpdmPlaningDimension extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vpdm_planing_dimension';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vpdm_vvoy_id, vpdm_fdm2_id, vpdm_base_amt', 'required'),
                array('vpdm_vvoy_id, vpdm_fdm2_id, vpdm_base_amt', 'length', 'max' => 10),
                array('vpdm_id, vpdm_vvoy_id, vpdm_fdm2_id, vpdm_base_amt', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vpdm_vvoy_id;
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
                'vpdmVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vpdm_vvoy_id'),
                'vpdmFdm2' => array(self::BELONGS_TO, 'Fdm2Dimension2', 'vpdm_fdm2_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vpdm_id' => Yii::t('VvoyModule.model', 'Vpdm'),
            'vpdm_vvoy_id' => Yii::t('VvoyModule.model', 'Vpdm Vvoy'),
            'vpdm_fdm2_id' => Yii::t('VvoyModule.model', 'Vpdm Fdm2'),
            'vpdm_base_amt' => Yii::t('VvoyModule.model', 'Vpdm Base Amt'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vpdm_id', $this->vpdm_id, true);
        $criteria->compare('t.vpdm_vvoy_id', $this->vpdm_vvoy_id);
        $criteria->compare('t.vpdm_fdm2_id', $this->vpdm_fdm2_id);
        $criteria->compare('t.vpdm_base_amt', $this->vpdm_base_amt, true);


        return $criteria;

    }

}
