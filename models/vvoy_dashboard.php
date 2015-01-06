<?php
/**
 * model for voyage dashboard validation
 */
class vvoy_dashboard extends CModel {

    public $year;
    public $week;


    public function rules() {
        return array(
            array('year,week', 'default', 'setOnEmpty' => true, 'value' => null),
            array('year,week', 'numerical', 'integerOnly' => true),
           
        );
    }

    public function attributeNames(){
        return array(
            'year',
            'week',
            );
    }
    
}
