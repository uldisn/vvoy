<?php

class m141119_133314_vvoy_alter extends EDbMigration
{
	public function up()
	{
		$this->execute("
            ALTER TABLE `vvoy_voyage`   
              CHANGE `vvoy_fcrn_plan_date` `vvoy_fcrn_plan_date` DATE NOT NULL;

        ");        
	}

	public function down()
	{
		echo "m141119_133314_vvoy_alter does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}