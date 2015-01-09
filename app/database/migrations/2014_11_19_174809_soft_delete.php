<?php

use Illuminate\Database\Migrations\Migration;

class SoftDelete extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $sql = "USE `mlm`;
                ALTER TABLE `admins`
                ADD COLUMN `deleted`  datetime NULL AFTER `admin_id`;

                ALTER TABLE `customers`
                ADD COLUMN `deleted`  datetime NULL AFTER `point`;

                ALTER TABLE `downlines`
                ADD COLUMN `deleted`  datetime NULL AFTER `downline_user_id`;

                ALTER TABLE `profiles`
                ADD COLUMN `deleted`  datetime NULL AFTER `created_date`;

                ALTER TABLE `transactions`
                ADD COLUMN `deleted`  datetime NULL AFTER `processed`;

                ALTER TABLE `users`
                ADD COLUMN `deleted`  datetime NULL AFTER `remember_token`;

                ALTER TABLE `transactions` DROP FOREIGN KEY `transactions_ibfk_1`;
                ALTER TABLE `transactions` ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`requestor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;;";

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
                ALTER TABLE `admins`
                DROP COLUMN `deleted`;

                ALTER TABLE `customers`
                DROP COLUMN `deleted`;

                ALTER TABLE `downlines`
                DROP COLUMN `deleted`;

                ALTER TABLE `profiles`
                DROP COLUMN `deleted`;

                ALTER TABLE `transactions`
                DROP COLUMN `deleted`;

                ALTER TABLE `users`
                DROP COLUMN `deleted`;

                ALTER TABLE `transactions` DROP FOREIGN KEY `transactions_ibfk_1`;
                ALTER TABLE `transactions` ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`requestor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;";

        DB::unprepared( $sql );
	}

}
