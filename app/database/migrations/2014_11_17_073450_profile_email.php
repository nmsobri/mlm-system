<?php

use Illuminate\Database\Migrations\Migration;

class ProfileEmail extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $sql = "USE `mlm`;
                ALTER TABLE `profiles`
                ADD COLUMN `email`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `full_name`;";
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
                ALTER TABLE `profiles`
                DROP COLUMN `email`;";
        DB::unprepared( $sql );
	}

}
