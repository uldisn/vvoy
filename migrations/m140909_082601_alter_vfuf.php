<?php

class m140909_082601_alter_vfuf extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `vfuf_fuel_finv` ADD FOREIGN KEY (`vfuf_fixr_id`) REFERENCES `eu`.`fixr_fiit_x_ref`(`fixr_id`); 
            ALTER TABLE `vdim_dimension`   
              ADD COLUMN `vdim_fdm3_id` INT UNSIGNED NULL AFTER `vdim_fdm2_id`,
              ADD FOREIGN KEY (`vdim_fdm3_id`) REFERENCES `fdm3_dimension3`(`fdm3_id`);
            ALTER TABLE `vpdm_planing_dimension`   
              ADD COLUMN `vpdm_fdm3_id` INT UNSIGNED NULL AFTER `vpdm_fdm2_id`,
              ADD FOREIGN KEY (`vpdm_fdm3_id`) REFERENCES `fdm3_dimension3`(`fdm3_id`);

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
