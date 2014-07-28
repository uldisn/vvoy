<?php

class m140725_200201_alter_table_vfue extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
        ALTER TABLE `vvoy_voyage`   
            ADD COLUMN `vvoy_fuel_tank_start` SMALLINT UNSIGNED NULL  COMMENT 'fuel in tank at start voyage' AFTER `vvoy_notes`,
            ADD COLUMN `vvoy_fuel_tank_end` SMALLINT UNSIGNED NULL  COMMENT 'fuel in tank at end voyage' AFTER `vvoy_fuel_tank_start`,
            ADD COLUMN `vvoy_fuel_tank_start_amt` DECIMAL(10,2) NULL AFTER `vvoy_fuel_tank_end`,
            ADD COLUMN `vvoy_fuel_tank_end_amt` DECIMAL(10,2) NULL AFTER `vvoy_fuel_tank_start_amt`,   
            ADD COLUMN `vvoy_odo_start` INT NULL AFTER `vvoy_fuel_tank_end_amt`,
            ADD COLUMN `vvoy_odo_end` INT NULL AFTER `vvoy_odo_start`,
            ADD COLUMN `vvoy_fuel` SMALLINT UNSIGNED NULL AFTER `vvoy_fuel_tank_end_amt`,
            ADD COLUMN `vvoy_fuel_amt` DECIMAL(10,2) NULL AFTER `vvoy_fuel`,            
            ADD COLUMN `vvoy_abs_odo_start` INT NULL AFTER `vvoy_fuel_amt`,
            ADD COLUMN `vvoy_abs_odo_end` INT NULL AFTER `vvoy_abs_odo_start`,
            ADD COLUMN `vvoy_mileage` SMALLINT NULL AFTER `vvoy_abs_odo_end`;
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
