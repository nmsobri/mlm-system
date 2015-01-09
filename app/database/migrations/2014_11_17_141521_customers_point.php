<?php

use Illuminate\Database\Migrations\Migration;

class CustomersPoint extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $sql = "USE `mlm`;
                ALTER TABLE `customers`
                ADD COLUMN `point`  int(255) NOT NULL DEFAULT 0 AFTER `account_num`;";
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
                ALTER TABLE `customers`
                DROP COLUMN `point`;";
        DB::unprepared( $sql );
	}

}
