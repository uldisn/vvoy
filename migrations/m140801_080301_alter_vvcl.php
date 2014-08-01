<?php

class m140801_080301_alter_vvcl extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `vvcl_voyage_client`   
              CHANGE `vvcl_freight` `vvcl_freight` DECIMAL(8,2) UNSIGNED NULL,
              ADD COLUMN `vvcl_plan_freight` DECIMAL(8,2) UNSIGNED NULL AFTER `vvcl_notes`,
              ADD COLUMN `vvcl_plan_fcrn_id` TINYINT UNSIGNED NULL AFTER `vvcl_freight`,
              ADD COLUMN `vvcl_plan_base_amt` DECIMAL(8,2) UNSIGNED NULL AFTER `vvcl_fcrn_id`;

            ALTER TABLE `vvcl_voyage_client` 
                ADD FOREIGN KEY (`vvcl_plan_fcrn_id`) REFERENCES `eu`.`fcrn_currency`(`fcrn_id`); 

        ");
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
	
	}

	/**
	 * Creates initial version of the table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drops the table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
