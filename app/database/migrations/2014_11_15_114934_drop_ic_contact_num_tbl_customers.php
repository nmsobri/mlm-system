<?php

use Illuminate\Database\Migrations\Migration;

class DropIcContactNumTblCustomers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$sql = "USE `mlm`;
                ALTER TABLE `customers`
                DROP COLUMN `ic_num`,
                DROP COLUMN `contact_num`;
		    ";
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
                ADD COLUMN `ic_num`  varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `user_id`,
                ADD COLUMN `contact_num`  varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `ic_num`;";

        DB::unprepared( $sql );
	}

}
