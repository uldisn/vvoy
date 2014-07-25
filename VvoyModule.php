<?php

class VvoyModule extends CWebModule
{
    
    /**
     * tabulas ptyp_type id - autovadītājs
     * @var int 
     */
    public $driver_person_type = 1;

    /**
     * tabulas pdcm_document_type id, kas ir norēķina dokumenti
     * @var array
     */
    public $driver_payment_docs = array();
    
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'vvoy.models.*',
			'vvoy.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
