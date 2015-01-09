<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUserIdDropPkAddCompositePk extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $sql = "USE `mlm`;
                ALTER TABLE `downlines`
                DROP FOREIGN KEY downlines_ibfk_1,
                DROP FOREIGN KEY downlines_ibfk_2,
                CHANGE COLUMN `user_id` `upline_user_id`  int(10) UNSIGNED NOT NULL FIRST,
                DROP PRIMARY KEY, ADD PRIMARY KEY(upline_user_id, downline_user_id),
                ADD FOREIGN KEY downlines_ibfk_112 (`upline_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD FOREIGN KEY downlines_ibfk_211 (`downline_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
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
                ALTER TABLE `downlines`
                DROP FOREIGN KEY downlines_ibfk_3,
                DROP FOREIGN KEY downlines_ibfk_4,
                CHANGE COLUMN `upline_user_id` `user_id`  int(10) UNSIGNED NOT NULL FIRST,
                DROP PRIMARY KEY, ADD PRIMARY KEY(user_id),
                ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD FOREIGN KEY (`downline_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
        DB::unprepared( $sql );
	}

}
