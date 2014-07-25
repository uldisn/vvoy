<?php

class m140725_180201_alter_table_vfue extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `vfue_fuel`   
                ADD COLUMN `vfue_ppxd_id` INT UNSIGNED NULL  COMMENT 'Payment card, advance' AFTER `vfue_amt`,
                ADD FOREIGN KEY (`vfue_ppxd_id`) REFERENCES `eu`.`ppxd_person_x_document`(`ppxd_id`);
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
