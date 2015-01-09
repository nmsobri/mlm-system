<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersColumnLastLogin extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $sql = "USE `mlm`;
                ALTER TABLE `users`
                ADD COLUMN `last_login`  datetime NULL AFTER `groups`;";

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
                DROP COLUMN `last_login`;";

        DB::unprepared( $sql );
	}

}
