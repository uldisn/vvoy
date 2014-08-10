<?php

class m140716_141001_alter_table_vfue extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `vfue_fuel` ADD FOREIGN KEY (`vfue_vvoy_id`) REFERENCES `vvoy_voyage`(`vvoy_id`); 
            ALTER TABLE `vfue_fuel` DROP FOREIGN KEY `vfue_fuel_ibfk_1`; 
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
