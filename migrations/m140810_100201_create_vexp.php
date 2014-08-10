<?php

class m140810_100201_create_vexp extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            CREATE TABLE `vexp_expenses` (
              `vexp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `vexp_vepo_id` smallint(3) unsigned DEFAULT NULL,
              `vexp_vvoy_id` int(10) unsigned DEFAULT NULL,
              `vexp_fixr_id` int(10) unsigned NOT NULL,
              `vexp_notes` text,
              PRIMARY KEY (`vexp_id`),
              KEY `vexp_vepo_id` (`vexp_vepo_id`),
              KEY `vexp_vvoy_id` (`vexp_vvoy_id`),
              CONSTRAINT `vexp_expenses_ibfk_2` FOREIGN KEY (`vexp_vvoy_id`) REFERENCES `vvoy_voyage` (`vvoy_id`),
              CONSTRAINT `vexp_expenses_ibfk_1` FOREIGN KEY (`vexp_vepo_id`) REFERENCES `vepo_expenses_positions` (`vepo_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8


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
