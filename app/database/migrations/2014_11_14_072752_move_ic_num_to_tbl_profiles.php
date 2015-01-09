<?php

use Illuminate\Database\Migrations\Migration;

class MoveIcNumToTblProfiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $sql = "USE `mlm`;
                ALTER TABLE `profiles`
                  ADD COLUMN `ic_num`  varchar(20) NOT NULL AFTER `full_name`,
                  ADD UNIQUE INDEX (`ic_num`) ;

                ALTER TABLE `customers`;
                  DROP COLUMN `ic_num`;";

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
                  ADD COLUMN `ic_num`  varchar(20) NOT NULL AFTER `full_name`,
                  ADD UNIQUE INDEX (`ic_num`) ;

                ALTER TABLE `profiles`
                  DROP COLUMN `ic_num`;";

        DB::unprepared( $sql );
	}

}
