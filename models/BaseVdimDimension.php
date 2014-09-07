<?php

/**
 * This is the model base class for the table "vdim_dimension".
 *
 * Columns in table "vdim_dimension" available as properties of the model:
 * @property string $vdim_id
 * @property string $vdim_vvoy_id
 * @property string $vdim_fdm2_id
 * @property string $vdim_base_amt
 *
 * Relations of table "vdim_dimension" available as properties of the model:
 * @property VvoyVoyage $vdimVvoy
 * @property Fdm2Dimension2 $vdimFdm2
 */
abstract class BaseVdimDimension extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vdim_dimension';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vdim_vvoy_id, vdim_fdm2_id, vdim_base_amt', 'required'),
                array('vdim_vvoy_id, vdim_fdm2_id, vdim_base_amt', 'length', 'max' => 10),
                array('vdim_id, vdim_vvoy_id, vdim_fdm2_id, vdim_base_amt', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vdim_vvoy_id;
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
                'vdimVvoy' => array(self::BELONGS_TO, 'VvoyVoyage', 'vdim_vvoy_id'),
                'vdimFdm2' => array(self::BELONGS_TO, 'Fdm2Dimension2', 'vdim_fdm2_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vdim_id' => Yii::t('VvoyModule.model', 'Vdim'),
            'vdim_vvoy_id' => Yii::t('VvoyModule.model', 'Vdim Vvoy'),
            'vdim_fdm2_id' => Yii::t('VvoyModule.model', 'Vdim Fdm2'),
            'vdim_base_amt' => Yii::t('VvoyModule.model', 'Vdim Base Amt'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vdim_id', $this->vdim_id, true);
        $criteria->compare('t.vdim_vvoy_id', $this->vdim_vvoy_id);
        $criteria->compare('t.vdim_fdm2_id', $this->vdim_fdm2_id);
        $criteria->compare('t.vdim_base_amt', $this->vdim_base_amt, true);


        return $criteria;

    }

}
