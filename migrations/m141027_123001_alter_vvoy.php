<?php

class m141027_123001_alter_vvoy extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `vvoy_voyage`   
              ADD COLUMN `vvoy_vodo_id` INT UNSIGNED NULL  COMMENT 'Odometer readings' AFTER `vvoy_mileage`;
            ALTER TABLE `vvoy_voyage`   
              ADD FOREIGN KEY (`vvoy_vodo_id`) REFERENCES `vodo_odometer`(`vodo_id`);

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
