<?php

use Illuminate\Database\Migrations\Migration;

class TableTransactions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $sql = "USE `mlm`;
                ALTER TABLE `users`
                DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

                ALTER TABLE `profiles`
                DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

                ALTER TABLE `downlines`
                DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

                ALTER TABLE `customers`
                DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

                ALTER TABLE `admins`
                DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

                CREATE TABLE `transactions` (
                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                  `requestor_id` int(10) unsigned NOT NULL,
                  `processor_id` int(10) unsigned DEFAULT NULL,
                  `amount` int(11) NOT NULL,
                  `status` enum('new','processed','approved','rejected') NOT NULL,
                  `comment` tinytext NULL,
                  `created` datetime NOT NULL,
                  `processed` datetime NULL,
                  PRIMARY KEY (`id`),
                  KEY `requestor_id` (`requestor_id`),
                  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`requestor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;";


        DB::unprepared( $sql );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        $sql = "USE `mlm`;
                DROP table transactions";
        DB::unprepared( $sql );
	}

}
