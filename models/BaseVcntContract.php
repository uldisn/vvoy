<?php

/**
 * This is the model base class for the table "vcnt_contract".
 *
 * Columns in table "vcnt_contract" available as properties of the model:
 * @property integer $vcnt_id
 * @property string $vcnt_sys_ccmp_id
 * @property string $vcnt_client_ccmp_id
 * @property string $vcnt_date_from
 * @property string $vcnt_date_to
 * @property string $vcnt_status
 * @property string $vcnt_notes
 *
 * Relations of table "vcnt_contract" available as properties of the model:
 * @property CcmpCompany $vcntSysCcmp
 * @property CcmpCompany $vcntClientCcmp
 * @property VvclVoyageClient[] $vvclVoyageClients
 */
abstract class BaseVcntContract extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const VCNT_STATUS_OLD = 'Old';
    const VCNT_STATUS_ACTUAL = 'Actual';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'vcnt_contract';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('vcnt_sys_ccmp_id, vcnt_client_ccmp_id, vcnt_status', 'required'),
                array('vcnt_date_from, vcnt_date_to, vcnt_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('vcnt_sys_ccmp_id, vcnt_client_ccmp_id', 'length', 'max' => 10),
                array('vcnt_status', 'length', 'max' => 6),
                array('vcnt_date_from, vcnt_date_to, vcnt_notes', 'safe'),
                array('vcnt_id, vcnt_sys_ccmp_id, vcnt_client_ccmp_id, vcnt_date_from, vcnt_date_to, vcnt_status, vcnt_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->vcnt_sys_ccmp_id;
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
                'vcntSysCcmp' => array(self::BELONGS_TO, 'CcmpCompany', 'vcnt_sys_ccmp_id'),
                'vcntClientCcmp' => array(self::BELONGS_TO, 'CcmpCompany', 'vcnt_client_ccmp_id'),
                'vvclVoyageClients' => array(self::HAS_MANY, 'VvclVoyageClient', 'vvcl_vcnt_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'vcnt_id' => Yii::t('VvoyModule.model', 'Vcnt'),
            'vcnt_sys_ccmp_id' => Yii::t('VvoyModule.model', 'Vcnt Sys Ccmp'),
            'vcnt_client_ccmp_id' => Yii::t('VvoyModule.model', 'Vcnt Client Ccmp'),
            'vcnt_date_from' => Yii::t('VvoyModule.model', 'Vcnt Date From'),
            'vcnt_date_to' => Yii::t('VvoyModule.model', 'Vcnt Date To'),
            'vcnt_status' => Yii::t('VvoyModule.model', 'Vcnt Status'),
            'vcnt_notes' => Yii::t('VvoyModule.model', 'Vcnt Notes'),
        );
    }

    public function enumLabels()
    {
        return array(
           'vcnt_status' => array(
               self::VCNT_STATUS_OLD => Yii::t('VvoyModule.model', 'VCNT_STATUS_OLD'),
               self::VCNT_STATUS_ACTUAL => Yii::t('VvoyModule.model', 'VCNT_STATUS_ACTUAL'),
           ),
            );
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }


    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.vcnt_id', $this->vcnt_id);
        $criteria->compare('t.vcnt_sys_ccmp_id', $this->vcnt_sys_ccmp_id);
        $criteria->compare('t.vcnt_client_ccmp_id', $this->vcnt_client_ccmp_id);
        $criteria->compare('t.vcnt_date_from', $this->vcnt_date_from, true);
        $criteria->compare('t.vcnt_date_to', $this->vcnt_date_to, true);
        $criteria->compare('t.vcnt_status', $this->vcnt_status, true);
        $criteria->compare('t.vcnt_notes', $this->vcnt_notes, true);


        return $criteria;

    }

}
