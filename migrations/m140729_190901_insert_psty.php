<?php

class m140729_190901_insert_psty extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            INSERT INTO `psty_setting_type` (`psty_name`, `psty_field_type`) VALUES ('EUR/km', 'money'); 
            INSERT INTO `vepo_expenses_positions` (vepo_id,`vepo_sys_ccmp_id`, `vepo_name`) VALUES (6,'27', 'Autovadītājs EUR/km');


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
