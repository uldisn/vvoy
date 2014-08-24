<?php

class m140822_094101_create_vfuf extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            CREATE TABLE `vfuf_fuel_finv` (
              `vfuf_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `vfuf_vvoy_id` INT(10) UNSIGNED DEFAULT NULL,
              `vfuf_fixr_id` INT(10) UNSIGNED NOT NULL,
              `vfuf_qnt` DECIMAL(10,2) UNSIGNED NOT NULL,  
              `vfuf_date` DATE NULL,
              `vfuf_base_amt` DECIMAL(10,2) UNSIGNED DEFAULT NULL,
              `vfuf_notes` TEXT,
              PRIMARY KEY (`vfuf_id`),
              KEY `vfuf_vvoy_id` (`vfuf_vvoy_id`),
              KEY `vfuf_fixr_id` (`vfuf_fixr_id`),
              CONSTRAINT `vfuf_fuel_finv_ibfk_1` FOREIGN KEY (`vfuf_vvoy_id`) REFERENCES `vvoy_voyage` (`vvoy_id`),
              CONSTRAINT `vfuf_fuel_finv_ibfk_2` FOREIGN KEY (`vfuf_fixr_id`) REFERENCES `fixr_fiit_x_ref` (`fixr_id`)
            ) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8




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
