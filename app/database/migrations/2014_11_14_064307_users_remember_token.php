<?php

use Illuminate\Database\Migrations\Migration;

class UsersRememberToken extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $sql = "USE `mlm`;
                ALTER TABLE `users`
                ADD COLUMN `remember_token`  varchar(100) CHARACTER SET utf8
                COLLATE utf8_general_ci NULL AFTER `groups`;";

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
                ALTER TABLE `users`
                DROP COLUMN `remember_token`;";

        DB::unprepared( $sql );
	}

}
