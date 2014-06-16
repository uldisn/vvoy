<?php

class m140616_132001_crete_table_vfuel extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            CREATE TABLE `vfue_fuel` (
  `vfue_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vfue_vvoy_id` int(10) unsigned NOT NULL,
  `vfue_ccnt_id` smallint(5) unsigned DEFAULT NULL,
  `vfue_company` varchar(200) DEFAULT NULL,
  `vfue_comapny_reg_number` varchar(30) DEFAULT NULL,
  `vfue_series` varchar(10) DEFAULT NULL,
  `vfue_number` varchar(100) DEFAULT NULL,
  `vfue_date` date DEFAULT NULL,
  `vfue_fcrn_id` tinyint(3) unsigned DEFAULT NULL,
  `vfue_amt` decimal(10,2) unsigned DEFAULT NULL,
  `vfue_fuel_type` varchar(10) DEFAULT NULL,
  `vfue_qnt` decimal(10,2) DEFAULT NULL,
  `vfue_fvat_id` tinyint(3) unsigned DEFAULT NULL,
  `vfue_vat` decimal(10,2) unsigned DEFAULT NULL,
  `vfue_total` decimal(10,2) unsigned DEFAULT NULL,
  `vfue_base_fcrn_id` tinyint(3) unsigned DEFAULT NULL,
  `vfue_base_amt` decimal(10,2) unsigned DEFAULT NULL,
  `vfue_vase_vat` decimal(10,2) unsigned DEFAULT NULL,
  `vfue_base_total` decimal(10,2) unsigned DEFAULT NULL,
  `vfue_notes` text,
  PRIMARY KEY (`vfue_id`),
  KEY `vfue_vvoy_id` (`vfue_vvoy_id`),
  KEY `vfue_ccnt_id` (`vfue_ccnt_id`),
  KEY `vfue_fcrn_id` (`vfue_fcrn_id`),
  KEY `vfue_base_fcrn_id` (`vfue_base_fcrn_id`),
  CONSTRAINT `vfue_fuel_ibfk_1` FOREIGN KEY (`vfue_vvoy_id`) REFERENCES `vvex_voyage_expenses` (`vvex_id`),
  CONSTRAINT `vfue_fuel_ibfk_2` FOREIGN KEY (`vfue_ccnt_id`) REFERENCES `ccnt_country` (`ccnt_id`),
  CONSTRAINT `vfue_fuel_ibfk_3` FOREIGN KEY (`vfue_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`),
  CONSTRAINT `vfue_fuel_ibfk_4` FOREIGN KEY (`vfue_base_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ");
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
		$this->execute("
            TRUNCATE TABLE `vfue_fuel`;
        ");
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
